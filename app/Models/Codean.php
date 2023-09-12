<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codean extends Model
{
    protected $connection = 'sqlsrv_one';

    protected $table = 'dbo.CODEAN';

    public $incrementing = false;

    public function scopeFilterByCode($query, $code)
    {
        return $query->where('cod__esterno', $code);
    }
}
