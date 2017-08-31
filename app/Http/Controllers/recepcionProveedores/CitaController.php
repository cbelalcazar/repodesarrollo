<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recepcionProveedores\TProgramacion;
use App\Models\recepcionProveedores\TCita;
use App\Models\recepcionProveedores\TMuelle;
use Mail;
use App\Mail\citaProveedor;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulo = 'ASIGACION DE CITA';
        $ruta = 'Cita // Asignacion de cita';
        return view('layouts.recepcionProveedores.cita.citaIndex', compact('titulo', 'ruta'));
    }

     /**
     * Respuesta JSON a la peticion ajax que solicita los proveedores las programaciones creadas cuando se carga por primera ves la vista
     *
     * @return \Illuminate\Http\Response
     */
    public function citaGetInfo()
    {
        $programaciones = TProgramacion::where('prg_estado', '2')->orderBy('prg_fecha_programada', 'asc')->get();
        $programaciones = $programaciones->groupBy('prg_fecha_programada');        
        $muelles = TMuelle::select('mu_abreviatura AS id', 'title')->get();
        $citas = collect(TCita::select('cit_objcalendarcita')->get());
        $citas = array_pluck($citas, 'cit_objcalendarcita');
        $response = compact('programaciones', 'citas', 'muelles', 'array');
        return response()->json($response);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vista = $request->all();
        $collection = collect($vista);
        $agrupadoFecha = $collection->groupBy('fechaGroup');
        $citas = [];
        foreach ($agrupadoFecha as $key => $value) {
            $dato = collect($value);
            $agrupadoProvFech = $dato->groupBy('proveedor');
            $bandera = false;
            $final = "";
            $mensaje = "";            
            $cita = [];
            foreach ($agrupadoProvFech as $key => $value) {                 
                foreach ($value as $clave => $prog) {  
                    if ($clave == 0) {
                        $final = $prog['end'];
                        $muelle = $prog['resourceId'];
                        $cita['cit_muelle'] = $muelle;
                        $cita['cit_fechainicio']= $prog['start'];
                        $cita['programaciones'] = $value;
                        $cita['cit_nitproveedor'] = $prog['proveedor'];
                        $cita['cit_nombreproveedor'] = $prog['nomProveedor'];
                        $cita['cit_estado'] = "PENDCONFIRPROVEE";
                        $cita['fechaGroup'] = $prog['fechaGroup'];
                        $cita['error'] = false;

                        $bandera = true;
                        if (count($value) == 1) {
                            $cita['cit_fechafin'] = $prog['end'];

                        }
                    }

                    if ($clave > 0) {
                       if($final != $prog['start'] || $muelle != $prog['resourceId']){
                        $bandera = false;
                       }                   
                       if ($bandera == false) {
                           $cita['error'] = true;
                           $cita['mensaje'] = "Las programaciones del proveedor " . $prog['nomProveedor'] . ' para el día ' . $prog['fechaGroup'] . ' se encuentran desagrupadas.'; 
                           break;
                       }elseif($bandera == true){
                           $final = $prog['end'];
                           $muelle = $prog['resourceId'];
                           $cita['cit_fechafin'] = $prog['end'];
                       }                  
                    }

                }

                if ($cita['error'] == true) {
                    array_push($citas, $cita);
                }else{
                    $programacionesId = array_pluck($cita['programaciones'], 'programacion');
                    $jsonCita = [
                                'end'                       => $cita['cit_fechafin'],
                                'start'                     => $cita['cit_fechainicio'],
                                'stick'                     => true,
                                'overlap'                   => false,
                                'editable'                  => false,
                                'estado'                    => $cita['cit_estado'],
                                'resourceId'                => $cita['cit_muelle'], 
                                'title'                     => $cita['cit_nitproveedor'] . ' - ' .  $cita['cit_nombreproveedor'],
                                'backgroundColor'           => '#696969' , 
                                'borderColor'               => '#696969' , 
                                'programaciones'            => $programacionesId,
                                'fechaGroup'                => $cita['fechaGroup'], 
                                ];
                    $cita['cit_objcalendarcita'] = json_encode($jsonCita);
                    $objCita = TCita::Create($cita); 
                    //ESTADO ENVIADO A PROVEEDOR
                    TProgramacion::whereIn('id', $programacionesId)
                                  ->update(['prg_estado' => 3, 'prg_idcita' => $objCita->id]);                
                    array_push($citas, $cita);
                    //Debe buscar el correo del proveedor y ponerlo en un array $correoProveedor
                    $correoProveedor = ['cabelalcazar@bellezaexpress.com'];
                    Mail::to($correoProveedor)->send(new citaProveedor($cita));
                }
                
            }            
        }
       
        $response = compact('citas');
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
        //
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
        //ESTADO RECHAZADA 4
        $objProg = TProgramacion::where('id', $id)
                                  ->update(['prg_estado' => 4, 'prg_observacion' => $data['prg_observacion']]);        
        $response = compact('objProg');
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
}
