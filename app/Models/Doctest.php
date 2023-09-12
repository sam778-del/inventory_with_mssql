<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctest extends Model
{
    protected $connection = 'sqlsrv_two';

    protected $table = 'dbo.DOC_TEST';

    public $incrementing = false;
}
