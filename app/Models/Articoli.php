<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Codean;

class Articoli extends Model
{
    protected $connection = 'sqlsrv_one';

    protected $table = 'dbo.ARTICOLI';

    public $incrementing = false;

    public function codeans()
    {
        return $this->hasMany(Codean::class, 'cod__articolo', 'cod__articolo')
            ->filterByCode($this->codeFilter); // Use the filterByCode scope
    }
}