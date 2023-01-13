<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    const CREATED_AT = 'fec_sol';
    const CREATED_ON = 'fecha_sol';
    const UPDATED_AT = 'updated_at';
    public $primaryKey = 'ID_DATO';
    
    public function scopeWhereFolio($query, $folio)
    {
        return $query->where('nfolio', $folio);
    }
}
