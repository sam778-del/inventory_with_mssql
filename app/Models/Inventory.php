<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $connection = 'sqlsrv_two';

    protected $table = 'dbo.INVE_TESt';

    // protected $primaryKey = 'cod_punto_vendita';

    protected $fillable = [
        'cod_punto_vendita',
        'progressivo_inventario',
        'anno_esercizio',
        'data_inventario',
        'inventario_tipo',
        'flag_invent_avariato_s_n',
        'des__inventario',
        'inventario_chiuso_s_n',
        'flag_congelata_giacenza',
        'data_congelam__giacenza',
        'flag_esportato',
        'data_ultimo_aggiorn_',
        'ora_ultimo_aggior_',
        'utente_ultimo_aggiorn_',
        'segn_stato_record',
    ];

    public $incrementing = false;

    /**
     * Get the user associated with the Inventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'pdv_riferimento', 'cod_punto_vendita');
    }
}
