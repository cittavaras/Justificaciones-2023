<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubirImagen extends Model
{
    //
    protected $table = 'documento';
    public $primaryKey = 'id_documento';
    public $timestamps = false;
}
