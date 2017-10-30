app.controller('solicitudCtrl', ['$scope', '$filter', '$http', '$window', '$mdDialog', function($scope, $filter, $http, $window, $mdDialog){

	// Variable fecha para el formulario de creacion
	function afterShowAnimation() {
                        var $dialog = angular.element(document.querySelector('md-dialog'));
                        var $actionsSection = $dialog.find('md-dialog-actions');
                        var $cancelButton = $actionsSection.children()[0];
                        var $confirmButton = $actionsSection.children()[1];
                        angular.element($confirmButton).addClass('md-raised md-warn');
                        angular.element($cancelButton).addClass('md-raised');
                    }
	var fechahoy = new Date();
	$scope.solicitud = {
			  				sci_fecha:$filter('date')(fechahoy, 'yyyy-MM-dd HH:mm:ss'),
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

	$scope.progress = true;
	$scope.resource = "../solicitud";
	$scope.url = '../solicitudGetInfo';
	$scope.refUrl = '../consultarReferencia';
	$scope.refesUrl = '../consultarReferencias';
	$scope.objeto = {};


	// Campo Facturar A
		$scope.hab_ac_facturara = false;
		$scope.buscar_ac_facturara = '';


	$scope.listadespachar = [];

	$scope.colaboradoresGeneral = [];
	$scope.colaboradoresAutocomplete = [];
  $scope.selectedColaboradores = [];
	$scope.referenciasError = [];

  $scope.autocompleteDemoRequireMatch = true;
	$scope.esVendedor = false;
	$scope.colaboradorText;

	$scope.filtrado = [];
	$scope.solicitudEncabezado = {};


	$scope.getInfo = function(){
		$http.get($scope.url).then(function(response){
			var res = response.data;
			console.log(res);
			$scope.personas = angular.copy(res.personas);
			$scope.tiposalida = angular.copy(res.tiposalida);
			$scope.tipopersona = angular.copy(res.tipopersona);
			$scope.cargagasto = angular.copy(res.cargagasto);
			$scope.lineasproducto = angular.copy(res.lineasproducto);
			$scope.colaboradores = angular.copy(res.colaboradores);
			$scope.vendedoresBesa = angular.copy(res.vendedoresBesa);
			$scope.items = angular.copy(res.item);
			$scope.userLogged = angular.copy(res.userLogged);
			$scope.progress = false;
		}, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
	}

$scope.onChangeOpcionCargaGasto = function(){
	console.log($scope.solicitud.cargagasto1);
	if($scope.solicitud.cargagasto1.cga_id == 2){
		if($scope.selectedColaboradores.length > 0){
			$scope.selectedColaboradores.forEach(function(colaborador){
				if(colaborador.solicitud.referencias.length > 0){
					colaborador.solicitud.referencias.map(function(referencia){
						console.log(referencia);
						referencia.srf_lin_id_gasto = referencia.originalLinea;
						return referencia;
					})
				}
			})
		}
	}
}

$scope.onChangeLineaCargaGasto = function(){
	console.log($scope.solicitud.lineas1);
	if($scope.selectedColaboradores.length > 0){
		$scope.selectedColaboradores.forEach(function(colaborador){
			if(colaborador.solicitud.referencias.length > 0){
				colaborador.solicitud.referencias.map(function(referencia){
					referencia.srf_lin_id_gasto = $scope.solicitud.lineas1.lcc_codigo;
					return referencia;
				})
			}
		})
	}
}

$scope.onCantidadChange = function(referencia){

	console.log($scope.selectedColaboradores);

	referencia.referenciaValorTotal = referencia.srf_unidades * referencia.srf_preciouni;


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

	$scope.progress = true;

	$http.get($scope.refUrl+"/"+$scope.objeto.referenciaGeneral.srf_referencia).then(function(response){

			$scope.selectedColaboradores.map(function(colaborador){

				$scope.objeto.referenciaGeneral.srf_preciouni = response.data.infoRefe.length > 0 ? response.data.infoRefe[0].precio : 1;
				$scope.objeto.referenciaGeneral.srf_unidades = 0;
				$scope.objeto.referenciaGeneral.srf_porcentaje = 0;
				$scope.objeto.referenciaGeneral.srf_estado = 1;
				$scope.objeto.referenciaGeneral.referenciaValorTotal = 0;
				$scope.objeto.referenciaGeneral.originalLinea = angular.copy($scope.objeto.referenciaGeneral.srf_lin_id_gasto);

				if(colaborador.solicitud.referencias.length > 0){

					var objetoExiste = $filter('filter')(colaborador.solicitud.referencias,{srf_referencia: $scope.objeto.referenciaGeneral.srf_referencia });
					if(objetoExiste.length == 0){
						colaborador.solicitud.referencias.push(angular.copy($scope.objeto.referenciaGeneral));
					}

				}else{
					colaborador.solicitud.referencias.push(angular.copy($scope.objeto.referenciaGeneral));
				}

				colaborador.cantidadTotalReferencias = colaborador.solicitud.referencias.length;

				// colaborador.solicitud.referencias.

				return colaborador;
			})

			console.log($scope.selectedColaboradores);

			$scope.objeto.referenciaGeneral = "";

			$scope.progress = false;

	});
}

$scope.agregarReferenciaVendedor = function(colaborador,ev){

	$scope.progress = true;

	$http.get($scope.refUrl+"/"+colaborador.referenciaSearchItem.srf_referencia).then(function(response){

				colaborador.referenciaSearchItem.srf_preciouni = response.data.infoRefe.length > 0 ? response.data.infoRefe[0].precio : 1;
				colaborador.referenciaSearchItem.srf_unidades = 0;
				colaborador.referenciaSearchItem.srf_porcentaje = 0;
				colaborador.referenciaSearchItem.srf_estado = 1;
				colaborador.referenciaSearchItem.referenciaValorTotal = 0;
				colaborador.referenciaSearchItem.originalLinea = angular.copy(colaborador.referenciaSearchItem.srf_lin_id_gasto);


				if(colaborador.solicitud.referencias.length > 0){

					var objetoExiste = $filter('filter')(colaborador.solicitud.referencias,{srf_referencia: colaborador.referenciaSearchItem.srf_referencia });
					if(objetoExiste.length == 0){
							colaborador.solicitud.referencias.push(angular.copy(colaborador.referenciaSearchItem));
					}

				}else{
							colaborador.solicitud.referencias.push(angular.copy(colaborador.referenciaSearchItem));
				}

				colaborador.cantidadTotalReferencias = colaborador.solicitud.referencias.length;

				console.log(colaborador.solicitud.referencias);

				colaborador.referenciaSearchItem="";
				$scope.progress = false;

	});

	// $scope.scrollToElement(ev.offsetX, ev.offsetY);

}

$scope.saveSolicitud = function(){

	//Variables que se toman desde el formulario

	$scope.solicitud.sci_tsd_id = $scope.solicitud.tiposalida1.tsd_id;
	$scope.solicitud.sci_mts_id = $scope.solicitud.motivoSalida.id;
	$scope.solicitud.sci_usuario = $scope.userLogged.idTerceroUsuario;
	$scope.solicitud.sci_cargarlinea = $scope.solicitud.lineas1.lcc_codigo;
	$scope.solicitud.sci_observaciones = $scope.solicitud.observaciones != undefined ? $scope.solicitud.observaciones : "";
	$scope.solicitud.sci_tipopersona = $scope.solicitud.tipopersona1.tpe_id;
	$scope.solicitud.sci_cargara = $scope.solicitud.cargagasto1.cga_id;
  $scope.solicitud.sci_nombre = $scope.solicitud.facturarA.tercero.razonSocialTercero;
	$scope.solicitud.sci_facturara = $scope.solicitud.facturarA.tercero.nitTercero;

	$scope.solicitud.personas = $scope.selectedColaboradores;


	//Variables que el valor es predeterminado

	$scope.solicitud.sci_can_id = null;
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
	$scope.solicitud.sci_ventaesperada = 0


	console.log($scope.solicitud);
	// $http.post($scope.resource,$scope.solicitud).then(function(response){
	//
	// 	var data = response.data;
	// 	console.log(data);
	//
	//
	// },function(errorResponse){
	// 	console.log(errorResponse);
	// });

	console.log($scope.solicitud);
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

			$scope.colaboradoresGeneral = [];

			if($scope.solicitud.tipopersona1.tpe_tipopersona != 'Vendedor'){

					$scope.esVendedor = false;
					$scope.colaboradoresGeneral = $scope.colaboradores;

			}else if($scope.solicitud.tipopersona1.tpe_tipopersona == 'Vendedor'){

					$scope.esVendedor = true;
					$scope.colaboradoresGeneral = $scope.vendedoresBesa;

			}

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
	console.log(colaborador);
}

$scope.onRemoveColaboradores= function(colaborador){
	if(colaborador.solicitud.referencias.length >0){
		colaborador.solicitud.referencias = [];
	}
}

$scope.addpersonadespachar = function(string){

					console.log(string);
					console.log($scope.selectedColaboradores)

}


$scope.qs_referencia = function(string){
							var ref1 = $filter('filter')($scope.items, {referenciaDescripcion : string});
							if(ref1.length == 0){
								return $filter('filter')($scope.items, {srf_referencia : string});
							}else{
								return ref1;
							}
	}


	$scope.getInfo();


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
			console.log(headerNames);
			console.log(data);

			var codigosReferencia = [];
			var referenciasFiltradas = [];
			$scope.referenciasError = [];


			data.forEach(function(referencia){
				codigosReferencia.push(referencia);
			});
			//Los codigos de referencias del archivo se filtran con los items del autocomplete de referencias para descartar los que no estan
			codigosReferencia.forEach(function(codigo){
				var objetoRefe = $filter('filter')($scope.items, {srf_referencia : codigo.REFERENCIA});
				if(objetoRefe.length > 0){
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

									if(colaborador.solicitud.referencias.length > 0){

										var objetoExiste = $filter('filter')(colaborador.solicitud.referencias,{srf_referencia: referencia1.srf_referencia });
										if(objetoExiste.length == 0){
											colaborador.solicitud.referencias.push(angular.copy(referencia1));
										}

									}else{
										colaborador.solicitud.referencias.push(angular.copy(referencia1));
									}

									colaborador.cantidadTotalReferencias = colaborador.solicitud.referencias.length;

								});

								return colaborador;
							})
						}

						$scope.progress = false;
					});

			}else{

				var encabezado = "<br><h5>Se ha presentado un error al intentar el cargue masivo de las siguientes referencias</h5>";

				var text = "";
				$scope.referenciasError.forEach(function(refe){
					text += '<md-list-item>REFERENCIA: '+ refe.REFERENCIA +' CANTIDAD: '+refe.CANTIDAD+' FILA: '+ refe.__rowNum__ +'</md-list-item><br>';
				})

				encabezado += text;

				console.log(text);

				$scope.progress = false;

			    $mdDialog.show($mdDialog.alert({
						title: 'Errores en cargue masivo de referencias',
						htmlContent: encabezado,
						ok: 'Cerrar'

					}));

			}

	}


  $scope.eliminarReferencia = function(persona,referencia){

			console.log(persona,referencia);
      if(referencia && persona){
          for(var x in persona.solicitud.referencias){
              var ref = persona.solicitud.referencias[x];
              if(ref['srf_referencia'] == referencia.srf_referencia){
                  persona.solicitud.referencias.splice(x, 1);
									persona.cantidadTotalReferencias = persona.solicitud.referencias.length;
              }
          }
      }
  }


	$scope.eliminarPersona = function(persona){

			console.log(persona);
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

}]);
