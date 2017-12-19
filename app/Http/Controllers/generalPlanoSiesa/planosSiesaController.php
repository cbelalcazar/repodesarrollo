<?php

namespace App\Http\Controllers\generalPlanoSiesa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class planosSiesaController extends Controller
{
    public $estructura;
    public $grupo;
    public $arrayErrores;
    public $txtXml;
    public $txtPlano;

    public $nomConexion = "pruebas";
    public $idCia = "1";
    public $usuario = "oolaya";
    public $clave = "year2015";
    public $consecutivo = 2;

    public function setEstructura($estructura)
    {
        $this->estructura = $estructura;
    }

    public function setNomConexion($nomConexion)
    {
        $this->nomConexion = $nomConexion;
    }

    public function setIdCia($idCia)
    {
        $this->idCia = $idCia;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;
    }


    public function generarLineaInicial($inicio = "0000001", $parametroDefaultCadena = '00000001001'){

        $this->txtXml .=  "<Linea>" . $inicio . $parametroDefaultCadena. "</Linea>";
        $this->txtPlano .= $inicio . $parametroDefaultCadena;
        $this->txtPlano .= chr(13) . chr(10);
    }

    public function generarLineaFinal($longitudTotal = 18, $parametroDefaultCadena = '99990001001'){
        $longitud = strlen($parametroDefaultCadena) + strlen(strval($this->consecutivo));
        $faltante = $longitudTotal - $longitud;
        $consecutivoConCeros = str_pad($this->consecutivo, 7, '0', STR_PAD_LEFT);
        $this->txtXml .= "<Linea>" . $consecutivoConCeros . $parametroDefaultCadena . "</Linea>";
        $this->txtPlano .= $consecutivoConCeros . $parametroDefaultCadena;
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function validaArreglos($arreglo){

        // Convierte el arreglo en una coleccion para poder aplicar funciones de laravel
        $lista = collect($arreglo[1]);

        // Setea las variables globales gruuupo y arrayErrores
        $this->grupo = $arreglo[0]['tipoDocumento'];
        $this->arrayErrores = [];
        $this->txtXml .= "<Linea>";

        // Realiza un map sobre cada elemento del arreglo enviado desde la vista 
        $listaNew = $lista->map(function($value, $key){ 

            // Compara cada indice de la tabla con lo parametrizado en la tabla de la base de datos con el objetivo de validar la integridad del nombre
            $encontrarRegla = collect($this->estructura)->where('dco_nombre', $key)->where('dco_grupo', $this->grupo)->values()->all();
            if (count($encontrarRegla) == 0) {
                array_push($this->arrayErrores, "El elemento ". $key . " no coincide con ningun elemento de la base de datos"); 
            }else{

                if ($value == 'default') {
                    $value = $this->convertirSegunTipoDato($encontrarRegla[0], $encontrarRegla[0]['dco_segmento']);
                }elseif($value == 'vacio'){
                    $value = $this->convertirSegunTipoDato($encontrarRegla[0], "");
                }elseif($value == 'consecutivo'){
                    $value = $this->convertirSegunTipoDato($encontrarRegla[0], $this->consecutivo);
                    $this->consecutivo++;
                }else{
                    $value = $this->convertirSegunTipoDato($encontrarRegla[0], $value);
                }

                if (isset($value['error'])) {
                        array_push($this->arrayErrores, $value['error']); 
                }

                $this->txtXml .= $value;
                $this->txtPlano .= $value;

            }

            return $value;     

        })->all();


        // Obtiene la cantidad de reglas existentes en la base de datos
        $cantReglasBd = count(collect($this->estructura)->where('dco_grupo', $this->grupo)->all());
        // Obtiene la cantidad de reglas definidas por el desarrollador
        $cantReglasDefinidas = count($listaNew);
        // Realizo validacion cantidad de reglas en bd con cantidad de reglas definidas, deben ser iguales si no error
        if ($cantReglasBd != $cantReglasDefinidas) {
            array_push($this->arrayErrores, "La cantidad de registros en base de datos es " . $cantReglasBd . " y la cantidad de registros enviados en arreglo es " . $cantReglasDefinidas . " Ambas deben tener la misma cantidad"); 
        }

        $this->txtXml .= "</Linea>" .chr(13) . chr(10);
        $this->txtXml .= chr(13) . chr(10);
        $this->txtPlano .= chr(13) . chr(10);
        $this->txtPlano .= chr(13) . chr(10);

        $arreglo[0]['arrayErrores'] = $this->arrayErrores;
        $arreglo[0]['txtLineaGenerada'] = $this->arrayErrores;
        $arreglo[1] = $listaNew;
        
        return $arreglo;
    }



    public function convertirSegunTipoDato($elemento, $valor){

        if ($elemento['dco_tipo'] == 'integer') {
            $dato = str_pad($valor, $elemento['dco_longitud'], '0', STR_PAD_LEFT);
        }
        elseif($elemento['dco_tipo'] == 'string'){
            $dato = str_pad($valor, $elemento['dco_longitud'], ' ', STR_PAD_RIGHT);
        }else{
            $dato['error'] = "El elemento " . $elemento['dco_campo'] . " de la base de datos, presenta el tipo de dato (" . $elemento['dco_tipo'] . ") no parametrizado para la generacion de planos";
        }

        return $dato;
    }

    public function generarLineatxt(){

        $xml = "<Importar>" . chr(13) . chr(10);
        $xml .= "<NombreConexion>". $this->nomConexion ."</NombreConexion>" . chr(13) . chr(10);
        $xml .= "<IdCia>". $this->idCia . "</IdCia>" . chr(13) . chr(10);
        $xml .= "<Usuario>" . $this->usuario .  "</Usuario>" . chr(13) . chr(10);
        $xml .= "<Clave>" . $this->clave ."</Clave>" . chr(13) . chr(10);
        $xml .= "<Datos>" . chr(13) . chr(10);
        $xml .= $this->txtXml;
        $xml .= "</Datos>" . chr(13) . chr(10);
        $xml .= "</Importar>" . chr(13) . chr(10);

        return $xml;
    }





    
}
