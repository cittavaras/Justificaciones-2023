<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
  public $table = 'files';
  protected $fillable = [
    'nombre',
    'ubicacion',
    'tipo',
    'tamaño',
    'id_justificacion'
  ];

}
