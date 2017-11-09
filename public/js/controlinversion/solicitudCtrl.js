app.controller('solicitudCtrl', ['$scope', '$filter', '$http', '$window', '$mdDialog', function($scope, $filter, $http, $window, $mdDialog){

	// Variable fecha para el formulario de creacion
	var fechahoy = new Date();

	$scope.solicitud = {
		sci_fecha:$filter('date')(fechahoy, 'yyyy-MM-dd HH:mm:ss'),
		personas: []
	};

	$scope.motivoSalida = [
	{
		'id'			: 7,
		'descripcion' 	: 'Salida de Obsequios y Muestras Mercadeo'
	},
	{
		'id'			: 8,
		'descripcion' 	: 'Salida Eventos de Mercadeo'
	},
	{
		'id'			: 10,
		'descripcion' 	: 'Salida Probadores Mercadeo'
	},
	];


	$scope.zonas = [
	{
		'id'			: 1,
		'descripcion' 	: 'ZONA 1'
	},
	{
		'id'			: 2,
		'descripcion' 	: 'ZONA 2'
	},
	{
		'id'			: 3,
		'descripcion' 	: 'ZONA 3'
	},
	{
		'id'			: 4,
		'descripcion' 	: 'ZONA 4'
	},
	];

	//Se definen las urls a las cuales se les hara peticiones
	$scope.progress = true;
	$scope.resource = "../solicitud";
	$scope.url = '../solicitudGetInfo';
	$scope.refUrl = '../consultarReferencia';
	$scope.refesUrl = '../consultarReferencias';
	$scope.objeto = {};
	// Campo Facturar A
	$scope.hab_ac_facturara = false;
	$scope.buscar_ac_facturara = '';
	$scope.colaboradoresGeneral = [];
	$scope.colaboradoresAutocomplete = [];
	$scope.selectedColaboradores = [];
	$scope.referenciasError = [];
	$scope.autocompleteDemoRequireMatch = true;
	$scope.esVendedor = false;
	$scope.colaboradorText;
	$scope.filtrado = [];
	$scope.userNivel = {};
	//se declaran variables que se utilizaran en el formulario de ediccion
	$scope.inicializacion;
	$scope.cantPersonasFull = 0;
	$scope.primeraCarga = 0;
	$scope.lineaExist = [];




	$scope.getInfo = function(){

		if($scope.inicializacion != undefined){
			$scope.resource = "../../solicitud";
			$scope.url = '../../solicitudGetInfo';
			$scope.refUrl = '../../consultarReferencia';
			$scope.refesUrl = '../../consultarReferencias';
		}

		$http.get($scope.url).then(function(response){

			var res = response.data;


			$scope.userNivel = res.fullUser;
			$scope.solicitud.userNivel = res.fullUser;


			if($scope.solicitud.userNivel != undefined) {
				if($scope.solicitud.userNivel.length == 0){
					var successMessage = $mdDialog.alert()
					.parent(angular.element(document.querySelector('#popupContainer')))
					.clickOutsideToClose(false)
					.title('Privilegios Insuficientes!')
					.textContent('Su usuario no tiene los privilegios suficientes para crear una nueva solicitud')
					.ariaLabel('Lucky day')
					.ok('OK')


					$mdDialog.show(successMessage).then(function() {
						$scope.progress = true;
						window.location = res.rutaNoAutoriza;
					})
				}

			}


			$scope.personas = angular.copy(res.personas);
			$scope.tiposalida = angular.copy(res.tiposalida);
			$scope.tipopersona = angular.copy(res.tipopersona);
			$scope.cargagasto = angular.copy(res.cargagasto);
			$scope.lineasproducto = angular.copy(res.lineasproducto);
			$scope.colaboradores = angular.copy(res.colaboradores);
			$scope.vendedoresBesa = angular.copy(res.vendedoresBesa);
			$scope.items = angular.copy(res.item);
			$scope.canales = angular.copy(res.canales);
			$scope.userLogged = angular.copy(res.userLogged);
			$scope.progress = false;


			//Se arma el objeto para poder guardar en la base de datos cuando se actualiza en la base de datos
			if($scope.inicializacion != undefined){

				$scope.solicitud = $scope.inicializacion[0];
				$scope.solicitud.userNivel = $scope.userNivel;

				$scope.solicitud.tipoPersonaOriginal = $scope.solicitud.sci_tsd_id;
				$scope.solicitud.clientes.forEach(function(cliente){

					if($scope.solicitud.personas == undefined){
						$scope.solicitud['personas'] = [];
					}

					if($scope.solicitud.sci_tipopersona == 1){

						cliente.NomZona = cliente.clientes_zonas.scz_zon_id;
						if($scope.solicitud.zonasSelected == undefined){
							$scope.solicitud['zonasSelected'] = [];
						}

						var zonasSelected = $filter('filter')($scope.zonas, {id : cliente.clientes_zonas.scz_zon_id});
						if($scope.solicitud.zonasSelected.length > 0){
							var zonaExist = $filter('filter')($scope.solicitud.zonasSelected, {id : cliente.clientes_zonas.scz_zon_id});
							if(zonaExist.length == 0){
								$scope.solicitud.zonasSelected.push(zonasSelected[0]);
							}
						}else{
							$scope.solicitud.zonasSelected.push(zonasSelected[0]);
						}

					}

					$scope.solicitud.personas.push(cliente);
					$scope.selectedColaboradores.push(cliente);

				});

				var facturarA = $filter('filter')($scope.personas, {fca_idTercero : $scope.solicitud.sci_facturara});
				if(facturarA.length > 0){
					$scope.solicitud['facturarA'] = facturarA[0];
				}
				var tiposalida1 = $filter('filter')($scope.tiposalida, {tsd_id : $scope.solicitud.sci_tsd_id});
				if(tiposalida1.length > 0){
					$scope.solicitud['tiposalida1'] = tiposalida1[0];
				}
				var motivoSalida = $filter('filter')($scope.motivoSalida, {id : $scope.solicitud.sci_mts_id});
				if(motivoSalida.length > 0){
					$scope.solicitud['motivoSalida'] = motivoSalida[0];
				}
				var cargagasto1 = $filter('filter')($scope.cargagasto, {cga_id : $scope.solicitud.sci_cargara});
				if(cargagasto1.length > 0){
					$scope.solicitud['cargagasto1'] = cargagasto1[0];
				}

				if($scope.solicitud.cargagasto1.cga_id == 1){
					var lineas1 = $filter('filter')($scope.lineasproducto, {lcc_codigo : $scope.solicitud.sci_cargarlinea});
					if(lineas1.length > 0){
						$scope.solicitud['lineas1'] = lineas1[0];
					}
				}

				var canal = $filter('filter')($scope.canales, {can_id : $scope.solicitud.sci_can_id});
				if(canal.length > 0){
					$scope.solicitud['sci_canal'] = canal[0];
				}

				var tipopersona1 = $filter('filter')($scope.tipopersona, {tpe_id : $scope.solicitud.sci_tipopersona});
				if(tipopersona1.length > 0){
					$scope.solicitud['tipopersona1'] = tipopersona1[0];
					$scope.filtrapersona();
				}

				$scope.solicitud['canBeProccess'] = false;

				$scope.solicitud.personas.map(function(persona){

					if(persona.solicitud == undefined){
						persona.solicitud = {};
						persona.solicitud.referencias = [];
					}

					persona.solicitud.referencias = persona.clientes_referencias;
					persona.solicitud.referencias.map(function(referencia){

						if($scope.solicitud.tipopersona1.tpe_id == 1){
							persona.scz_zon_id = angular.copy(persona.clientes_zonas.scz_zon_id);
						}

						var referenciaDescripcion = $filter('filter')($scope.items,{srf_referencia: referencia.srf_referencia});
						if(referenciaDescripcion.length > 0){
							referencia.referenciaDescripcion = referenciaDescripcion[0].referenciaDescripcion;
						}

						var lineaRefe = $filter('filter')($scope.lineasproducto, {lcc_codigo : referencia.srf_lin_id_gasto});
						referencia.originalLinea = angular.copy(referencia.referencia.linea_item_criterio.lcc_codigo);
						delete referencia.referencia;
						referencia.linea = $scope.solicitud.lineas1 != undefined ? $scope.solicitud.lineas1 : lineaRefe[0];
						referencia.referenciaValorTotal = referencia.srf_unidades * referencia.srf_preciouni;

						return referencia;
					});

					persona.cantidadTotalReferencias = persona.solicitud.referencias.length;
					$scope.sumaCantidadSolicitada(persona);

					if(persona.cantidadTotalReferencias > 0 && persona.cantidadSolicitadaTotal > 0){
						$scope.cantPersonasFull += 1;
					}
					return persona;
				});

				if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
					$scope.solicitud.canBeProccess = true;
				}else{
					$scope.solicitud.canBeProccess = false;
				}
			}

			console.log(response.data);
			console.log($scope.solicitud);

		}, function(errorResponse){

			console.log(errorResponse);
			$scope.getInfo();

		});


}

$scope.onChangeOpcionCargaGasto = function(){

		if($scope.selectedColaboradores.length > 0){
			$scope.selectedColaboradores.forEach(function(colaborador){

			if(colaborador.solicitud.referencias.length > 0){
					colaborador.solicitud.referencias.map(function(referencia){

						if($scope.solicitud.cargagasto1.cga_id == 2 || $scope.solicitud.cargagasto1.cga_id == 1){

								if($scope.solicitud.cargagasto1.cga_id== 2){

									referencia.srf_lin_id_gasto = referencia.originalLinea;
									var lineaRefe = $filter('filter')($scope.lineasproducto, {lcc_codigo : referencia.originalLinea});
									referencia.linea =  lineaRefe[0];

								}else if($scope.solicitud.cargagasto1.cga_id== 1){

									if($scope.solicitud.lineas1 != undefined){
										referencia.linea = $scope.solicitud.lineas1;
										referencia.srf_lin_id_gasto = $scope.solicitud.lineas1.lcc_codigo;
									}else{
										var lineaRefe = $filter('filter')($scope.lineasproducto, {lcc_codigo : referencia.originalLinea});
										referencia.linea =  lineaRefe[0];
									}

								}
						}
						return referencia;
					})
				}
			})
		}

}

$scope.onChangeLineaCargaGasto = function(){

	if($scope.selectedColaboradores.length > 0){
		$scope.selectedColaboradores.forEach(function(colaborador){
			if(colaborador.solicitud.referencias.length > 0){
				colaborador.solicitud.referencias.map(function(referencia){
					referencia.srf_lin_id_gasto = $scope.solicitud.lineas1.lcc_codigo;
					referencia.linea = $scope.solicitud.lineas1;
					return referencia;
				})
			}
		})
	}
}

$scope.onChangeLineaReferencia = function(referencia){
	referencia.srf_lin_id_gasto = referencia.linea.lcc_codigo;
}

$scope.onCantidadChange = function(referencia){

	$scope.cantPersonasFull = 0;

	if(referencia.srf_unidades == undefined ||
		referencia.srf_unidades == null ||
		referencia.srf_unidades == 0){

		referencia.srf_unidades = 1;

}

referencia.referenciaValorTotal = referencia.srf_unidades * referencia.srf_preciouni;

$scope.selectedColaboradores.map(function(colaborador){

	$scope.sumaCantidadSolicitada(colaborador);

	if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
		$scope.cantPersonasFull += 1;
	}

});

if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
	$scope.solicitud.canBeProccess = true;
}else{
	$scope.solicitud.canBeProccess = false;
}


}

$scope.qs_facturara = function(string){
	var persona1 = $filter('filter')($scope.personas, {fca_idTercero : string});
	if(persona1.length == 0){
		return $filter('filter')($scope.personas, {tercero : {razonSocialTercero : string}});
	}else{
		return persona1;
	}
}

$scope.agregarReferenciaTodos = function(){

	$scope.cantPersonasFull = 0;

	var alertaLineaNoExiste = $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(false)
        .title('Error de linea de producto')
        .textContent('La linea de la referencia que intenta registrar no cuenta con un centro de costo valido, por favor valide su información.')
        .ariaLabel('Alert Dialog Demo')
        .ok('Aceptar')


	$scope.lineaExist = $filter('filter')($scope.lineasproducto, {lcc_codigo : $scope.objeto.referenciaGeneral.srf_lin_id_gasto});

	if($scope.lineaExist.length > 0){

		if($scope.lineaExist[0].lcc_codigo == $scope.objeto.referenciaGeneral.srf_lin_id_gasto){

					$scope.progress = true;

					$http.post($scope.refUrl, $scope.objeto.referenciaGeneral).then(function(response){

						$scope.selectedColaboradores.map(function(colaborador){

							$scope.objeto.referenciaGeneral.srf_preciouni = response.data.infoRefe.length > 0 ? response.data.infoRefe[0].precio : 1;
							$scope.objeto.referenciaGeneral.srf_unidades = 1;
							$scope.objeto.referenciaGeneral.srf_porcentaje = 0;
							$scope.objeto.referenciaGeneral.srf_estado = 1;
							$scope.objeto.referenciaGeneral.referenciaValorTotal = $scope.objeto.referenciaGeneral.srf_unidades == 0 ? 0 : $scope.objeto.referenciaGeneral.srf_unidades * $scope.objeto.referenciaGeneral.srf_preciouni;
							$scope.objeto.referenciaGeneral.originalLinea = $scope.objeto.referenciaGeneral.originalLinea == undefined ? angular.copy($scope.objeto.referenciaGeneral.srf_lin_id_gasto): angular.copy($scope.objeto.referenciaGeneral.originalLinea);

							if($scope.solicitud.cargagasto1.cga_id == 1 && $scope.solicitud.lineas1 != undefined){
								$scope.objeto.referenciaGeneral.linea = $scope.solicitud.lineas1;
								$scope.objeto.referenciaGeneral.srf_lin_id_gasto = $scope.solicitud.lineas1.lcc_codigo;
							}else{
								//var lineaRefe = $filter('filter')($scope.lineasproducto, {lcc_codigo : $scope.objeto.referenciaGeneral.originalLinea});
								$scope.objeto.referenciaGeneral.linea =  $scope.lineaExist[0];
							}

							if(colaborador.solicitud.referencias.length > 0){

								var objetoExiste = $filter('filter')(colaborador.solicitud.referencias,{srf_referencia: $scope.objeto.referenciaGeneral.srf_referencia });
								if(objetoExiste.length == 0){
									colaborador.solicitud.referencias.push(angular.copy($scope.objeto.referenciaGeneral));
								}

							}else{
								colaborador.solicitud.referencias.push(angular.copy($scope.objeto.referenciaGeneral));
							}

							colaborador.cantidadTotalReferencias = colaborador.solicitud.referencias.length;

							$scope.sumaCantidadSolicitada(colaborador);

							if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
								$scope.cantPersonasFull += 1;
							}

							return colaborador;
						})

						if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
							$scope.solicitud.canBeProccess = true;
						}else{
							$scope.solicitud.canBeProccess = false;
						}

						$scope.objeto.referenciaGeneral = "";

						$scope.progress = false;

					});
				}else{
					$mdDialog.show(alertaLineaNoExiste).then(function(){
						$scope.objeto.referenciaGeneral = "";
					});
				}
			}else{
				$mdDialog.show(alertaLineaNoExiste).then(function(){
					$scope.objeto.referenciaGeneral = "";
				});
			}
}

$scope.agregarReferenciaVendedor = function(colaborador,ev){

	$scope.cantPersonasFull = 0;

	var alertaLineaNoExiste = $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(false)
        .title('Error de linea de producto')
        .textContent('La linea de la referencia que intenta registrar no cuenta con un centro de costo valido, por favor valide su información.')
        .ariaLabel('Alert Dialog Demo')
        .ok('Aceptar')

	$scope.lineaExist = $filter('filter')($scope.lineasproducto, {lcc_codigo : colaborador.referenciaSearchItem.srf_lin_id_gasto});

	if($scope.lineaExist.length > 0){

		if($scope.lineaExist[0].lcc_codigo == colaborador.referenciaSearchItem.srf_lin_id_gasto){

				$scope.progress = true;

				$http.post($scope.refUrl, colaborador.referenciaSearchItem).then(function(response){

					colaborador.referenciaSearchItem.srf_preciouni = response.data.infoRefe.length > 0 ? response.data.infoRefe[0].precio : 1;
					colaborador.referenciaSearchItem.srf_unidades = 1;
					colaborador.referenciaSearchItem.srf_porcentaje = 0;
					colaborador.referenciaSearchItem.srf_estado = 1;
					colaborador.referenciaSearchItem.referenciaValorTotal = colaborador.referenciaSearchItem.referenciaValorTotal = colaborador.referenciaSearchItem.srf_unidades == 0 ? 0 : colaborador.referenciaSearchItem.srf_unidades * colaborador.referenciaSearchItem.srf_preciouni;
					colaborador.referenciaSearchItem.originalLinea= colaborador.referenciaSearchItem.originalLinea == undefined ? angular.copy(colaborador.referenciaSearchItem.srf_lin_id_gasto): angular.copy(colaborador.referenciaSearchItem.originalLinea);


					if($scope.solicitud.cargagasto1.cga_id == 1 && $scope.solicitud.lineas1 != undefined){
						colaborador.referenciaSearchItem.linea = $scope.solicitud.lineas1;
						colaborador.referenciaSearchItem.srf_lin_id_gasto = $scope.solicitud.lineas1.lcc_codigo;
					}else{
						//var lineaRefe = $filter('filter')($scope.lineasproducto, {lcc_codigo : colaborador.referenciaSearchItem.originalLinea});
						colaborador.referenciaSearchItem.linea =  $scope.lineaExist[0];
					}


					if(colaborador.solicitud.referencias.length > 0){

						var objetoExiste = $filter('filter')(colaborador.solicitud.referencias,{srf_referencia: colaborador.referenciaSearchItem.srf_referencia });
						if(objetoExiste.length == 0){
							colaborador.solicitud.referencias.push(angular.copy(colaborador.referenciaSearchItem));
						}

					}else{
						colaborador.solicitud.referencias.push(angular.copy(colaborador.referenciaSearchItem));
					}

					colaborador.cantidadTotalReferencias = colaborador.solicitud.referencias.length;

					$scope.selectedColaboradores.map(function(colaborador){

						$scope.sumaCantidadSolicitada(colaborador);

						if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
							$scope.cantPersonasFull += 1;
						}

					});

					if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
						$scope.solicitud.canBeProccess = true;
					}else{
						$scope.solicitud.canBeProccess = false;
					}

					colaborador.referenciaSearchItem="";
					$scope.progress = false;

				});

			}else{
				$mdDialog.show(alertaLineaNoExiste).then(function(){
					colaborador.referenciaSearchItem="";
				});
			}
		}else{
			$mdDialog.show(alertaLineaNoExiste).then(function(){
				colaborador.referenciaSearchItem="";
			});
		}

	// $scope.scrollToElement(ev.offsetX, ev.offsetY);

}

$scope.setSolicitudToSave = function(){
	//Variables que se toman desde el formulario
	$scope.solicitud.sci_tsd_id = $scope.solicitud.tiposalida1.tsd_id;
	$scope.solicitud.sci_mts_id = $scope.solicitud.motivoSalida.id;
	$scope.solicitud.sci_usuario = $scope.userLogged.idTerceroUsuario;

	if($scope.solicitud.cargagasto1.cga_id== 1 && $scope.solicitud.lineas1 != undefined){
			$scope.solicitud.sci_cargarlinea = $scope.solicitud.lineas1.lcc_codigo;
	}else{
			$scope.solicitud.sci_cargarlinea = "";
	}

	if($scope.solicitud.sci_canal != undefined){
		$scope.solicitud.sci_can_id = $scope.solicitud.sci_canal.can_id;
		$scope.solicitud.sci_can_desc = $scope.solicitud.sci_canal.can_txt_descrip;
	}else{
		$scope.solicitud.sci_can_id = null;
	}

	$scope.solicitud.sci_tipopersona = $scope.solicitud.tipopersona1.tpe_id;
	$scope.solicitud.sci_cargara = $scope.solicitud.cargagasto1.cga_id;
	$scope.solicitud.sci_nombre = $scope.solicitud.facturarA.tercero.razonSocialTercero;
	$scope.solicitud.sci_facturara = $scope.solicitud.facturarA.tercero.nitTercero;

	$scope.solicitud.personas = $scope.selectedColaboradores;
	$scope.solicitud.sci_ventaesperada = 0;
	$scope.solicitud.personas.forEach(function(persona){
		$scope.solicitud.sci_ventaesperada += persona.scl_ventaesperada;
	});

	Math.round($scope.solicitud.sci_ventaesperada);

	//Variables que el valor es predeterminado
	$scope.solicitud.sci_soe_id = 0;
	$scope.solicitud.sci_tdc_id = 0;
	$scope.solicitud.sci_solicitante = 0;
	$scope.solicitud.sci_periododes_ini = null;
	$scope.solicitud.sci_periododes_fin = null;
	$scope.solicitud.sci_descuento_estimado = null;
	$scope.solicitud.sci_tipo = 3;
	$scope.solicitud.sci_tipono = 0;
	$scope.solicitud.sci_tipononumero = "";
	$scope.solicitud.sci_toc_id = 0;
	$scope.solicitud.sci_planoobmu = 0;
	$scope.solicitud.sci_planoobmufecha = null;
	$scope.solicitud.sci_cerradaautomatica = 0;
	$scope.solicitud.sci_fechacierreautomatica = null;
	$scope.solicitud.sci_motivodescuento = null;
	$scope.solicitud.sci_duplicar = null;
	$scope.solicitud.sci_nduplicar = null;
	$scope.solicitud.sci_cduplicar = 0;
	$scope.solicitud.sci_todocanal = null;
	$scope.solicitud.sci_direccion = 0;
	$scope.solicitud.sci_ciudad = 0;
	$scope.solicitud.sci_totalref = null;
	$scope.solicitud.sci_planoprov = 0;
	$scope.solicitud.sci_planoprovfecha = null;
	console.log($scope.solicitud);
}

$scope.saveSolicitud = function(){

	$scope.progress = true;

			$scope.setSolicitudToSave();

			if($scope.inicializacion == undefined){

				$http.post($scope.resource,$scope.solicitud).then(function(response){

					var data = response.data;
					$scope.progress = false;

					console.log(data);

					var successMessage = $mdDialog.alert()
					.parent(angular.element(document.querySelector('#popupContainer')))
					.clickOutsideToClose(false)
					.title('Carga exitosa!')
					.textContent('Se ha creado la solicitud con id: '+ data.solicitudToCreate.sci_id+' correctamente.')
					.ariaLabel('Lucky day')
					.ok('OK')


					$mdDialog.show(successMessage).then(function() {
						$scope.progress = true;
						window.location = response.data.routeSuccess;
					})

				},function(errorResponse){
					console.log(errorResponse);
				});
			}else{

				$scope.solicitud.accion = "Actualizar";
				$http.put($scope.resource+"/"+$scope.solicitud.sci_id,$scope.solicitud)
				.then(function(response){
					console.log(response.data);
					$scope.progress = false;

					var successMessage = $mdDialog.alert()
					.parent(angular.element(document.querySelector('#popupContainer')))
					.clickOutsideToClose(false)
					.title('Actualización exitosa!')
					.textContent('Se ha actualizado la información de la solicitud con id: '+ response.data.solicitudToCreate.sci_id+' correctamente.')
					.ariaLabel('Lucky day')
					.ok('OK')

					$mdDialog.show(successMessage).then(function() {
						$scope.progress = true;
						window.location = response.data.routeSuccess;
					})

				});


			}

		}

$scope.enviarSolicitud = function(){

	$scope.progress = true;
	$scope.setSolicitudToSave();
	$scope.solicitud.sci_soe_id = 1;

	if($scope.inicializacion != undefined){
			$scope.solicitud.accion = "Aprobar";
	}else{
		$scope.solicitud.accion = "Crear"
	}

	$http.put($scope.resource+"/"+$scope.solicitud.sci_id,$scope.solicitud)
	.then(function(response){
		console.log(response.data);
		$scope.progress = false;

		var successMessage = $mdDialog.alert()
		.parent(angular.element(document.querySelector('#popupContainer')))
		.clickOutsideToClose(false)
		.title('Envio de solicitud!')
		.textContent('Se ha enviado la información de la solicitud con id: '+ response.data.solicitudToCreate.sci_id+' correctamente.')
		.ariaLabel('Lucky day')
		.ok('OK')

		$mdDialog.show(successMessage).then(function() {
			$scope.progress = true;
			window.location = response.data.routeSuccess;
		})

	});


}
/*
*Filtra el arreglo de selección de colaboradores por zonas dado el caso que sean vendedores
*/
$scope.filtrarVendedorZona = function(item){
	if($scope.esVendedor == true){
		var filtradoZona = $filter('filter')($scope.solicitud.zonasSelected,{descripcion: item.NomZona});
		if(filtradoZona.length > 0){
			return item;
		}
	}else	if($scope.esVendedor == false){
		return item;
	}
}

/*
*Filtra el arreglo de selección de colaboradores dependiendo del tipo de persona que es
*sí es una vendedor el arreglo de selección será filtrado desde $scope.vendedoresBesa y sí no
*será filtrado desde $scope.colaboradores
*/
$scope.filtrapersona = function(){
	if($scope.primeraCarga == 1){

	   var confirm = $mdDialog.confirm()
      .title('Alerta!')
      .textContent('Al cambiar esta opcion se van a limpiar todos los colaboradores')
      .ariaLabel('')
      .ok('Acepto')
      .cancel('Cancelar');

      $mdDialog.show(confirm).then(function() {
      	$scope.selectedColaboradores = [];
      }, function() {
      	$scope.progress = true;
      	$scope.primeraCarga = 0;
      	$scope.getInfo();
      });

	}
	$scope.primeraCarga = 1;
	$scope.colaboradoresGeneral = [];
	if($scope.solicitud.tipopersona1.tpe_tipopersona != 'Vendedor'){

		$scope.esVendedor = false;
		$scope.colaboradoresGeneral = $scope.colaboradores;

	}else if($scope.solicitud.tipopersona1.tpe_tipopersona == 'Vendedor'){

		$scope.esVendedor = true;
		$scope.colaboradoresGeneral = $scope.vendedoresBesa;

	}

}

$scope.onZonaChange= function(){

	// if($scope.zonasSelected.length > 0){
	//
	// 	if($scope.selectedColaboradores.length > 0){
	//
	// 			$scope.zonasSelected.forEach(function(zona){
	//
	// 				var vendedoresToRemove = $filter('filter')($scope.selectedColaboradores, {scz_zon_id: zona.id});
	//
	// 				if(vendedoresToRemove.length > 0){
	// 					vendedoresToRemove.forEach(function(colaborador){
	//
	// 						for(var x in $scope.selectedColaboradores){
	// 							var ref = $scope.selectedColaboradores[x];
	// 							if(ref['NomZona'] == colaborador.NomZona){
	//
	// 								if(colaborador.solicitud.referencias.length >0){
	// 									 colaborador.solicitud.referencias = [];
	// 								}
	//
	// 								$scope.selectedColaboradores.splice(x, 1);
	//
	// 							}
	// 						}
	//
	// 					})
	// 				}
	//
	// 			})
	//
	//
	// 		}
	// 	}

}

$scope.seleccionarVendedoresZona = function(zona){


	if(zona.isChecked == true){

		var filterColaboradoresGeneral = $filter('filter')($scope.colaboradoresGeneral, {NomZona: zona.descripcion});

		filterColaboradoresGeneral.forEach(function(colaborador){

			if(colaborador.solicitud == undefined){
				colaborador.solicitud = {};
				colaborador.solicitud.referencias = [];
			}

			colaborador.cantidadTotalReferencias = 0;
			colaborador.cantidadSolicitadaTotal = 0;
			colaborador.scl_ventaesperada = 0;
			colaborador.scl_desestimado = null;
			colaborador.scl_por = null;
			colaborador.scl_estado = 1;


			var colaboradorExist = $filter('filter')($scope.selectedColaboradores, {scl_cli_id: colaborador.scl_cli_id});
			if(colaboradorExist.length > 0 ){
				if(colaborador.scl_cli_id != colaboradorExist[0].scl_cli_id){
					$scope.selectedColaboradores.push(colaborador);
					$scope.solicitud.personas.push(colaborador);
				}
			}else{
				$scope.selectedColaboradores.push(colaborador);
				$scope.solicitud.personas.push(colaborador);
			}


			$scope.selectedColaboradores.map(function(colaborador){

				$scope.sumaCantidadSolicitada(colaborador);

				if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
					$scope.cantPersonasFull += 1;
				}

			});

			if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
				$scope.solicitud.canBeProccess = true;
			}else{
				$scope.solicitud.canBeProccess = false;
			}
		});
	}else{
		if($scope.selectedColaboradores.length > 0){

			var vendedoresToRemove = $filter('filter')($scope.selectedColaboradores, {NomZona: zona.descripcion});
			vendedoresToRemove.forEach(function(colaborador){
				console.log(colaborador);
				for(var x in $scope.selectedColaboradores){
					var ref = $scope.selectedColaboradores[x];
					if(ref['NomZona'] == colaborador.NomZona){

						if(colaborador.solicitud.referencias.length >0){
							 colaborador.solicitud.referencias = [];
						}

						$scope.selectedColaboradores.splice(x, 1);

					}
				}

			})
		}
	}

	console.log($scope.solicitud.personas);

}


/*
*Obtiene la lista de colaboradores previamente filtrada desde el metodo $scope.filtrapersona
*El cual detecta cada que hay un cambio en el modelo del autocomplete de colaboradores y
*Determina si lo que esta buscando es un vendedor o un tercero normal.
*/
$scope.onSearchQueryChange = function(colaboradorText){

	$scope.colaboradoresAutocomplete = [];

	$scope.colaboradoresAutocomplete =  $filter('filter')($scope.colaboradoresGeneral, {scl_nombre : colaboradorText});

	if($scope.colaboradoresAutocomplete.length == 0){
		$scope.colaboradoresAutocomplete =  $filter('filter')($scope.colaboradoresGeneral, {scl_cli_id : colaboradorText});
	}

	return $scope.colaboradoresAutocomplete

}

$scope.onAddColaboradores = function(colaborador){
	console.log(colaborador);
	if(colaborador.solicitud == undefined){
		colaborador.solicitud = {};
		colaborador.solicitud.referencias = [];
	}

	colaborador.cantidadTotalReferencias = 0;
	colaborador.cantidadSolicitadaTotal = 0;
	colaborador.scl_ventaesperada = 0;
	colaborador.scl_desestimado = null;
	colaborador.scl_por = null;
	colaborador.scl_estado = 1;

	if($scope.inicializacion != undefined){
		colaborador.isNew = true;
		$scope.solicitud.personas.push(colaborador);
	}

	$scope.selectedColaboradores.map(function(colaborador){

		$scope.sumaCantidadSolicitada(colaborador);

		if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
			$scope.cantPersonasFull += 1;
		}

	});

	if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
		$scope.solicitud.canBeProccess = true;
	}else{
		$scope.solicitud.canBeProccess = false;
	}

}

$scope.onRemoveColaboradores= function(colaborador){
	if(colaborador.solicitud.referencias.length >0){
		colaborador.solicitud.referencias = [];
	}
}


$scope.qs_referencia = function(string){
	var ref1 = $filter('filter')($scope.items, {referenciaDescripcion : string});
	if(ref1.length == 0){
		return $filter('filter')($scope.items, {srf_referencia : string});
	}else{
		return ref1;
	}
}


	/**
     * Return the proper object when the append is called.
     */
     function transformChip(chip) {
      // If it is an object, it's already a known chip
      if (angular.isObject(chip)) {
      	return chip;
      }
      // Otherwise, create a new one
      return { name: chip, type: 'new' }
  }

  $scope.scrollToElement = function(x,y){
  	$window.scrollTo(x,y);
  }

// Estas son las funciones que ejecuta la directiva
$scope.read = function (workbook) {

	$scope.progress = true;
	var headerNames = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]], { header: 1 })[0];
	var data = XLSX.utils.sheet_to_json( workbook.Sheets[workbook.SheetNames[0]]);
		// Cuando se ejecuta la informacion queda aqui para los encabezados

		var codigosReferencia = [];
		var referenciasFiltradas = [];
		$scope.referenciasError = [];


		data.forEach(function(referencia){
			codigosReferencia.push(referencia);
		});
		//Los codigos de referencias del archivo se filtran con los items del autocomplete de referencias para descartar los que no estan
		codigosReferencia.forEach(function(codigo){
			var objetoRefe = $filter('filter')($scope.items, {srf_referencia : codigo.REFERENCIA});
			if(objetoRefe.length > 0 && codigo.CANTIDAD > 0){
				objetoRefe[0].srf_unidades = parseInt(codigo.CANTIDAD);
				referenciasFiltradas.push(objetoRefe[0]);
			}else{
				$scope.referenciasError.push(codigo);
			}
		})
		//se reinicializa la variable codigosReferencia para agregar solo las referencias que se encuentran en el autocomplete
		codigosReferencia = [];
		//las referencias filtradas son a las que se les consultara el precio y se agregaran para cada
		referenciasFiltradas.forEach(function(referencia){
			codigosReferencia.push(referencia.srf_referencia);
		});
		//se realiza la consulta de los precios por un arreglo de referenciasFiltradas y se agregan
		if($scope.referenciasError.length == 0){

			$scope.cantPersonasFull = 0;

			$http.post($scope.refesUrl,codigosReferencia).then(function(response){

				var preciosRefes = angular.copy(response.data.infoRefes);

				if(preciosRefes.length > 0){
					$scope.selectedColaboradores.map(function(colaborador){


						referenciasFiltradas.forEach(function(referencia1){

							var objetoFilter = $filter('filter')(preciosRefes,{referencia: referencia1.srf_referencia});

							referencia1.srf_preciouni = objetoFilter.length > 0 ? objetoFilter[0].precio : 1;
							referencia1.srf_porcentaje = 0;
							referencia1.srf_estado = 1;
							referencia1.referenciaValorTotal =  referencia1.srf_preciouni * referencia1.srf_unidades;
							referencia1.originalLinea = angular.copy(referencia1.srf_lin_id_gasto);

							if($scope.solicitud.cargagasto1.cga_id == 1 && $scope.solicitud.lineas1 != undefined){
								referencia1.linea = $scope.solicitud.lineas1;
								referencia1.srf_lin_id_gasto = $scope.solicitud.lineas1.lcc_codigo;
							}else{
								var lineaRefe = $filter('filter')($scope.lineasproducto, {lcc_codigo : referencia1.originalLinea});
								referencia1.linea =  lineaRefe[0];
							}

							if(colaborador.solicitud.referencias.length > 0){

								var objetoExiste = $filter('filter')(colaborador.solicitud.referencias,{srf_referencia: referencia1.srf_referencia });
								if(objetoExiste.length == 0){
									console.log(referencia1);
									colaborador.solicitud.referencias.push(angular.copy(referencia1));
								}

							}else{
								colaborador.solicitud.referencias.push(angular.copy(referencia1));
							}

							colaborador.cantidadTotalReferencias = colaborador.solicitud.referencias.length;

						});

						$scope.sumaCantidadSolicitada(colaborador);

						if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
							$scope.cantPersonasFull += 1;
						}

						return colaborador;
					})
				}

				if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
					$scope.solicitud.canBeProccess = true;
				}else{
					$scope.solicitud.canBeProccess = false;
				}

				$scope.progress = false;
			});

		}else{

			var encabezado = "<br><h5>Se ha presentado un error al intentar cargar las siguientes referencias:</h5>";
			var error = "<h5>Error: Las referencias no existen o su cantidad no es valida, por favor verifique su información.</h5><br>";

			var text = "";
			$scope.referenciasError.forEach(function(refe){
				text += '<md-list-item><pre style="color:red;">REFERENCIA: '+ refe.REFERENCIA +' CANTIDAD: '+refe.CANTIDAD+' FILA: '+ (refe.__rowNum__ +1)+'</pre></md-list-item>';
			})

			encabezado += error;
			encabezado += text;


			$scope.progress = false;

			$mdDialog.show($mdDialog.alert({
				title: 'Errores en cargue masivo de referencias',
				htmlContent: encabezado,
				ok: 'Cerrar'

			}));

		}

	}


	$scope.eliminarReferencia = function(persona,referencia){

	 $scope.cantPersonasFull = 0;

   console.log($scope.cantPersonasFull);

		if(referencia && persona){
			for(var x in persona.solicitud.referencias){
				var ref = persona.solicitud.referencias[x];
				if(ref['srf_referencia'] == referencia.srf_referencia){
					persona.solicitud.referencias.splice(x, 1);
					persona.cantidadTotalReferencias = persona.solicitud.referencias.length;
				}
			}
		}

		$scope.selectedColaboradores.map(function(colaborador){

			$scope.sumaCantidadSolicitada(colaborador);

			if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
				$scope.cantPersonasFull += 1;
			}

		});

		console.log($scope.cantPersonasFull);
		console.log($scope.selectedColaboradores.length);

		if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
			$scope.solicitud.canBeProccess = true;
		}else{
			$scope.solicitud.canBeProccess = false;
		}

	}


	$scope.eliminarPersona = function(persona){

		$scope.cantPersonasFull = 0;

		if(persona){
			for(var x in $scope.selectedColaboradores){
				var ref = $scope.selectedColaboradores[x];
				if(ref['scl_cli_id'] == persona.scl_cli_id){

					if(persona.solicitud.referencias.length >0){
						persona.solicitud.referencias = [];
					}
					$scope.selectedColaboradores.splice(x, 1);

				}
			}
		}

		$scope.selectedColaboradores.map(function(colaborador){

			$scope.sumaCantidadSolicitada(colaborador);

			if(colaborador.cantidadTotalReferencias > 0 && colaborador.cantidadSolicitadaTotal > 0){
				$scope.cantPersonasFull += 1;
			}

		});
		console.log($scope.cantPersonasFull);
		//$scope.solicitud.personas = $scope.selectedColaboradores;

		if($scope.cantPersonasFull == $scope.selectedColaboradores.length){
			$scope.solicitud.canBeProccess = true;
		}else{
			$scope.solicitud.canBeProccess = false;
		}


	}

	$scope.closeDialog = function() {
		$mdDialog.hide();
	}

	$scope.error = function (e) {
		console.log(e);
	}
	// End funciones que ejecuta la directiva


	$scope.sumaCantidadSolicitada = function(persona){
		var arreglito = persona.solicitud.referencias.map(function(referencia){
			return referencia.srf_unidades;
		});

		persona.cantidadSolicitadaTotal = $filter('sum')(arreglito);


		return persona.cantidadSolicitadaTotal;
	}


	$scope.sumaValorTotal = function(persona){
		var arreglito = persona.solicitud.referencias.map(function(referencia){
			return referencia.referenciaValorTotal;
		});
		persona.scl_ventaesperada = $filter('sum')(arreglito);

		return persona.scl_ventaesperada;
	}

	$scope.validarZonasUsuarios = function(){
		console.log($scope.solicitud.zonasSelected);
		console.log($scope.solicitud);
	}

}]);
