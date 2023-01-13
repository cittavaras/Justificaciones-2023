<?php

namespace App\Traits;
use DB;

trait Justificaciones
{


  public function contarJustificaciones($estado){
      $userEmail = (auth()->user()->rol == 2)?'%%':auth()->user()->email;
      $userType  = (auth()->user()->rol == 1)?'correo_cor':'correo_alum';
      $sub = DB::table('justifications')
                  ->select('nfolio')
                  ->where([[$userType,'like',$userEmail],
                           ['estado', 'like', '%'.$estado.'%'],
                           ['correo_cor','not like', '']])
                  ->groupby('nfolio');
      return DB::table( DB::raw("({$sub->toSql()}) as sub") )
      ->mergeBindings($sub)
      ->count();
  }

  public function listarJustificacionesPorEstado($estado){
    $userType  = (auth()->user()->rol == 1)?'correo_cor':'correo_alum';
    return DB::table('justifications')
    ->select('nfolio',DB::raw('DATE_FORMAT(fec_sol,"%d-%m-%Y") as fec_sol'),'motivo', 'RUT_ALU','NOMBRE_ALUM','ESTADO', 'FEC_JUS', 'CORREO_COR')
    ->where([[$userType,'like', auth()->user()->email],
             ['estado', 'like', '%'.$estado.'%'],
             ['correo_cor','!=', ' ']])
    ->groupby('nfolio',DB::raw('DATE_FORMAT(fec_sol,"%d-%m-%Y")'),'motivo', 'RUT_ALU','NOMBRE_ALUM','ESTADO', 'FEC_JUS', 'CORREO_COR')
    ->orderby('fec_sol', 'desc')
    ->get();
  }
}

 ?>
