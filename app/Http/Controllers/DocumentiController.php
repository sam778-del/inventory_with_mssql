<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornitor;
use App\Models\Doctest;
use Validator;

class DocumentiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('documenti.index');
    }

    public function searchFatura(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partita_iva' => 'required'
        ], [
            'partita_iva.required' => 'Il campo Partita Iva è obbligatorio',
        ]);

        if($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            $result = Fornitor::where('piva', '=', $request->partita_iva)
                        ->get(['tipologia_documento_predefinita_su_acquisti', 'cod_fornitore', 'differenziatore_fornit_', 'ragione_sociale_forn_', 'DESTINATARIO_MERCE_RAGIONE_SOCIALE', 'DEST_MERCE_INDIRIZZO', 'DEST_MERCE_LUOGO']);
            
            return view('documenti.index', compact('result'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }        
    }

    public function store(Request $request)
    {
        if($request->tipologia_documento_predefinita_su_acquisti == 'DDT - Documento di trasporto - - 0 -') {
            $cod_natura_documento = 'DDT';
        }elseif($request->tipologia_documento_predefinita_su_acquisti == 'FAT - Fattura accompagnatoria - - 0 -') {
            $cod_natura_documento = 'FAT';
        }else {
            $cod_natura_documento = 'DDT';
        }

        try {
            $document = new Doctest;
            $document->DOC_NUMERO_DOCUMENTO = $request->input('DOC_NUMERO_DOCUMENTO');
            $document->DOC_ACCOMP_num = 0;
            $document->DOC_ACCOMP_data = 0;
            $document->COD_NATURA_DOCUMENTO = $cod_natura_documento;
            $document->DATA_DOCUMENTO = $request->input('DATA_DOCUMENTO');
            $document->CODICE_PUNTO_VENDITA = Auth::user()->pdv_riferimento;
            $document->codice_testata = $request->input('codice_testata');
            $document->COD_DESTINATARIO = Auth::user()->pdv_riferimento;
            $document->DIF_DESTINATARIO = 1;
            $document->cod_cliente_consegna = Auth::user()->pdv_riferimento;
            $document->cod_fornitore = $request->input('cod_fornitore');
            $document->SCORPORO_IVA = NULL;
            $document->INDIRIZZO_CONS_PREF = NULL;
            $document->INDIRIZZO_CONS_DENOM = NULL;
            $document->INDIRIZZO_CONS_NUM_CIV = NULL;
            $document->INDIRIZZO_CONSEGNA_CAP = NULL;
            $document->INDIRIZZO_CONS_LOC = NULL;
            $document->INDIRIZZO_CONS_PROV = NULL;
            $document->CAUSALE_TRASPORTO = NULL;
            $document->NUMERO_COLLI_FISCALI = NULL;
            $document->COD_TRASPORTATORE = NULL;
            $document->ORA_PARTENZA_MERCE = NULL;
            $document->DATA_PARTENZA_MERCE = NULL;
            $document->DESCR_ASPETTO_EST_BENI = NULL;
            $document->COD_TIPO_PAGAMENTO = NULL;
            $document->COD_TIPO_MOD_PAG = NULL;
            $document->DATA_DECORRENZA_MOD_PAG = NULL;
            $document->MAGAZZINO_DI_PARTENZA = NULL;
            $document->FLAG_STATO_DOCUMENTO = 'S';
            $document->totale_imponibile = '0';
            $document->totale_ivato = '0';
            $document->NOTE = NULL;
            $document->DATA_ULTIMO_AGGIORN_ = NULL;
            $document->SEGN_STATO_RECORD = '1';
            $document->file_carico = NULL;
            $document->FORNITORE_FATTURA = NULL;
            $document->CLIENTE_FATTURA = NULL;
            $document->TIPO_PAGAMENTO = 'NON CONVENUTO';
            $document->PAGATA = '0';
            $document->tipo_documento = NULL;
            $document->fatturata = '0';
            $document->acquisita = '0';
            $document->tipologia_documento = 'A';
            $document->fattura_riferimento_numero = NULL;
            $document->fattura_riferimento_data = '0';
            $document->data_ultimo_export = now()->format('Ymd');
            $document->tipologia_documento_estesa = NULL;
            $document->variazioni_generate = 'N';
            $document->miniterminale = '1';
            $document->stampata = 'N';
            $document->quadrata = '0';
            $document->progressivo_serie = NULL;
            $document->decreto_legislativo = NULL;
            $document->causale_documento = 'vendita';
            $document->diff_fornitore = $request->input('differenziatore_fornit_');
            $document->destinazione_riga1 = NULL;
            $document->destinazione_riga2 = NULL;
            $document->destinazione_riga3 = NULL;
            $document->data_movimentazione = NULL;
            $document->responsabile_carico_scarico = Auth::user()-cf;
            $document->listino_prezzi = 'A';
            $document->data1_scadenza_pagamento = NULL;
            $document->importo_scadenza1 = NULL;
            $document->data2_scadenza_pagamento = NULL;
            $document->importo_scadenza2 = NULL;
            $document->desinenza = 0;
            $document->integrazione_file_finanziario = NULL;
            $document->RICHIESTA_STAMPA = NULL;
            $document->RIFERIMENTO_TERMINALE = NULL;
            $document->RIFERIMENTO_TERMINALE_CODIFICATO = NULL;
            $document->LISTINO_VENDITA_PREDEFINITO = 0;
            $document->FLAG_RICARICO = 0;
            $document->RICARICO_PERC = 0;
            $document->SORGENTE_RICARICO = "";
            $document->firma = NULL;
            $document->doc_firmato = NULL;
            $document->fattura_elettronica = NULL;
            $document->split_payment = NULL;
            $document->xml_generato = NULL;
            $document->fattura_da_scontrino = NULL;
            $document->riferimento_scontrino = NULL;
            $document->save();
            return redirect()->back()->with('success', __('Registrazione inserita'));
        } catch (\Exception $e) {
            return $e->getMessage();
            //return redirect()->back()->with('error', __('Errore durante l\'elaborazione della tua richiesta'));
        }
    }
}
