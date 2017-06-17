<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Importacionesv2\TPermisosImp;
use Redirect;

class TPermisoImpmid
{
    /**
     * Validar permisos de usuario
     * 
     * Revisa todos los request que se realizen hacia el grupo de rutas importacionesV2 y antes de dar acceso a la funcion validar que 
     * tenga permisos en la tabla
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuario = Auth::user();
        $permisos = TPermisosImp::where('perm_cedula', '=', "$usuario->idTerceroUsuario")->first();
        if($permisos == null || $permisos->perm_cargo == 2){
            return Redirect::to("importacionesv2/ConsultaFiltros")
            ->withErrors('No tienes permisos para realizar esta accion');
        }elseif($permisos->perm_cargo == 1){
            return $next($request);
        }
        
    }
}
