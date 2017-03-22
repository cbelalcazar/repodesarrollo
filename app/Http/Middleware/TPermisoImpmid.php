<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\Importacionesv2\TPermisosImp;
use Redirect;

class TPermisoImpmid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuario = Auth::user();
        $permisos = TPermisosImp::where('perm_cedula', '=',"$usuario->idTerceroUsuario")->first();
        if($permisos == null || $permisos->perm_cargo == 2){
            return Redirect::to("importacionesv2/ConsultaFiltros")
            ->withErrors('No tienes permisos para realizar esta accion');
        }elseif($permisos->perm_cargo == 1){
            return $next($request);
        }
        
    }
}
