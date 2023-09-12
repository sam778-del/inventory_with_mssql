<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventrighe extends Model
{
    protected $connection = 'sqlsrv_two';

    protected $table = 'dbo.INVE_RIGhe';

    protected $fillable = [
        'cod_punto_vendita',
        'PROGRESSIVO_INVENTARIO',
        'data_inventario',
        'anno_esercizio',
        'cod__articolo',
        'variante_articolo',
        'descrizione_articolo',
        'unit__di_misura_prezzo',
        'iva',
        'cod_fornitore',
        'differenziatore_fornit_',
        'prezzo_al_pubblico',
        'costo',
        'costo_medio_ponderato',
        'costo_ultimo_pagato',
        'cod_merc_area',
        'c_merc_settore',
        'c_merc_gruppo',
        'c_merc_segmento',
        'cod_merceolog__progres_',
        'reparto_cassa',
        'cod__stato_articolo',
        'cod_tipo_articolo',
        'flag_artic__da_pesare',
        'peso_per_pezzo',
        'prelievo__qta_pz',
        'prelievo_qta_in_kg',
        'congelata_qta_in_pz',
        'congelata_qta_in_kg',
        'data_scadenza',
        'lotto',
        'flag_buono_avariato',
        'cod_terminalino',
        'progressivo_riga',
        'data_ultimo_aggiorn_',
        'ora_ultimo_aggior_',
        'utente_ultimo_aggiorn_',
        'segn_stato_record',
        'inventario_chiuso_s_n',
        'sbilancio',
        'qta_in_kg_anno_precedente',
        'qta_in_pz_anno_precedente',
        'qta_kg_sfrido',
        'qta_pz_sfrido',
        'val_sfrido',
        'qta_kg_calopeso',
        'qta_pz_calopeso',
        'val_calopeso',
        'qta_pz_rett_neg',
        'qta_pz_rett_pos',
        'qta_kg_rett_neg',
        'qta_kg_rett_pos',
        'valore_rett_pos',
        'valore_rett_neg',
        'margine_vendita',
        'margine_vendita_perc',
        'scorta_media',
        'rotazione_scorte',
        'roi_scorte',
        'qta_pz_reso',
        'qta_kg_reso',
        'valore_reso',
        'qta_pz_avariato',
        'qta_kg_avariato',
        'valore_avariato',
        'flag_raggruppamento',
        'raggruppamento',
        'qta_in_kg_acquisti',
        'qta_in_kg_vendite',
        'valore_acquisti',
        'valore_vendite_al_pubbl',
        'qta_pz_acquisti',
        'qta_pz_vendite',
        'immissione_modifica',
    ];

    public $timestamps = false;
}
