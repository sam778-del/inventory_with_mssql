<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Articoli;
use App\Models\Codean;
use App\Models\Inventrighe;
use Auth;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inventory.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $inventory = Inventory::where('inventario_chiuso_s_n' , '=', 'N')
                        ->where('cod_punto_vendita', '=', Auth::user()->pdv_riferimento)
                        ->get();

            return Datatables::of($inventory)
                        ->addColumn('radio', function(Inventory $inventory) {
                            $html = '';
                            $html .= '<a href=" '. route("inventory.create", "key=".Crypt::encryptString($inventory)) . '" class="btn btn-primary btn-sm">';
                            $html .= '<i class="bi bi-plus-lg"></i>';
                            //$html .= __('Aggiungi');
                            $html .= '</a>';
                            return $html;
                        })
                        ->addColumn('operatore', function(Inventory $inventory) {
                            return $inventory->user->nome;
                        })
                        ->editColumn('cod_punto_vendita', function(Inventory $inventory) {
                            return $inventory->cod_punto_vendita;
                        })
                        ->rawColumns(['radio', 'operatore', 'cod_punto_vendita'])
                        ->toJson();
        }
    }

    public function getDataByBarcode(Request $request)
    {
        try {
            $cod_articolo = count($this->splitCharacter($request->barcode_number)) === 2 ? $this->splitCharacter($request->barcode_number)[0] : NULL;
            $variente_articolo = count($this->splitCharacter($request->barcode_number)) === 2 ? $this->splitCharacter($request->barcode_number)[1] : NULL;

            $resultsQuery = Articoli::select('t1.aliquota_iva', 't1.flag_artic__da_pesare', 't1.peso_per_pezzo', 't1.flag_artic__da_pesare', 't1.cod_tipo_articolo', 't1.cod_stato_articolo', 't1.cod_ragg_reparto_casse', 't1.cod_merceolog__progres_', 't1.c_merc_segmento', 't1.c_merc_gruppo', 't1.c_merc_settore', 't1.cod_merc_area', 't1.differenziatore_fornit_', 't1.cod__articolo', 't1.cod_fornitore', 't1.variante_articolo', 't1.descrizione_articolo', 't1.unit__di_misura_prezzo')
                        ->from('articoli as t1')
                        ->distinct()
                        ->join('codean as t2', function ($join) use ($request) {
                            $join->on('t1.cod__articolo', '=', 't2.cod__articolo')
                                ->on('t1.variante_articolo', '=', 't2.variante_articolo');
                                // ->where('t2.cod__esterno', intval($request->barcode_number));
                        });

            if(count($this->splitCharacter($request->barcode_number)) != 2 && $this->checkEAN($request->barcode_number) == false) {
                $resultsQuery->where('t2.cod__esterno', '=', intval($this->transformEAN($request->barcode_number)));
            }
            
            if (count($this->splitCharacter($request->barcode_number)) === 2 && $this->checkEAN($request->barcode_number) == false) {
                $resultsQuery->where('t1.cod__articolo', '=', $cod_articolo);
            }

            if (count($this->splitCharacter($request->barcode_number)) === 2 && $this->checkEAN($request->barcode_number) == false) {
                $resultsQuery->where('t1.variante_articolo', '=', $variente_articolo);
            }

            if($this->checkEAN($request->barcode_number)) {
                $resultsQuery->where('t1.cod__articolo', '=', substr(strip_tags($this->checkEAN($request->barcode_number)['part2']), 0, 6))
                ->where('t1.variante_articolo', '=', $this->checkEAN($request->barcode_number)['part3']);
            }

            $results = $resultsQuery->get();
            
            if(count($results) == 0) {
                return response()->json(["status" => false, "msg" => "Nessun record trovato" ], 404);
            }
                
            return response()->json(["status" => true, "msg" => $results ], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => false, "msg" => $e->getMessage() ], 503);
        }
    }

    public function transformEAN($ean) {
        if (strpos($ean, '20') === 0 && strlen($ean) >= 13) {
            return substr($ean, 0, 7);
        }
        return $ean;
    }

    public function checkEAN($number)
    {
        $number = trim($number); // Remove any leading/trailing whitespace

        if (strlen($number) !== 13 || !is_numeric($number)) {
            return false; // Not a valid 13-digit number
        }

        if (strpos($number, "7987") === 0) {
            $part2 = substr($number, 4, 6);
            $part3 = substr($number, 10, 2);
    
            return [
                'part2' => $part2,
                'part3' => substr($part3, 0, 1) == 0 ? substr($part3, 1, 1) : substr($part3, 0, 2)
            ];
        } else {
            return false;
        }
    }

    public function checkEanSeven($number)
    {
        $number = trim($number); // Remove any leading/trailing whitespace

        if (strlen($number) !== 13 || !is_numeric($number)) {
            return false; // Not a valid 13-digit number
        }

        if (strpos($number, "20") === 0) {
            return substr($number, 0, 7);
        }else {
            return false;
        }
    }

    public function updateIfExists(Request $request)
    {
        try {
            $results = Inventrighe::where('cod_punto_vendita', '=', $request->cod_punto_vendita)
                        ->where('anno_esercizio', '=', $request->anno_esercizio)
                        ->where('PROGRESSIVO_INVENTARIO', '=', $request->progressivo_inventario)
                        ->where('cod__articolo', '=', $request->cod__articolo)
                        ->where('variante_articolo', '=', $request->variante_articolo)
                        ->update([
                            'utente_ultimo_aggiorn_' => substr(strip_tags(Auth::user()->cf), 0, 10),
                            'prelievo__qta_pz' => $request->um === 'PZ' ? number_format($request->quantity, 2) : 0,
                            'prelievo_qta_in_kg' => $request->um === 'KG' ? number_format($request->quantity, 2) : 0,
                            'cod_terminalino' => substr(strip_tags($this->getClientMac()), 0, 6), // Assuming you are using Laravel's authentication
                            'immissione_modifica' => Carbon::now()->format('Y-m-d\TH:i:s.v'), // Current timestamp
                        ]);

            if(!$results) {
                return response()->json(["status" => false, "msg" => "Nessun record trovato" ], 404);
            }
            return response()->json(["status" => true, "msg" => "Registro aggiornato" ], 200);
        }catch (\Exception $e) {
            return response()->json(["status" => false, "msg" => $e->getMessage() ], 503);
        }
    }

    public function checkIfExists(Request $request)
    {
        try {
            $results = Inventrighe::where('cod_punto_vendita', '=', $request->cod_punto_vendita)
                        ->where('anno_esercizio', '=', $request->anno_esercizio)
                        ->where('PROGRESSIVO_INVENTARIO', '=', $request->progressivo_inventario)
                        ->where('cod__articolo', '=', $request->cod__articolo)
                        ->where('variante_articolo', '=', $request->variante_articolo)
                        ->first();

            if(!$results) {
                return response()->json(["status" => false, "msg" => "Nessun record trovato" ], 404);
            }

            return response()->json(["status" => true, "msg" => $results ], 200);
        }catch (\Exception $exception) {
            return response()->json(["status" => false, "msg" => "Errore durante l'elaborazione della tua richiesta" ], 503);
        }
    }

    public function splitCharacter($code)
    {
        return explode(".", $code);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if(isset($request->key) && empty($request->key)) {
            return redirect()->back()->with('error', __('Errore durante l\'elaborazione della tua richiesta'));
        }

        try {
            $data = json_decode(Crypt::decryptString($request->key), true);
            return view('inventory.create', compact('data'));
        } catch (\Exception $th) {
            return redirect()->back()->with('error', __('Errore durante l\'elaborazione della tua richiesta'));
        };
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $inve_righe                     = new Inventrighe;
            $inve_righe->cod_punto_vendita  = intval($request->cod_punto_vendita);
            $inve_righe->PROGRESSIVO_INVENTARIO = intval($request->progressivo_inventario);
            $inve_righe->anno_esercizio = $request->anno_esercizio;
            $inve_righe->cod__articolo = intval($request->codice_articolo);
            $inve_righe->variante_articolo = $request->variante_articolo;
            $inve_righe->descrizione_articolo = Str::limit($request->description, 32, '..');
            $inve_righe->unit__di_misura_prezzo = $request->um;
            $inve_righe->cod_fornitore = intval($request->cod_fornitore);
            $inve_righe->differenziatore_fornit_ = $request->differenziatore_fornit_;
            $inve_righe->prezzo_al_pubblico = 0;
            $inve_righe->costo = 0;
            $inve_righe->costo_medio_ponderato = 0;
            $inve_righe->costo_ultimo_pagato = 0;
            $inve_righe->iva = intval($request->iva);
            $inve_righe->cod_merc_area = intval($request->cod_merc_area);
            $inve_righe->c_merc_settore = intval($request->c_merc_settore);
            $inve_righe->c_merc_gruppo = intval($request->c_merc_gruppo);
            $inve_righe->c_merc_segmento = intval($request->c_merc_segmento);
            $inve_righe->cod_merceolog__progres_ = intval($request->cod_merceolog__progres_);
            $inve_righe->reparto_cassa = $request->cod_ragg_reparto_casse;
            $inve_righe->cod__stato_articolo = $request->cod_stato_articolo;
            $inve_righe->cod_tipo_articolo = $request->cod_tipo_articolo;
            $inve_righe->flag_artic__da_pesare = $request->flag_artic__da_pesare;
            $inve_righe->peso_per_pezzo = !empty($request->peso_per_pezzo) ? $request->peso_per_pezzo : 0;
            $inve_righe->prelievo__qta_pz = ($request->um != 'KG') ? $request->quantita : '0';
            $inve_righe->prelievo_qta_in_kg = ($request->um == 'KG') ? $request->quantita : '0';
            $inve_righe->data_inventario = $request->data_inventario;
            $inve_righe->data_scadenza = '99991231';
            $inve_righe->lotto = '';
            $inve_righe->flag_raggruppamento = 0;
            $inve_righe->raggruppamento = 0;
            $inve_righe->flag_buono_avariato = 'B';
            $inve_righe->cod_terminalino = substr(strip_tags($this->getClientMac()), 0, 6);
            $inve_righe->data_ultimo_aggiorn_ = substr(strip_tags(date('Ymd')), 0, 8);
            $inve_righe->ora_ultimo_aggior_ = Carbon::now()->hour;
            $inve_righe->utente_ultimo_aggiorn_ = substr(strip_tags(Auth::user()->cf), 0, 10);
            $inve_righe->segn_stato_record = 1;
            $inve_righe->immissione_modifica = Carbon::now()->format('Y-m-d\TH:i:s.v');
            $inve_righe->save();
            return redirect()->back()->with('success', __('Registrazione inserita'));
        } catch (\Exception $e) {
            // return $e->getMessage();
            return redirect()->back()->with('error', __('Errore durante l\'elaborazione della tua richiesta'));
        }
    }

    public function getClientMac()
    {
        $mac = 'UNKNOWN';
        foreach(explode("\n",str_replace(' ','',trim(`getmac`,"\n"))) as $i)
        if(strpos($i,'Tcpip')>-1){$mac=substr($i,0,17);break;}
        return $mac;
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
