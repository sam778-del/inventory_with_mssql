<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornitor extends Model
{
    protected $connection = 'sqlsrv_one';

    protected $table = 'dbo.FORNITOR';

    public $incrementing = false;
}
