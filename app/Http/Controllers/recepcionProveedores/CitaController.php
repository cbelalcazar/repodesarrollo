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
        $muelles = TMuelle::select('id', 'title', 'eventColor')->get();
        $citas = collect(TCita::select('cit_objcalendarcita')->where('cit_estado', '<>','RECHAZOPROV')->get());
        $citas = array_pluck($citas, 'cit_objcalendarcita');
        $response = compact('programaciones', 'citas', 'muelles', 'array');
        return response()->json($response);
    }

    /**
     * Funcion que crea las citas que ingresan en el calendario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        //Obtengo la informacion de la vista
        $vista = $request->all();
        //Agrupo por fechaGroup
        $collection = collect($vista);
        $agrupadoFecha = $collection->groupBy('fechaGroup');
        $citas = [];
        foreach ($agrupadoFecha as $fecha => $grupoDeCitas) {
            $collection = collect($grupoDeCitas);
            foreach ($grupoDeCitas as $key => $citaVista) {
                $cita['error'] = false;
                $cita['mensaje'] = "";
                // Esto se realiza para identificar si el usuario quiere crear dos citas el mismo dia 
                $filtraCitasProveedor = $collection->where('proveedor', $citaVista['proveedor'])->all();
                if (count($filtraCitasProveedor) > 1) {
                    $cita['error'] = true;
                    $cita['mensaje'] = "Las programaciones del proveedor " . $citaVista['nomProveedor'] . ' para el día ' . $citaVista['fechaGroup'] . ' se encuentran desagrupadas.';
                }

                $cita['cit_fechafin'] = $citaVista['end'];
                $cita['cit_muelle'] = $citaVista['resourceId'];
                $cita['cit_fechainicio']= $citaVista['start'];
                $cita['programaciones'] = $citaVista['programacion'];
                $cita['cit_nitproveedor'] = $citaVista['proveedor'];
                $cita['cit_nombreproveedor'] = $citaVista['nomProveedor'];
                $cita['cit_estado'] = "PENDCONFIRPROVEE";
                $cita['fechaGroup'] = $citaVista['fechaGroup'];
                // Creo un objeto con la cita y se lo asigno a ella misma
                $programacionesId = array_pluck($cita['programaciones'], 'id');
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

                //ESTADO ENVIADO A PROVEEDOR
                array_push($citas, $cita);
                if ($cita['error'] == false) {
                    // Creo la cita en la tabla t_cita
                    $objCita = TCita::Create($cita); 
                    // Genero correo al proveedor
                    //Debe buscar el correo del proveedor y ponerlo en un array $correoProveedor
                    $correoProveedor = ['cabelalcazar@bellezaexpress.com'];
                    Mail::to($correoProveedor)->send(new citaProveedor($cita));                 
                    //Cambio el estado de las programaciones y asigno el id de la cita
                    $estadoNuevo = 3;
                    if ($cita['programaciones'][0]['prg_tipo_programacion'] == "NoProgramable") {
                        $estadoNuevo = 5;
                    }
                    TProgramacion::whereIn('id', $programacionesId)
                                      ->update(['prg_estado' => $estadoNuevo, 'prg_idcita' => $objCita->id, 'prg_envioCorreo' => 'Enviado']);
                }
               
            }
        }
        // Recorro cada uno de los grupos de fechas
        $response = compact('citas', 'programacionesId');
        return response()->json($response);
    }




    /**
     * Funcion que cambia el estado de la programacion cuando en la vista de asginacion de cita se rechaza
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Obtengo el id de lo que quiero editar
        $data = $request->all();
        //ESTADO RECHAZADA 4
        // Realizo el update
        $objProg = TProgramacion::where('id', $id)
                                  ->update(['prg_estado' => 4, 'prg_observacion' => $data['prg_observacion']]);        
        $response = compact('objProg');
        return response()->json($response);
    }


}
