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

class ListaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $key = $request->key;
        return view('lista.index', compact('key'));
    }

    public function backView(Request $request)
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

    public function datatables(Request $request)
    {
        if($request->ajax())
        {
            $lista = Inventrighe::where('utente_ultimo_aggiorn_', '=', substr(strip_tags(Auth::user()->cf), 0, 10))
                     ->get();

            return Datatables::of($lista)
                    ->addColumn('quantita', function(Inventrighe $lista) {
                        switch ($lista->unit__di_misura_prezzo) {
                            case 'PZ':
                                return $lista->prelievo__qta_pz;
                                break;
                            case 'KG':
                                return $lista->prelievo_qta_in_kg;
                                break;
                            default:
                                return $lista->prelievo__qta_pz;
                                break;
                        }
                    })
                    ->rawColumns(['quantita'])
                    ->toJson();
        }
    }
}
