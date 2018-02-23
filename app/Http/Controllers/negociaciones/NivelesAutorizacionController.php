<?php

namespace App\Http\Controllers\negociaciones;

use App\Models\negociaciones\TPernivele;
use App\Models\negociaciones\TPernivCanal;
use App\Models\negociaciones\TPernivLinea;
use App\Models\negociaciones\TNivele;
use App\Models\Genericas\TCanal;
use App\Models\Genericas\TTipopersona;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TTerritorioNw;
use App\Models\Genericas\TGrupo;
use App\Models\Genericas\TLineas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

ini_set('max_execution_time', 300);
ini_set('memory_limit', '-1');

class NivelesAutorizacionController extends Controller
{
	public function index(){
        $ruta = "Negociaciones / Niveles de Autorización";
        $titulo = "Niveles de Autorización";
		return view('layouts.negociaciones.indexNivelesAutorizacion',compact('ruta','titulo'));
	}


	public function getInfo(){

		//Información General
		$canales = TCanal::whereIn('can_id',['20','AL','DR','SI'])->get();
		$tipospersona = TTipopersona::whereIn('id', [1, 2])->where('tpp_estado', 1)->get();		
		$tipospersonaN2 = TTipopersona::whereIn('id', [1, 2, 3])->where('tpp_estado', 1)->get();
		$tipospersonaN3 = TTipopersona::whereIn('id', [1, 3])->where('tpp_estado', 1)->get();
		$terceros = Tercero::with('usuario')->where(['indxEstadoTercero' => 1 , 'indxEmpleadoTercero' => 1])->get();
		
		$terceros = collect($terceros)->filter(function($tercero){
			return $tercero->usuario != null;
		})->values();

		$terceros = collect($terceros)->map(function($tercero){
			$tercero['cedulaNombre'] = $tercero['idTercero'].' - '.$tercero['razonSocialTercero'];
			return $tercero;
		});
		$territorios = TTerritorioNw::with('zonanw')->get();
		$niveles = TNivele::all();
		//Niveles que dependen de un nivel
		$nivelesCreados = TPernivele::with('TTipopersona', 'canales', 'canales.lineas', 'hijos')->get();

		$lineas = TLineas::where('lin_txt_estado', 'No')->get();

		$response = compact('canales','tipospersona','terceros','territorios','niveles','nivelesCreados', 'tipospersonaN2', 'lineas', 'tipospersonaN3');

		return response()->json($response);

	}


	public function store(Request $request){
		$data = $request->all();

		if (isset($data['id'])) {
			if ($data['nivel'][0]['id'] == 1) {
				if ($data['tipopersona']['id'] == 1) {
					$canalesPersona = collect($data['canales'])->pluck('can_id');
					$deleteCanalesNotIn = TPernivCanal::where('pcan_cedula', $data['pen_cedula'])->whereNotIn('pcan_idcanal', $canalesPersona)->delete();
					$pernivel = TPernivele::with('canales')->find($data['id']);
					foreach ($data['canales'] as $key => $canal) {
						$filtroPernCanal = collect($pernivel['canales'])
								->where('pcan_idcanal', $canal['can_id'])
								->where('pcan_idpernivel', $pernivel['id'])
								->all();

						if (count($filtroPernCanal) == 0) {
							$this->generarCanales($canal, $data, $pernivel);
						}
					}
				}elseif($data['tipopersona']['id'] == 2){
					if (count($data['territorio']) > 0) {
						$idTerritorios = collect($data['territorio'])->pluck('id');
						$deleteTerritoriosNotIn = TPernivCanal::where('pcan_cedula', $data['pen_cedula'])->whereNotIn('pcan_idterritorio', $idTerritorios)->delete();
						$pernivel = TPernivele::with('canales')->find($data['id']);
						foreach ($data['territorio'] as $key => $territorio) {
							$idCanales = collect($territorio['canales'])->pluck('can_id');
							$new = $idCanales;
							$deleteCanalesNotIn =  TPernivCanal::where('pcan_cedula', $data['pen_cedula'])->where('pcan_idterritorio', $territorio['id'])->whereNotIn('pcan_idcanal', $idCanales)->delete();
							foreach ($territorio['canales'] as $key => $canal) {
								$filtroPernCanal = collect($pernivel['canales'])
													->where('pcan_idcanal', $canal['can_id'])
													->where('pcan_idpernivel', $pernivel['id'])								
													->where('pcan_idterritorio', $territorio['id'])
													->all();

								if (count($filtroPernCanal) == 0) {
									$this->generarCanales($canal, $data, $pernivel, $territorio['id']);
								}
							}
						}
					}
				}

			}elseif($data['nivel'][0]['id'] == 2 || $data['nivel'][0]['id'] == 3){
				if ($data['tipopersona']['id'] == 1) {

					$pernivel = TPernivele::with('canales')->find($data['id']);
					$actualizoPersonasAgregadas = TPernivCanal::where('pcan_aprobador', $data['id'])->update(['pcan_aprobador' => null]);
					$update = TPernivCanal::where('pcan_cedula', $data['pen_cedula'])->delete();
					foreach ($data['canales'] as $key => $canal) {
						$this->generarCanales($canal, $data, $pernivel);
						if (count($canal['terceros']) > 0) {
							foreach ($canal['terceros'] as $key => $tercero) {
								$update = TPernivCanal::where('pcan_cedula', $tercero['idTercero'])
								->where('pcan_idcanal', $canal['can_id'])
								->where('pcan_idterritorio', 0)
								->update(['pcan_aprobador' => $pernivel['id']]);
							}
						}				
					}

				}elseif ($data['tipopersona']['id'] == 2) {
					$new = 'entrance';
					if (count($data['territorio']) > 0) {
						$idTerritorios = collect($data['territorio'])->pluck('id');
						$deleteTerritoriosNotIn = TPernivCanal::where('pcan_cedula', $data['pen_cedula'])->whereNotIn('pcan_idterritorio', $idTerritorios)->delete();
						$pernivel = TPernivele::with('canales')->find($data['id']);
						foreach ($data['territorio'] as $key => $territorio) {
							$idCanales = collect($territorio['canales'])->pluck('can_id');
							$new = $idCanales;
							$deleteCanalesNotIn =  TPernivCanal::where('pcan_cedula', $data['pen_cedula'])->where('pcan_idterritorio', $territorio['id'])->whereNotIn('pcan_idcanal', $idCanales)->delete();
							foreach ($territorio['canales'] as $key => $canal) {
								$filtroPernCanal = collect($pernivel['canales'])
													->where('pcan_idcanal', $canal['can_id'])
													->where('pcan_idpernivel', $pernivel['id'])								
													->where('pcan_idterritorio', $territorio['id'])
													->all();

								if (count($filtroPernCanal) == 0) {
									$this->generarCanales($canal, $data, $pernivel, $territorio['id']);
								}
							}
						}
					}
					
				}elseif($data['tipopersona']['id'] == 3){
					$canalesPersona = collect($data['canales'])->pluck('can_id');
					$deleteCanalesNotIn = TPernivCanal::where('pcan_cedula', $data['pen_cedula'])->whereNotIn('pcan_idcanal', $canalesPersona)->delete();
					foreach ($data['canales'] as $key => $canal) {
						$canalPersona = TPernivCanal::with('lineas')->where([['pcan_cedula', $data['pen_cedula']], ['pcan_idcanal', $canal['can_id']]])->first();
						$lineasPersona = collect($canal['lineas'])->pluck('lin_id');
						$deleteLinNotIn = TPernivLinea::whereNotIn('pcan_idlinea', $lineasPersona)->where('pcan_idcanal', $canalPersona['id'])->delete();
						
						foreach ($canal['lineas'] as $key => $linea) {
							$filtro = collect($canalPersona['lineas'])
												->where('pcan_idlinea', $linea['lin_id'])
												->where('pcan_idcanal', $canalPersona['id'])
												->all();

							if (count($filtro) == 0) {
								$objeto = new TPernivLinea;
								$objeto->pcan_idcanal = $canalPersona['id'];
								$objeto->pcan_idlinea = $linea['lin_id'];
								$objeto->pcan_descriplinea = $linea['lin_txt_descrip'];
								$objeto->save();
							}
						}
					}
				}
			}		
		}else{
			if ($data['tipopersona']['id'] == 1) {
				$arreglo = [];
				if ($data['nivel'][0]['id'] == 1) {
					if (count($request['canales']) > 0) {
						foreach ($request['canales'] as $key => $canal) {
							if (count($canal['terceros']) > 0) {
								foreach ($canal['terceros'] as $key => $tercero) {
									$pernivel = TPernivele::with('canales')->where('pen_cedula', $tercero['idTercero'])->first();
									if (!isset($pernivel)) {
										$pernivel = new TPernivele;
										$pernivel->pen_usuario = $tercero['usuario']['login'];
										$pernivel->pen_nombre = $tercero['razonSocialTercero'];
										$pernivel->pen_cedula = $tercero['idTercero'];
										$pernivel->pen_idtipoper = $data['tipopersona']['id'];
										$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
										$pernivel->save();
										$pernivel->canales()->get();
									}
									array_push($arreglo, $pernivel);
									if (count($pernivel['canales']) > 0) {
										$filtroPernCanal = collect($pernivel['canales'])
										->where('pcan_idcanal', $canal['can_id'])
										->where('pcan_idpernivel', $pernivel['id'])										
										->where('pcan_idterritorio', '0')
										->all();

										if (count($filtroPernCanal) == 0) {
											$this->generarCanales($canal, $data, $pernivel);
										}

									}else if(count($pernivel['canales']) == 0){
										$this->generarCanales($canal, $data, $pernivel);
									}
								}
							}
							
						}
					}
				}elseif($data['nivel'][0]['id'] == 2 || $data['nivel'][0]['id'] == 3){
					$pernivel = TPernivele::with('canales')->where('pen_cedula', $data['persona'][0]['idTercero'])->first();
					if (!isset($pernivel)) {
						$pernivel = new TPernivele;
						$pernivel->pen_usuario = $data['persona'][0]['usuario']['login'];
						$pernivel->pen_nombre = $data['persona'][0]['razonSocialTercero'];
						$pernivel->pen_cedula = $data['persona'][0]['idTercero'];
						$pernivel->pen_idtipoper = $data['tipopersona']['id'];
						$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
						$pernivel->save();
						$pernivel->canales()->get();
					}

					if (count($data['canales']) > 0) {
						foreach ($data['canales'] as $key => $canal) {
							if (count($pernivel['canales']) > 0) {
								$filtroPernCanal = collect($pernivel['canales'])
								->where('pcan_idcanal', $canal['can_id'])
								->where('pcan_idpernivel', $pernivel['id'])									
								->where('pcan_idterritorio', '0')
								->all();

								if (count($filtroPernCanal) == 0) {
									$this->generarCanales($canal, $data, $pernivel);
								}

							}else if(count($pernivel['canales']) == 0){
								$this->generarCanales($canal, $data, $pernivel);
							}

							if (count($canal['terceros']) > 0) {
								foreach ($canal['terceros'] as $key => $tercero) {
									$update = TPernivCanal::where('pcan_cedula', $tercero['idTercero'])
									->where('pcan_idcanal', $canal['can_id'])
									->where('pcan_idterritorio', 0)
									->update(['pcan_aprobador' => $pernivel['id']]);
								}
							}							
						}
					}
				}elseif($data['nivel'][0]['id'] == 4){
					$pernivel = TPernivele::with('canales')->where('pen_cedula', $data['persona'][0]['idTercero'])->first();
					if (!isset($pernivel)) {
						$pernivel = new TPernivele;
						$pernivel->pen_usuario = $data['persona'][0]['usuario']['login'];
						$pernivel->pen_nombre = $data['persona'][0]['razonSocialTercero'];
						$pernivel->pen_cedula = $data['persona'][0]['idTercero'];
						$pernivel->pen_idtipoper = $data['tipopersona']['id'];
						$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
						$pernivel->save();
						$pernivel->canales()->get();
					}					
				}
				
				
			}else if($data['tipopersona']['id'] == 2){
				$arreglo = [];
				if ($data['nivel'][0]['id'] == 1) {
					if (count($data['territorio']) > 0) {
						foreach ($data['territorio'] as $key => $territorio) {
							if (count($territorio['canales']) > 0) {
								foreach ($territorio['canales'] as $key => $canal) {
									if (count($canal['personas']) > 0) {
										foreach ($canal['personas'] as $key => $tercero) {
											$pernivel = TPernivele::with('canales')->where('pen_cedula', $tercero['idTercero'])->first();
											if (!isset($pernivel)) {
												$pernivel = new TPernivele;
												$pernivel->pen_usuario = $tercero['usuario']['login'];
												$pernivel->pen_nombre = $tercero['razonSocialTercero'];
												$pernivel->pen_cedula = $tercero['idTercero'];
												$pernivel->pen_idtipoper = $data['tipopersona']['id'];
												$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
												$pernivel->save();
												$pernivel->canales()->get();
											}
											if (count($pernivel['canales']) > 0) {
												$filtroPernCanal = collect($pernivel['canales'])
												->where('pcan_idcanal', $canal['can_id'])
												->where('pcan_idpernivel', $pernivel['id'])								
												->where('pcan_idterritorio', $territorio['id'])
												->all();

												if (count($filtroPernCanal) == 0) {
													$this->generarCanales($canal, $data, $pernivel, $territorio['id']);
												}

											}else if(count($pernivel['canales']) == 0){
												$this->generarCanales($canal, $data, $pernivel, $territorio['id']);
											}
										}
									}								
								}
							}						
						}
					}	
				}elseif($data['nivel'][0]['id'] == 2 || $data['nivel'][0]['id'] == 3){
					$pernivel = TPernivele::with('canales')->where('pen_cedula', $data['persona'][0]['idTercero'])->first();
					if (!isset($pernivel)) {
						$pernivel = new TPernivele;
						$pernivel->pen_usuario = $data['persona'][0]['usuario']['login'];
						$pernivel->pen_nombre = $data['persona'][0]['razonSocialTercero'];
						$pernivel->pen_cedula = $data['persona'][0]['idTercero'];
						$pernivel->pen_idtipoper = $data['tipopersona']['id'];
						$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
						$pernivel->save();
						$pernivel->canales()->get();
					}

					if (count($data['territorio']) > 0) {
						foreach ($data['territorio'] as $key => $territorio) {
							if (count($territorio['canales']) > 0) {
								foreach ($territorio['canales'] as $key => $canal) {
									if (count($canal['personas']) > 0) {
										if (count($pernivel['canales']) > 0) {
											$filtroPernCanal = collect($pernivel['canales'])
											->where('pcan_idcanal', $canal['can_id'])
											->where('pcan_idpernivel', $pernivel['id'])									
											->where('pcan_idterritorio', $territorio['id'])									
											->all();

											if (count($filtroPernCanal) == 0) {
												$this->generarCanales($canal, $data, $pernivel, $territorio['id']);
											}

										}else if(count($pernivel['canales']) == 0){
											$this->generarCanales($canal, $data, $pernivel, $territorio['id']);
										}

										if (count($canal['personas']) > 0) {
											foreach ($canal['personas'] as $key => $tercero) {
												$update = TPernivCanal::where('pcan_cedula', $tercero['idTercero'])
												->where('pcan_idcanal', $canal['can_id'])
												->where('pcan_idterritorio', $territorio['id'])
												->update(['pcan_aprobador' => $pernivel['id']]);
											}
										}
									}																
								}
							}
						}
					}
				}	

			}else if($data['tipopersona']['id'] == 3){
				if ($data['nivel'][0]['id'] == 2) {
					$pernivel = TPernivele::with('canales')->where('pen_cedula', $data['persona'][0]['idTercero'])->first();
					if (!isset($pernivel)) {
						$pernivel = new TPernivele;
						$pernivel->pen_usuario = $data['persona'][0]['usuario']['login'];
						$pernivel->pen_nombre = $data['persona'][0]['razonSocialTercero'];
						$pernivel->pen_cedula = $data['persona'][0]['idTercero'];
						$pernivel->pen_idtipoper = $data['tipopersona']['id'];
						$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
						$pernivel->save();
						$pernivel->canales()->get();
					}
					$arreglo = [];
					if (count($data['canales']) > 0) {
						foreach ($data['canales'] as $key => $canal) {
							if (count($pernivel['canales']) > 0) {
								$filtroPernCanal = collect($pernivel['canales'])
								->where('pcan_idcanal', $canal['can_id'])
								->where('pcan_idpernivel', $pernivel['id'])									
								->where('pcan_idterritorio', '0')
								->all();

								if (count($filtroPernCanal) == 0) {
									$this->generarCanales($canal, $data, $pernivel);
								}

							}else if(count($pernivel['canales']) == 0){
								$this->generarCanales($canal, $data, $pernivel);
							}

							foreach ($canal['lineas'] as $key => $linea) {
								$objpercanal = TPernivCanal::where('pcan_idcanal', $canal['can_id'])
								->where('pcan_idpernivel', $pernivel['id'])									
								->where('pcan_idterritorio', '0')
								->first();
								// array_push($arreglo);
								$lineaObj = new TPernivLinea;
								$lineaObj->pcan_idcanal = $objpercanal['id'];
								$lineaObj->pcan_idlinea = $linea['lin_id'];
								$lineaObj->pcan_descriplinea = $linea['lin_txt_descrip'];
								$lineaObj->save();
							}											
						}
					}
				}elseif($data['nivel'][0]['id'] == 3){
					$pernivel = TPernivele::with('canales')->where('pen_cedula', $data['persona'][0]['idTercero'])->first();
					if (!isset($pernivel)) {
						$pernivel = new TPernivele;
						$pernivel->pen_usuario = $data['persona'][0]['usuario']['login'];
						$pernivel->pen_nombre = $data['persona'][0]['razonSocialTercero'];
						$pernivel->pen_cedula = $data['persona'][0]['idTercero'];
						$pernivel->pen_idtipoper = $data['tipopersona']['id'];
						$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
						$pernivel->save();
						$pernivel->canales()->get();
					}
					$arreglo = [];
					if (count($data['canales']) > 0) {
						foreach ($data['canales'] as $key => $canal) {
							if (count($pernivel['canales']) > 0) {
								$filtroPernCanal = collect($pernivel['canales'])
								->where('pcan_idcanal', $canal['can_id'])
								->where('pcan_idpernivel', $pernivel['id'])									
								->where('pcan_idterritorio', '0')
								->all();

								if (count($filtroPernCanal) == 0) {
									$this->generarCanales($canal, $data, $pernivel);
								}

							}else if(count($pernivel['canales']) == 0){
								$this->generarCanales($canal, $data, $pernivel);
							}

							foreach ($canal['lineas'] as $key => $linea) {
								$objpercanal = TPernivCanal::where('pcan_idcanal', $canal['can_id'])
								->where('pcan_idpernivel', $pernivel['id'])									
								->where('pcan_idterritorio', '0')
								->first();
								// array_push($arreglo);
								$lineaObj = new TPernivLinea;
								$lineaObj->pcan_idcanal = $objpercanal['id'];
								$lineaObj->pcan_idlinea = $linea['lin_id'];
								$lineaObj->pcan_descriplinea = $linea['lin_txt_descrip'];
								$lineaObj->save();
							}											
						}
					}
					
				}elseif($data['nivel'][0]['id'] == 4){
					$pernivel = TPernivele::with('canales')->where('pen_cedula', $data['persona'][0]['idTercero'])->first();
					if (!isset($pernivel)) {
						$pernivel = new TPernivele;
						$pernivel->pen_usuario = $data['persona'][0]['usuario']['login'];
						$pernivel->pen_nombre = $data['persona'][0]['razonSocialTercero'];
						$pernivel->pen_cedula = $data['persona'][0]['idTercero'];
						$pernivel->pen_idtipoper = $data['tipopersona']['id'];
						$pernivel->pen_nomnivel = $data['nivel'][0]['id'];
						$pernivel->save();
						$pernivel->canales()->get();
					}					
				}
			}
		}

		

		$response = compact('data', 'arreglo', 'new', 'mas');

		return response()->json($response);

	}

	public function generarCanales($canal, $data, $pernivel, $territorio = null){
		$arregloPerCanal = [];
		$arregloPerCanal['pcan_idcanal'] = $canal['can_id'];
		$arregloPerCanal['pcan_descripcanal'] = $canal['can_txt_descrip'];
		$arregloPerCanal['pcan_cedula'] = $pernivel['pen_cedula'];
		$arregloPerCanal['pcan_idterritorio'] = $territorio;
 		if ($data['tipopersona']['id'] == 1 || $data['tipopersona']['id'] == 3) {
			$arregloPerCanal['pcan_idterritorio'] = 0;
		}
		return $pernivel->canales()->create($arregloPerCanal);
	}


	public function destroy($id){

		TPernivele::where('id', $id)->delete();
		$pernivCanal = TPernivCanal::where('pcan_idpernivel', $id)->get();
		$ids = collect($pernivCanal)->pluck('id');
		TPernivCanal::where('pcan_idpernivel', $id)->delete();
		TPernivLinea::whereIn('pcan_idcanal', $ids)->delete();

		return response()->json('exito');
	}

}