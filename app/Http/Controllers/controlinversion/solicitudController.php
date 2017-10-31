<?php

namespace App\Http\Controllers\controlinversion;

use App\Models\controlinversion\TSolicitudctlinv;
use App\Models\controlinversion\TSolicliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BESA\lineasProducto;
use App\Models\controlinversion\TFacturara;
use App\Models\controlinversion\TTiposalida;
use App\Models\controlinversion\TTipopersona;
use App\Models\controlinversion\TCargagasto;
use App\Models\controlinversion\TLineascc;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TItemCriteriosTodo;
use App\Models\BESA\VendedorZona;
use App\Models\BESA\PreciosReferencias;
use Illuminate\Support\Facades\Auth;


class solicitudController extends Controller
{

    /**
     * Consulta y retorna a la vista en formato JSON, Cargue Inicial
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function solicitudGetInfo()
    {
        $userLogged = Auth::user();

        $personas = TFacturara::with('tercero')->get();

        $tiposalida = TTiposalida::where('tsd_estado', '1')->get();

        $tipopersona = TTipopersona::where('tpe_estado', '1')->get();

        $cargagasto = TCargagasto::where('cga_estado', '1')->get();

        $lineasproducto = TLineascc::with('LineasProducto')->where('lcc_centrocosto','!=','0')->get();

        $pruebita = TSolicliente::with('clientesZonas')->get();


        $colaboradores = Tercero::select('idTercero','idTercero as scl_cli_id', 'razonSocialTercero as scl_nombre')->with('Cliente.Sucursales')->where([['indxEstadoTercero', '1'], ['indxEmpleadoTercero', '1']])->orderBy('razonSocialTercero')->get();
        $colaboradores = $colaboradores->filter(function($value, $key){
            return ($value['Cliente'] != null && $value['Cliente']['Sucursales'] != null && count($value['Cliente']['Sucursales']) > 0 && strlen($value['idTercero']) > 5);
        })->values();

        $vendedoresBesa= VendedorZona::select('NitVendedor as scl_cli_id', 'NomVendedor as scl_nombre', 'NomZona', 'CodZona as scz_zon_id')->where('estado', 1)->get();

        $item = TItemCriteriosTodo::select('ite_referencia as srf_referencia',
        'ite_descripcion as referenciaDescripcion',
        'ite_nom_estado as srf_estadoref',
        'ite_nom_linea as referenciaLinea',
        'ite_cod_linea as srf_lin_id_gasto')
        ->where('ite_cod_tipoinv', '1051')
        ->get();

        $response = compact('personas','tiposalida', 'tipopersona', 'cargagasto', 'lineasproducto', 'colaboradores', 'users', 'item', 'vendedoresBesa', 'userLogged', 'pruebita');
        return response()->json($response);
    }



    public function consultarInformacionReferencia($referencia){
      $infoRefe = PreciosReferencias::consultarReferencia($referencia);
      $response = compact('infoRefe');
      return response()->json($response);
    }


    public function consultarInformacionReferencias(Request $request){

      //return response()->json($request->all());
      $infoRefes = PreciosReferencias::consultarReferencias($request);
      $response = compact('infoRefes');
      return response()->json($response);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruta = 'Control de Inversion // Crear Solicitud';
        $titulo = 'CREAR SOLICITUD';
        return view('layouts.controlinversion.solicitud.formsolicitud', compact('ruta','titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $routeSuccess = route('misSolicitudes');
        $data = $request->all();
        $solicitudToCreate = TSolicitudctlinv::create($data);

        foreach ($data['personas'] as $key => $value) {
          $objeto = $solicitudToCreate->clientes()->create($value);
          $zona = [];
          $zona['scl_scz_id'] = $objeto['scl_id'];
          $zona['scz_zon_id'] = $value['scz_zon_id'];
          $zona['scz_porcentaje'] = 100;
          $zona['scz_porcentaje_real'] = null;
          $zona['scz_vdescuento'] = null;
          $zona['scz_vesperado'] = null;
          $zona['scz_estado'] = 1;
          $objetoZonas = $objeto->clientesZonas()->create($zona);

          foreach ($value['solicitud']['referencias'] as $clave => $dato) {
            $objeto->clientesReferencias()->create($dato);
          }


        }

        $response = compact('solicitudToCreate', 'routeSuccess');
        return response()->json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $ruta = 'Control de Inversion // Editar Solicitud';
      $titulo = 'EDITAR SOLICITUD';
      $solicitud = TSolicitudctlinv::with('clientes.clientesReferencias')->with('clientes.clientesZonas')->where('sci_id', $id)->get();
      $response = compact('ruta', 'titulo', 'solicitud');

      return view('layouts.controlinversion.solicitud.formsolicitud', $response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $solicitudPrincipal = TSolicitudctlinv::find($id)->update($data);
        $clientes = TSolicliente::where('scl_sci_id', $id)->get();

        foreach ($clientes as $key => $cliente) {
          $cliente->clientesZonas()->delete();
          $cliente->clientesReferencias()->delete();
          $cliente->delete();
        }

        $solicitudToCreate = TSolicitudctlinv::find($id);
        foreach ($data['personas'] as $key => $value) {
          $objeto = $solicitudToCreate->clientes()->create($value);
          $zona = [];
          $zona['scl_scz_id'] = $objeto['scl_id'];
          $zona['scz_zon_id'] = $value['clientes_zonas']['scz_zon_id'];
          $zona['scz_porcentaje'] = 100;
          $zona['scz_porcentaje_real'] = null;
          $zona['scz_vdescuento'] = null;
          $zona['scz_vesperado'] = null;
          $zona['scz_estado'] = 1;
          $objetoZonas = $objeto->clientesZonas()->create($zona);

          foreach ($value['solicitud']['referencias'] as $clave => $dato) {
            $objeto->clientesReferencias()->create($dato);
          }
        }
        $response = compact('solicitudToCreate');
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function misSolicitudes()
    {
        //
        $ruta = 'Control de Inversion // Mis solicitudes';
        $titulo = 'Mis solicitudes - Obsequios y muestras';
        return view('layouts.controlinversion.solicitud.misSolicitudes', compact('ruta','titulo'));
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getInfoMisolicitudes()
    {
        //esto debe filtrar por usuario campo sci_usuario y sci_tipo 3,7 idTerceroUsuario
        $userLogged = Auth::user();

        $solicitudes = TSolicitudctlinv::with('estado', 'tipoSalida', 'tipoPersona', 'cargara', 'facturara.tercero')->where('sci_usuario',$userLogged->idTerceroUsuario)->orderBy('sci_id', 'desc')->get();

        $solicitudes->map(function($solicitud){
            $id = $solicitud->sci_id;
            $solicitud->rutaEdit = route('solicitud.edit', ['id' => $id]);
            return $solicitud;
        });

        $response = compact('solicitudes');
        return response()->json($response);
    }




}
