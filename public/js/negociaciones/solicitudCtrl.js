app.config(function($mdDateLocaleProvider) {
    
    $mdDateLocaleProvider.formatDate = function (date) {
        return date ? moment(date).format('DD/MM/YYYY') : '';
    };

    $mdDateLocaleProvider.parseDate = function (dateString) {
        var m = moment(dateString, 'DD/MM/YYYY', true);
        return m.isValid() ? m.toDate() : new Date(NaN);
    };
});


app.directive('stringToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value);
      });
    }
  };
});

app.directive('format', ['$filter', function ($filter) {
    return {
        require: '?ngModel',
        link: function (scope, elem, attrs, ctrl) {
            if (!ctrl) return;

            ctrl.$formatters.unshift(function (a) {
                return $filter(attrs.format)(ctrl.$modelValue)
            });

            elem.bind('blur', function(event) {
                var plainNumber = elem.val().replace(/[^\d|\-+|\.+]/g, '');
                elem.val($filter(attrs.format)(plainNumber));
            });
        }
    };
}]);


app.controller('solicitudCtrl', ['$scope', '$http', '$filter', '$mdDialog', '$q', '$timeout', '$window', function ($scope, $http, $filter, $mdDialog, $q, $timeout, $window) {
	
	$scope.objeto = {};
	$scope.objNegCliente = {};
	$scope.objtipoNeg = {};
	$scope.objCausalNego = {};
	$scope.objCostos = {};
	$scope.objObjetivos = {};
	$scope.objeto.sol_fecha = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
	$scope.progress = true;
	$scope.arrayZona = [];
	$scope.arraySucursales = [];
	$scope.arrayEventoTemp = [];
	$scope.arrayCausalNegociacion = [];
	$scope.arrayTipoNegociacion = [];
	$scope.arrayLineas = [];
	$scope.tipoDeServicioFilt = [];
	$scope.sucubool = true;
	$scope.siguiente = "";
	$scope.pestanaSeleccionada =  [1];
	$scope.conteo = 0;
	$scope.arrayFormularios = ['solicitudForm', 'costosForm', 'objetivosForm']

	$scope.labels = {
	    "itemsSelected": "elementos seleccionados",
	    "selectAll": "Marcar todos",
	    "unselectAll": "Desmarcar todos",
	    "search": "Buscar una sucursal...",
	    "select": "Seleccionar una sucursal..."
	}

	$scope.labelsLineas = {
	    "itemsSelected": "elementos seleccionados",
	    "selectAll": "Marcar todos",
	    "unselectAll": "Desmarcar todos",
	    "search": "Buscar una lineas...",
	    "select": "Seleccionar una lineas..."
	}



	$scope.getInfo = function(){
		var url = '../solicitudGetInfo';
		if ($scope.siguiente == 'create') {
			$scope.pasoUno = false;			
			$scope.pasoDos = true;
			$scope.pasoTres = true;
			$scope.pasoUnoSelect = true;
		}else if ($scope.siguiente == 'grabar.1') {
			$scope.pasoUnoSelect = true;
		}else if($scope.siguiente == 'adelante.1'){	
			$scope.pasoDosSelect = true;
		}else if($scope.siguiente == 'grabar.2'){	
			$scope.pasoDosSelect = true;
		}else if($scope.siguiente == 'adelante.2'){	
			$scope.pasoTresSelect = true;
		}else if($scope.siguiente == 'grabar.3'){	
			$scope.pasoTresSelect = true;
		}

		if ($scope.objeto.sol_id != undefined) {
			url = '../../solicitudGetInfo' + '?id=' + $scope.objeto.sol_id;
			$scope.pasoDos = false;
		}

		$http.get(url).then(function(response){
			var res = response.data;	
			$scope.urlMisSolicitudes = res.urlMisSolicitudes;		
			$scope.claseNegociacion = angular.copy(res.claseNegociacion);			
			$scope.negoAnoAnterior = angular.copy(res.negoAnoAnterior);
			$scope.tipNegociacion = angular.copy(res.tipNegociacion);
			$scope.canales = angular.copy(res.canales);
			$scope.VendedorSucursales = angular.copy(res.VendedorSucursales);
			if ($scope.VendedorSucursales == null) {
					$scope.progress = false;
					$scope.errorMsge = 'El usuario no tiene sucursales activas';
				    var confirm = $mdDialog.confirm()
				          .title('')
				          .textContent($scope.errorMsge)
				          .ariaLabel()
				          .ok('Entendido');

				    $mdDialog.show(confirm).then(function() {
				    	$scope.progress = true;
				      	$window.location = $scope.urlMisSolicitudes;
				    });
				    return true;
			}	
			$scope.multiSelectSucursales = angular.copy(res.VendedorSucursales.t_sucursal);
			$scope.clientes = angular.copy(res.clientes);
			$scope.negociacionPara = angular.copy(res.negociacionPara);
			$scope.zonas = angular.copy(res.zonas);
			$scope.zonasFiltradas = angular.copy($scope.zonas);
			$scope.listaPrecios = angular.copy(res.listaPrecios);
			$scope.eventoTemp = angular.copy(res.eventoTemp);
			$scope.tipoDeNegociacion = angular.copy(res.tipoDeNegociacion);
			$scope.tipoDeServicio = angular.copy(res.tipoDeServicio);
			$scope.formaPago = angular.copy(res.formaPago);
			$scope.causalesNego = angular.copy(res.causalesNego);
			$scope.lineasTodas = angular.copy(res.lineas);
			$scope.lineas = $filter('filter')($scope.lineasTodas, {lin_txt_estado : 'No'}, true);

			// if para obtener informacion cuando el formulario esta editando 
			if (res.objeto != undefined) {
				$scope.objeto = res.objeto;
				$scope.objeto.sol_clase = $filter('filter')($scope.claseNegociacion, {id : $scope.objeto.sol_clase})[0];
				$scope.objeto.sol_huella_capitalizar = $filter('filter')($scope.negoAnoAnterior, {id : $scope.objeto.sol_huella_capitalizar})[0];
				$scope.objeto.sol_tipo = $filter('filter')($scope.tipNegociacion, {id : $scope.objeto.sol_tipo})[0];
				$scope.objeto.sol_can_id = $filter('filter')($scope.canales, {can_id : $scope.objeto.sol_can_id})[0];
				var idCliente = $scope.objeto.sol_cli_id;
				$scope.objeto.sol_cli_id = $filter('filter')($scope.clientes, {cli_id : $scope.objeto.sol_cli_id})[0];	
				if ($scope.objeto.sol_cli_id == undefined) {
					var cliente = $filter('filter')(res.clientesTodos, {cli_id : idCliente})[0]['razonSocialTercero_cli'];	
					$scope.progress = false;
					$scope.errorMsg = "El cliente " +  cliente + ' no se encuentra asociado al vendedor ' + res.usuario.nombre + ' ' + res.usuario.apellido + ', favor informar a cartera o anular la solicitud';
				    var confirm = $mdDialog.confirm()
				          .title('')
				          .textContent($scope.errorMsg)
				          .ariaLabel()
				          .ok('Entendido');

				    $mdDialog.show(confirm).then(function() {
				    	$scope.progress = true;
				      	$window.location = $scope.urlMisSolicitudes;
				    });
				    return true;
				}		
				$scope.formatoDescuentoComer();
				$scope.objeto.sol_tipocliente = $filter('filter')($scope.negociacionPara, {id : $scope.objeto.sol_tipocliente})[0];
				$scope.objeto.listaprecios = $filter('filter')($scope.listaPrecios, {lis_id : $scope.objeto.sol_cli_id.lis_id})[0]['lis_txt_descrip'];
				if ($scope.objeto.sol_peri_facturaini != null) {
					$scope.objeto.sol_peri_facturaini = new Date($filter('date')($scope.objeto.sol_peri_facturaini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				}
				if ($scope.objeto.sol_peri_facturafin != null) {
					$scope.objeto.sol_peri_facturafin = new Date($filter('date')($scope.objeto.sol_peri_facturafin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				}
				if ($scope.objeto.sol_peri_ejeini != null) {
					$scope.objeto.sol_peri_ejeini = new Date($filter('date')($scope.objeto.sol_peri_ejeini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				}
				if ($scope.objeto.sol_peri_ejefin != null) {
					$scope.objeto.sol_peri_ejefin = new Date($filter('date')($scope.objeto.sol_peri_ejefin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				}			
				
				$scope.objeto.sol_ltxt_observ = $scope.objeto.sol_observaciones;
				$scope.objeto.sol_evt_id = $filter('filter')($scope.arrayEventoTemp, {evt_id : $scope.objeto.sol_evt_id})[0];
				
				$scope.objeto.soli_zona = $scope.objeto.soli_zona.map(function(object){
					object.szn_coc_id = $filter('filter')($scope.zonas, {cen_id : object.szn_coc_id})[0];
					return object;
				});
				$scope.arrayZona = $scope.objeto.soli_zona;
				$scope.objeto.soli_sucu = $scope.objeto.soli_sucu.map(function(object){
					object.szn_coc_id = $filter('filter')($scope.multiSelectSucursales, {suc_id : object.ssu_suc_id})[0];
					if (object.szn_coc_id == undefined) {
						return {obj : null};
					}else{
						object.suc_id = object.ssu_suc_id;
						object.porcentParti = object.ssu_ppart;
						object.descripcionConId = object.szn_coc_id.suc_num_codigo + " - " + object.szn_coc_id.suc_txt_nombre + " - " + object.szn_coc_id.suc_txt_direccion;
						return object;	
					}					
				});
				$scope.objeto.soli_sucu = $filter('removeWith')($scope.objeto.soli_sucu, {obj : null});
				$scope.arraySucursales = $scope.objeto.soli_sucu;

				$scope.objeto.soli_tipo_nego = $scope.objeto.soli_tipo_nego.map(function(object){
					object.stn_tin_id = $filter('filter')($scope.tipoDeNegociacion, {tin_id : object.stn_tin_id})[0];
					object.stn_ser_id = $filter('filter')($scope.tipoDeServicio, {ser_id : object.stn_ser_id})[0];
					return object;
				});
				$scope.arrayTipoNegociacion = $scope.objeto.soli_tipo_nego;
				$scope.objCostos.soc_valornego = $scope.sumarTipoNego();
				$scope.objCostos.soc_granvalor = $scope.objCostos.soc_valornego;
				$scope.objCostos.soc_iva = $scope.calcularIva();
				$scope.objCostos.soc_subtotalcliente = $scope.calcularSubtotalCliente();
				$scope.objCostos.soc_retefte = $scope.calcularRetefuente();
				$scope.objCostos.soc_reteica = $scope.calcularReteIca();
				$scope.objCostos.soc_reteiva = $scope.calcularReteIva();
				$scope.objCostos.soc_total = $scope.objCostos.soc_subtotalcliente - $scope.objCostos.soc_retefte - $scope.objCostos.soc_reteica - $scope.objCostos.soc_reteiva;

				$scope.objeto.causal = $scope.objeto.causal.map(function(object){
					object.scn_can_id = $filter('filter')($scope.causalesNego, {can_id : object.scn_can_id})[0];
					$scope.causalesNego = $filter('removeWith')($scope.causalesNego, {can_id : object.scn_can_id.can_id});
					return object;
				});
				$scope.arrayCausalNegociacion = $scope.objeto.causal;

				$scope.objCostos.soc_formapago =  $filter('filter')($scope.formaPago, {id : $scope.objCostos.soc_formapago})[0];

				if ($scope.objeto.costo != null) {
					$scope.arrayLineas = $scope.objeto.costo.lineas.map(function(object){
						object.porcentParti = object.scl_ppart;
						var lineaObj1 = $filter('filter')($scope.lineasTodas, {lin_id : object.scl_lin_id})[0];
						object.lin_txt_descrip = lineaObj1['lin_txt_descrip'];
						object.categorias = lineaObj1['categorias'];
						object.cat_id = object.scl_cat_id;
						object.lin_id = object.scl_lin_id;
						return object;
					});
				}
			}	

			$scope.objeto.sol_ven_id = angular.copy(res.usuario.idTerceroUsuario);
			$scope.objeto.usuario = angular.copy(res.usuario.nombre + " " + res.usuario.apellido);
			if ($scope.objeto.objetivo != null) {
				res.objeto.objetivo.soo_pecomfin = new Date($filter('date')(res.objeto.objetivo.soo_pecomfin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				res.objeto.objetivo.soo_pecomini = new Date($filter('date')(res.objeto.objetivo.soo_pecomini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				res.objeto.objetivo.soo_pcreciestima = parseFloat(res.objeto.objetivo.soo_pcreciestima).toFixed(2);
				res.objeto.objetivo.soo_pcrelin = parseFloat(res.objeto.objetivo.soo_pcrelin).toFixed(2);
				res.objeto.objetivo.soo_pinventaestiline = parseFloat(res.objeto.objetivo.soo_pinventaestiline).toFixed(2); 
				res.objeto.objetivo.soo_pinverestima = parseFloat(res.objeto.objetivo.soo_pinverestima).toFixed(2); 
			
				if (isNaN(res.objeto.objetivo.soo_pinverestima)) {
					res.objeto.objetivo.soo_pinverestima = 0;
				}
				res.objeto.objetivo.soo_pinvermargi = parseFloat(res.objeto.objetivo.soo_pinvermargi).toFixed(2); 
				if (isNaN(res.objeto.objetivo.soo_pinvermargi)) {
					res.objeto.objetivo.soo_pinvermargi = 0;
				}
				res.objeto.objetivo.soo_pvenmarlin = parseFloat(res.objeto.objetivo.soo_pvenmarlin).toFixed(2); 
				$scope.objObjetivos = angular.copy(res.objeto.objetivo);
			}			
			if ($scope.arrayLineas.length == 0 && Object.keys($scope.objObjetivos).length === 0) {
				$scope.pasoUno = false;			
				$scope.pasoDos = false;		
				$scope.pasoTres = true;
			}
			if ($scope.arrayLineas.length > 0 && Object.keys($scope.objObjetivos).length === 0) {
				$scope.pasoUno = false;			
				$scope.pasoDos = false;		
				$scope.pasoTres = false;
			}

			$scope.progress = false;
		}, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
	}

	$scope.sumarTipoNego = function(){
		var arregloParaSumar = $scope.arrayTipoNegociacion.map(function(element){
			return element.stn_costo;
		});
		var sumatoriaNew = $filter('sum')(arregloParaSumar);
		return sumatoriaNew.toFixed(2);
	}

	$scope.consultaClientes = function(){
		if ($scope.objeto.sol_can_id != undefined && $scope.objeto.sol_can_id != null) {
			var array = [];
			var sucursalesFilter = $filter('filter')($scope.VendedorSucursales.t_sucursal, {codcanal : $scope.objeto.sol_can_id.can_id.trim()});
			var agrupoClientes = $filter('groupBy')(sucursalesFilter, 'cli_id');
			Object.keys(agrupoClientes).forEach( function(element, index) {
				var cliente = $filter('filter')($scope.clientes, {cli_id : element})[0];
				array.push(cliente);
			});
			return array;
		}else{
			return [];
		}
	}

	$scope.agregarZona = function(obj){
		// Valido que los campos no este vacios y que cuando se agrege la ultima zona el porcentaje de participacion total sea igual a cero
		if (obj.szn_coc_id == undefined || obj.szn_ppart == undefined || ($scope.zonasFiltradas.length == 1 && $scope.objNegCliente.szn_ppart != $scope.calcularMaximo() )) {
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('Informacion incompleta')
		        .textContent('Debe diligenciar los campos zona y porcentaje de participación, la sumatoria de la participacion de todas las zonas debe ser igual a 100 para continuar')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		}else{
			$scope.arrayZona.push(obj);
			$scope.zonasFiltradas = $filter('removeWith')($scope.zonasFiltradas, {cen_id : obj.szn_coc_id.cen_id});
			$scope.objNegCliente = {};
		}
	}

	$scope.agregarCausalNegociacion = function(obj){
		if (obj.scn_can_id == undefined) {
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('Informacion incompleta')
		        .textContent('Debe seleccionar una descripcion')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		}else{
			$scope.arrayCausalNegociacion.push(angular.copy(obj));
			$scope.causalesNego = $filter('removeWith')($scope.causalesNego, {can_id : obj.scn_can_id.can_id});
		}
	}

	$scope.agregarTipoNegociacion = function(obj){
		// Valido que los campos no este vacios y que cuando se agrege la ultima zona el porcentaje de participacion total sea igual a cero
		if (obj.stn_tin_id == undefined || obj.stn_ser_id == undefined || obj.stn_costo == undefined ) {
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('Informacion incompleta')
		        .textContent('Debe diligenciar la totalidad de los campos de tipo negociacion para agregar un nuevo registro')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		}else{
			$scope.arrayTipoNegociacion.push(obj);
			$scope.objtipoNeg = {};
		}
	}


	$scope.calcularMaximo = function(){
		var porAcumulado = 0;
		$scope.arrayZona.forEach( function(element, index) {
			porAcumulado += element.szn_ppart;
		});
		return 100 - porAcumulado;
	}

	$scope.imprimir = function(obj){
		console.log(obj);
	}

	$scope.limpiar = function(){
		$scope.arrayZona = [];
		$scope.arraySucursales = [];
	}

	$scope.limpiarSucursales = function(){
		var arreglo = $filter('filter')($scope.VendedorSucursales.t_sucursal, {codcanal : $scope.objeto.sol_can_id.can_id});
		var arregloAgrupado = Object.keys($filter('groupBy')(arreglo, 'cen_movimiento_id'));
		$scope.arregloZonasFiltradas = [];
		arregloAgrupado.forEach(function(obj){
			var dato = $filter('filter')($scope.zonas, {cen_id : parseInt(obj)}, true);
			dato.forEach(function(ob){
				$scope.arregloZonasFiltradas.push(ob);
			});
		});

		$scope.zonasFiltradas = $scope.arregloZonasFiltradas;

		$scope.objeto.sol_cli_id = undefined;		
		$scope.objeto.sol_tipocliente = undefined;
	}

	$scope.removeZona = function(item) { 
		$scope.zonasFiltradas.push(item.szn_coc_id);
		var index = $scope.arrayZona.indexOf(item);
		$scope.arrayZona.splice(index, 1);     		
	}

	$scope.removeTipoNegociacion = function(item) { 
		var index = $scope.arrayTipoNegociacion.indexOf(item);
		$scope.arrayTipoNegociacion.splice(index, 1);  
		$scope.objtipoNeg = {};   		
	}

	$scope.removeCausalNegociacion = function(item) { 
		var index = $scope.arrayCausalNegociacion.indexOf(item);		
		$scope.arrayCausalNegociacion.splice(index, 1); 
		$scope.causalesNego.push(item.scn_can_id);
	}


	$scope.removeLinea = function(item) { 
		$scope.lineas.push(item);
		var index = $scope.arrayLineas.indexOf(item);
		$scope.arrayLineas.splice(index, 1); 
	}	

	$scope.formatoDescuentoComer = function(){		
		if ($scope.objeto.sol_cli_id != undefined) {
			var lista = $filter('where')($scope.listaPrecios, {lis_id : $scope.objeto.sol_cli_id.lis_id});
			$scope.objeto.listaprecios = lista[0].lis_txt_descrip;
			$scope.objeto.sol_cli_id.cli_txt_dtocome = Math.round($scope.objeto.sol_cli_id.cli_txt_dtocome);
			$scope.sucursalesFiltPorCliente();
			$scope.arrayEventoTemp = [];
			var arrayEv = [];
			// Filtro el arreglo de evento Temporada $scope.arrayEventoTemp
			$scope.datos = $filter('filter')($scope.eventoTemp, {evt_can_id : $scope.objeto.sol_can_id.can_id.trim(), evt_idTercero : $scope.objeto.sol_cli_id.ter_id, evt_tipo : 1});
			arrayEv.push($scope.datos);
			if ($scope.datos.length == 0) {
				$scope.datos = $filter('filter')($scope.eventoTemp, {evt_can_id : $scope.objeto.sol_can_id.can_id.trim(), evt_idTercero : "", evt_tipo : 1}, true);
				arrayEv.push($scope.datos);
			}
			$scope.datos = $filter('filter')($scope.eventoTemp, {evt_can_id : $scope.objeto.sol_can_id.can_id.trim(), evt_tipo : 2});
			arrayEv.push($scope.datos);
			arrayEv.forEach( function(element, index) {
				element.forEach( function(value, key) {
					if (value.evt_tipo == 1) {
						value.descTipoEvento = "Evento";
					}else if(value.evt_tipo == 2){
						value.descTipoEvento = "Temporada";
					}
					$scope.arrayEventoTemp.push(value);
				});
			});
		}
	}

	$scope.diffmesesFacturacion = function(){

		if ($scope.objeto.sol_peri_facturafin != undefined && $scope.objeto.sol_peri_facturaini != undefined && $scope.objeto.sol_peri_facturafin > $scope.objeto.sol_peri_facturaini) {
			var fecha1 = moment($scope.objeto.sol_peri_facturafin);
			var fecha2 = moment($scope.objeto.sol_peri_facturaini);
			$scope.objeto.sol_mesesfactu = fecha1.diff(fecha2, 'months', true).toFixed(1);
		}else if($scope.objeto.sol_peri_facturafin < $scope.objeto.sol_peri_facturaini){
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('')
		        .textContent('La fecha inicio del periodo de facturacion es mayor a la fecha fin')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		    $scope.objeto.sol_mesesfactu = undefined;
		    $scope.objeto.sol_peri_facturafin = undefined;
		}
		
	}

	$scope.diffmesesComparacion = function(){

		if ($scope.objObjetivos.soo_pecomfin != undefined && $scope.objObjetivos.soo_pecomini != undefined && $scope.objObjetivos.soo_pecomfin > $scope.objObjetivos.soo_pecomini) {
			var fecha1 = moment($scope.objObjetivos.soo_pecomfin);
			var fecha2 = moment($scope.objObjetivos.soo_pecomini);
			$scope.objObjetivos.soo_mese = fecha1.diff(fecha2, 'months', true).toFixed(1);
		}else if($scope.objObjetivos.soo_pecomfin < $scope.objObjetivos.soo_pecomini){
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('')
		        .textContent('La fecha inicio del periodo de comparacion es mayor a la fecha fin')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		    $scope.objObjetivos.soo_mese = undefined;
		    $scope.objObjetivos.soo_pecomfin = undefined;
		}
		
	}

	$scope.diffmesesEjecucion = function(){

		if ($scope.objeto.sol_peri_ejefin != undefined && $scope.objeto.sol_peri_ejeini != undefined && $scope.objeto.sol_peri_ejefin > $scope.objeto.sol_peri_ejeini) {
			var fecha1 = moment($scope.objeto.sol_peri_ejefin);
			var fecha2 = moment($scope.objeto.sol_peri_ejeini);
			$scope.objeto.sol_meseseje = fecha1.diff(fecha2, 'months', true).toFixed(1);
		}else if($scope.objeto.sol_peri_ejefin < $scope.objeto.sol_peri_ejeini){
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('')
		        .textContent('La fecha inicio del periodo de ejecucion es mayor a la fecha fin')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		    $scope.objeto.sol_meseseje = undefined;
		    $scope.objeto.sol_peri_ejefin = undefined;
		}
		
	}

	$scope.sucursalesFiltPorCliente = function(){
		$scope.nuevoFiltrado = angular.copy($filter('filter')($scope.multiSelectSucursales, {cli_id : $scope.objeto.sol_cli_id.cli_id, codcanal : $scope.objeto.sol_can_id.can_id.trim()}, true));
		$scope.nuevoFiltrado = $scope.nuevoFiltrado.map(function(element){
			element.descripcionConId = element.suc_num_codigo + " - " + element.suc_txt_nombre + " - " + element.suc_txt_direccion;
			return element;
		});
	}

	$scope.agregarSucursales = function(){
		// calculo el porcentaje de participacion
		var cantidadRegistros = $scope.objeto.sucursales.length + $scope.arraySucursales.length;
		$scope.porcentParticipacion = 100 / cantidadRegistros;
		$scope.porcentParticipacion = $scope.porcentParticipacion.toFixed(2);

		$scope.objeto.sucursales.forEach( function(element, index) {
			$scope.arraySucursales.push(element);
		});	

		var faltante = (100 - ($scope.arraySucursales.length * $scope.porcentParticipacion)).toFixed(2);
		$scope.arraySucursales.forEach( function(el, key) {
			el.porcentParti = $scope.porcentParticipacion;
			$scope.nuevoFiltrado = angular.copy($filter('removeWith')($scope.nuevoFiltrado, {suc_id : el.suc_id}));
		});

		if ($scope.arraySucursales.length > 0) {
			$scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti = (parseFloat($scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti) + parseFloat(faltante)).toFixed(2);
		}		
		$scope.objeto.sucursales = [];	
	}


	$scope.removeSucursal = function(item) { 
		$scope.nuevoFiltrado.push(angular.copy(item));
		var index = $scope.arraySucursales.indexOf(item);
		$scope.arraySucursales.splice(index, 1); 
		// Calculo el porcentaje de participacion para cada registro
		var cantidadRegistros = $scope.objeto.sucursales.length + $scope.arraySucursales.length;
		$scope.porcentParticipacion = 100 / cantidadRegistros;		
		$scope.porcentParticipacion = $scope.porcentParticipacion.toFixed(2);

		// Calculo el faltante
		var faltante = (100 - ($scope.arraySucursales.length * $scope.porcentParticipacion)).toFixed(2);
   
		// Agrego nuevamente el porcentaje de participacion
		$scope.arraySucursales.forEach( function(el, key) {
			el.porcentParti = $scope.porcentParticipacion;
		});
		// Agrego el faltante al ultimo
		if ($scope.arraySucursales.length > 0) {
			$scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti = (parseFloat($scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti) + parseFloat(faltante)).toFixed(2);   		
		}		
	}	

	$scope.sumPorcentPart = function(){
		$scope.sumPorcentPartLin = 0;
		if ($scope.arrayLineas.length > 0) {
			$scope.arrayLineas.forEach( function(element, index) {
				if (element.porcentParti != undefined) {
					$scope.sumPorcentPartLin += parseInt(element.porcentParti);
				}
			});	
		}		
		return $scope.sumPorcentPartLin;
	}

	$scope.agregarLineas = function(){
		// calculo el porcentaje de participacion
		$scope.objeto.lineas.forEach( function(element, index) {
			$scope.arrayLineas.push(element);
		});	

		$scope.arrayLineas.forEach( function(el, key) {
			var index = $scope.lineas.indexOf(el);
			$scope.lineas.splice(index, 1);
		});
		$scope.objeto.lineas = [];	
	}

	$scope.calculaCostoNegoLinea = function(obj){
		if (obj.porcentParti != undefined) {
			var arregloParaSumar = $scope.arrayTipoNegociacion.map(function(element){
				var costo = element.stn_costo;
				return element.stn_costo;
			});
			var sumatoriaNew = ($filter('sum')(arregloParaSumar) * obj.porcentParti) / 100;
			return sumatoriaNew.toFixed(2);
		}
	}

	document.onpaste = function(){

		var invalidAccion = $mdDialog.alert()
		.parent(angular.element(document.querySelector('#popupContainer')))
		.clickOutsideToClose(false)
		.title('Acción no permitida')
		.textContent('No puede copiar y pegar en este formulario.')
		.ariaLabel('Lucky day')
		.ok('OK')

		$mdDialog.show(invalidAccion);

		return false;

	}

	$scope.calculaFaltanteSucu = function(){
		var valor = 0;
		$scope.arraySucursales.forEach( function(element, index) {
			if (element.porcentParti === 'null' || element.porcentParti == undefined ) {
				valor = 0 + valor;
			}else{
				valor = parseFloat(element.porcentParti) + valor;
			}
			
		});	
		return (100 - valor).toFixed(2);
	}

	// Agrega el faltante a un elemento de la lista de sucursales cuando le da al boton agregar faltante +
	$scope.agregarFaltante = function(obj){
		obj.porcentParti = (parseFloat(obj.porcentParti) + parseFloat($scope.calculaFaltanteSucu())).toFixed(2);
	}

	$scope.filtrarTiposServicios = function(idFiltro){
		var traer = $filter('filter')($scope.arrayTipoNegociacion, {stn_tin_id : { tin_id :  idFiltro}});
		$scope.tipoDeServicioFilt = $scope.tipoDeServicio;
		traer.forEach( function(element, index) {
			$scope.tipoDeServicioFilt = $filter('removeWith')($scope.tipoDeServicioFilt, {ser_id : element.stn_ser_id.ser_id});
		});		
	}

	$scope.save = function(form){
		// creo la solicitud con estado que se encuentra la solicitud en elaboracion(0) y estado final de la solicitud(1).
		if (form.$invalid) {
			var invalidAccion = $mdDialog.alert()
			.parent(angular.element(document.querySelector('#popupContainer')))
			.clickOutsideToClose(false)
			.title('')
			.htmlContent('<p>Por favor diligenciar los campos obligatorios marcados en rojo</p>')
			.ariaLabel('Lucky day')
			.ok('OK')
			$mdDialog.show(invalidAccion);
			if ($scope.objeto.sol_id != undefined) {
				$window.location.reload();				
			}
			return false;
		}
		$scope.progress = true;
		$scope.envioPost = $scope.convertirObjeto(angular.copy($scope.objeto), 0, 1, 0);
		$scope.envioPost.arrayZona = $scope.arrayZona;
		$scope.envioPost.arraySucursales = $scope.arraySucursales;
		$scope.envioPost.arrayTipoNegociacion = $scope.arrayTipoNegociacion;
		$scope.envioPost.arrayCausalNegociacion = $scope.arrayCausalNegociacion;
		$scope.envioPost.objCostos = $scope.objCostos;
		$scope.envioPost.arrayLineas = $scope.arrayLineas;
		$scope.envioPost.objObjetivos = $scope.objObjetivos;

		var bandera = true;
		var errorString = "";

		

		if ($scope.arraySucursales.length > 0 && $scope.calculaFaltanteSucu() != "0.00") {
				bandera = false;
				errorString += 'El porcentaje de participacion de las sucursales debe ser del 100% (PESTAÑA INFORMACION DE LA SOLICITUD)';
		}
		console.log($scope.pestanaSeleccionada[1]);
		if ($scope.pestanaSeleccionada[1] == 1 && $scope.objeto.sol_id != undefined) {
			if ($scope.arrayLineas.length > 0 && $scope.sumPorcentPart() != 100) {
				bandera = false;
				errorString += 'El porcentaje de participacion debe ser igual a 100 entre todas las lineas seleccionadas ';
			}else if($scope.arrayLineas.length == 0){
				bandera = false;
				errorString += 'Debe diligenciar al menos una linea de la negociacion con su respectivo porcentaje de participación';
			}else if($scope.lineasTienenPorcentaje()){
				bandera = false;
				errorString += 'Todas las lineas seleccionadas deben tener porcentaje de participación ';
			}
		}

		if ($scope.pestanaSeleccionada[1] == 0) {
			if ($scope.arrayZona.length == 0 && $scope.arraySucursales.length == 0) {
				if ($scope.objeto.sol_tipocliente.id == 1) {
					errorString += 'Favor ingresar al menos una zona <br>';
				}else if($scope.objeto.sol_tipocliente.id == 2){
					errorString += 'Favor ingresar al menos una sucursal <br>';
				}
				bandera = false;				
			}

			if ($scope.arrayZona.length > 0 && $scope.calcularMaximo() > 0) {
				errorString += 'La suma del porcentaje de participacion de las zonas debe ser igual a 100%';
				bandera = false;
			}

			if ($scope.arrayTipoNegociacion.length == 0) {
				errorString += 'Favor ingresar al menos un tipo de negociacion ';
				bandera = false;
			}

			if ($scope.arrayCausalNegociacion.length == 0) {
				errorString += 'Favor ingresar al menos un causal de negociacion';
				bandera = false;
			}
		}

		$scope.envioPost.redirecTo = $scope.siguiente;

		if (bandera) {
			//Debo validar que arrayZonas o ArraySucursales tengan al menos un registro y que la sumatoria de los porcentajes de participacion sea igual a 100 
			if ($scope.objeto.sol_id == undefined) {
				$http.post('../solicitud', $scope.envioPost).then(function(response){
					var res = response.data;
					console.log(res);
					$window.location = res.url;
				}, function(errorResponse){
					alert("Error al grabar");
				});
			}else{
				$http.put('../../solicitud/' + $scope.objeto.sol_id, $scope.envioPost).then(function(response){
					var res = response.data;
					console.log(res);
					$window.location = res.url;
				}, function(errorResponse){
					alert("Error al grabar");
				});
			}
		}else{		
			var confirm = $mdDialog.confirm()
	          .title('')
	          .textContent(errorString)
	          .ariaLabel()
	          .ok('Entendido');
			$scope.progress = false;
		    $mdDialog.show(confirm).then(function() {
		    	$scope.progress = true;
		      	$window.location.reload();
		    });
		}	
	}

	$scope.convertirObjeto = function(object, estadoSolicitud, estadoFinalSolicitud, estadoTesorieria){
		var objetoNew = {};
		objetoNew = angular.copy(object);
		objetoNew.sol_evt_id = object.sol_evt_id.evt_id;
		objetoNew.sol_ser_id = estadoSolicitud;	
		objetoNew.sol_sef_id = estadoFinalSolicitud;
		objetoNew.sol_set_id = estadoTesorieria;
		objetoNew.sol_zona = 3; //Zona quemada la tengo que obtener de los niveles de aprobacion  **
		objetoNew.sol_can_id = object.sol_can_id.can_id;
		objetoNew.sol_lis_id = object.sol_cli_id.lis_id;
		objetoNew.sol_cli_id = object.sol_cli_id.cli_id;
		objetoNew.sol_clase = object.sol_clase.id;
		objetoNew.sol_tipocliente = object.sol_tipocliente.id;	
		objetoNew.sol_descomercial = object.sol_cli_id.cli_txt_dtocome;
		objetoNew.sol_peri_facturaini = $filter('date')(object.sol_peri_facturaini, 'yyyy-MM-dd');	
		objetoNew.sol_peri_facturafin = $filter('date')(object.sol_peri_facturafin, 'yyyy-MM-dd');	
		objetoNew.sol_peri_ejeini = $filter('date')(object.sol_peri_ejeini, 'yyyy-MM-dd');	
		objetoNew.sol_peri_ejefin = $filter('date')(object.sol_peri_ejefin, 'yyyy-MM-dd');	
		objetoNew.sol_llegoacta = 2
		objetoNew.sol_tipo = object.sol_tipo.id;	
		objetoNew.sol_observaciones = object.sol_ltxt_observ	
		objetoNew.sol_estadocobro = 0;
		objetoNew.sol_huella_capitalizar = object.sol_huella_capitalizar.id;			
		return objetoNew;
	}

	$scope.lineasTienenPorcentaje = function(){
		$scope.verificacion = false;
		$scope.arrayLineas.forEach(function(element){
			if (element.porcentParti == undefined) {
				$scope.verificacion = true;
			}
		});
		return $scope.verificacion;
	}


	$scope.calcularIva = function(){
		var valorIva = 0;
		if($scope.objeto.soli_tipo_nego != undefined){
			$scope.objeto.soli_tipo_nego.forEach(function(element) {		    
				valorIva += element.stn_valor_iva;
			});
		}		
		return valorIva;
	}


	$scope.calcularSubtotalCliente = function(){
		var valorIva = 0;
		var valorTipoNego = 0;
		if($scope.objeto.soli_tipo_nego != undefined){
			$scope.objeto.soli_tipo_nego.forEach(function(element) {		    
				valorIva += element.stn_valor_iva;
				valorTipoNego += element.stn_costo;
			});
		}

		return valorIva + valorTipoNego;
	}

	$scope.calcularRetefuente = function(){
		var valorReteFuente = 0;
		if($scope.objeto.soli_tipo_nego != undefined){
			$scope.objeto.soli_tipo_nego.forEach(function(element) {	   
				valorReteFuente += element.stn_valor_rtfuente;
			});
		}		
		return valorReteFuente;
	}

	$scope.calcularReteIca = function(){
		var valorReteIca = 0;
		if($scope.objeto.soli_tipo_nego != undefined){
			$scope.objeto.soli_tipo_nego.forEach(function(element) {	
				valorReteIca += element.stn_valor_rtica;
			});
		}		
		return valorReteIca;
	}

	$scope.calcularReteIva = function(){
		var valorReteIva = 0;
		if($scope.objeto.soli_tipo_nego != undefined){
			$scope.objeto.soli_tipo_nego.forEach(function(element) {	
				valorReteIva += element.stn_valor_rtiva;
			});
		}		
		return valorReteIva;
	}

	$scope.calcularObjetivos = function(){
		if ($scope.objObjetivos.soo_pecomfin != undefined && $scope.objObjetivos.soo_pecomini != undefined && $scope.objObjetivos.soo_pecomfin > $scope.objObjetivos.soo_pecomini) {
			$scope.progress = true;
			$scope.objeto.objObjetivos = $scope.objObjetivos;
			$scope.objeto.arraySucursales = $scope.arraySucursales;
			$http.post('../../calcularObjetivos', $scope.objeto).then(function(response){
				var respuesta = response.data;
				$scope.objObjetivos.soo_costonego = $scope.sumarTipoNego();
				$scope.objObjetivos.soo_venprolin6m = ($scope.sumarArreglo(respuesta.soo_venprolin6m) / 6).toFixed(2);
				$scope.objObjetivos.soo_ventapromtotal = $scope.sumarArreglo(respuesta.soo_ventapromtotal);
				if (isNaN($scope.objObjetivos.soo_ventapromtotal) || $scope.objObjetivos.soo_ventapromtotal == Infinity || $scope.objObjetivos.soo_ventapromtotal == "") {
					$scope.objObjetivos.soo_ventapromtotal = 0;
				}
				$scope.objObjetivos.soo_ventapromseisme = ($scope.sumarArreglo(respuesta.soo_ventapromseisme) / 6).toFixed(2);
				if (isNaN($scope.objObjetivos.soo_ventapromseisme) || $scope.objObjetivos.soo_ventapromseisme == Infinity || $scope.objObjetivos.soo_ventapromseisme == "") {
					$scope.objObjetivos.soo_ventapromseisme = 0;
				}
				$scope.objObjetivos.soo_venpromeslin = $scope.sumarArreglo(respuesta.soo_venpromeslin);		
				$scope.objObjetivos.soo_vemesantes = $scope.sumarArreglo(respuesta.soo_vemesantes);		
				$scope.objObjetivos.soo_vemesdespues = $scope.sumarArreglo(respuesta.soo_vemesdespues);	
				$scope.objObjetivos.arreglo = angular.copy(respuesta.arreglo);	
				$scope.objObjetivos.soo_ventaestitotal = undefined; 
				$scope.arrayLineas = $scope.arrayLineas.map(function(obj){
					var dato = $filter('filter')($scope.objObjetivos.arreglo, { codlinea : obj.lin_id });
					if (dato.length > 0) {
						obj.scl_valorventa = dato[0]['total'];
						obj.scl_pvalorventa = ((obj.scl_valorventa / $scope.objObjetivos.soo_ventapromtotal) * 100).toFixed(2);
					}else{
						obj.scl_valorventa = 0;
						obj.scl_pvalorventa = 0;
					}
					return obj;
				});
				$scope.objObjetivos.soo_venestlin = $scope.objeto.sol_ventaestimada;
				if ($scope.objObjetivos.soo_venestlin == null) {
					$scope.objObjetivos.soo_venestlin = 0;
				}
				if($scope.objObjetivos.soo_venestlin == "" && $scope.objObjetivos.soo_venpromeslin != '0.00'){
		            $scope.objObjetivos.soo_pinventaestiline = 0;
		            $scope.objObjetivos.soo_ventmargilin = 0;
		            $scope.objObjetivos.soo_pcrelin = 0;
		            $scope.objObjetivos.soo_pvenmarlin = 0;
		        }else{
		        	var soo_pinventaestiline = (($scope.objObjetivos.soo_costonego / $scope.objObjetivos.soo_venestlin) * 100).toFixed(2);
					 if(isNaN(soo_pinventaestiline) || soo_pinventaestiline == Infinity || soo_pinventaestiline == ""){
		                $scope.objObjetivos.soo_pinventaestiline = 0;
		            }else{
		                $scope.objObjetivos.soo_pinventaestiline = soo_pinventaestiline;
		            }   

		            // Campo Venta marginal lineas
		            // Formula Si selecciona 1 Huella año anterior= venta estimada lineas - (venta promedio mes lineas periodo compracion * meses facturacion)
		            // Formular si selecciona 2 Capitalizar Oportunidad= venta estimada líneas – (venta promedio mes línea a activar – últimos 6 meses * meses de facturación)

		            if($scope.objeto.sol_huella_capitalizar.id == '1'){
		                var soo_ventmargilin = ($scope.objObjetivos.soo_venestlin - (parseFloat($scope.objObjetivos.soo_venpromeslin) * $scope.objeto.sol_mesesfactu));               
		            }else{                
		                var soo_ventmargilin = ($scope.objObjetivos.soo_venestlin - (parseFloat($scope.objObjetivos.soo_venprolin6m) *  $scope.objeto.sol_mesesfactu)).toFixed(2);                                           
		            }
		            if(isNaN(soo_ventmargilin || soo_ventmargilin == Infinity || soo_ventmargilin == "")){
		                $scope.objObjetivos.soo_ventmargilin = 0;	                    
	                }else{                    
		                $scope.objObjetivos.soo_ventmargilin = parseFloat(soo_ventmargilin).toFixed(2);
	                }

		            var soo_pcrelin = (($scope.objObjetivos.soo_ventmargilin / ($scope.objObjetivos.soo_venpromeslin* $scope.objeto.sol_mesesfactu))*100).toFixed(2);
		            if(isNaN(soo_pcrelin) || soo_pcrelin == Infinity || soo_pvenmarlin == "" || soo_pcrelin == -Infinity){
		                $scope.objObjetivos.soo_pcrelin = 0;
		            }else{
		                $scope.objObjetivos.soo_pcrelin = soo_pcrelin;
		            }   

		            var soo_pvenmarlin = (($scope.objObjetivos.soo_costonego / $scope.objObjetivos.soo_ventmargilin) * 100).toFixed(2);
		            if(isNaN(soo_pvenmarlin) || soo_pvenmarlin == Infinity || soo_pvenmarlin == ""){
		                $scope.objObjetivos.soo_pvenmarlin = 0;
		            }else{
		                $scope.objObjetivos.soo_pvenmarlin = soo_pvenmarlin;
		            } 

		           	$scope.calcularCrecimientoEstimadoCliente();
		           	$scope.progress = false;
		        }				         
 
			}, function(errorResponse){
				$scope.calcularObjetivos();
			});
		}else{
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('')
		        .textContent('Debe ingresar las fechas del periodo de comparacion para realizar el calculo de valores')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		}
	}

	$scope.calcularCrecimientoEstimadoCliente = function(){
		if($scope.objObjetivos.soo_ventaestitotal == '$' || $scope.objObjetivos.soo_ventaestitotal == '$ '){
			$scope.objObjetivos.soo_ventaestitotal = undefined;
		}
		$scope.objObjetivos.soo_pcreciestima  = (((parseFloat($scope.objObjetivos.soo_ventaestitotal) - (parseFloat($scope.objObjetivos.soo_ventapromtotal) * parseFloat($scope.objeto.sol_mesesfactu))) / (parseFloat($scope.objObjetivos.soo_ventapromtotal) * parseFloat($scope.objeto.sol_mesesfactu))) * parseFloat(100)).toFixed(2);
		if ($scope.objObjetivos.soo_pcreciestima < 0 || isNaN($scope.objObjetivos.soo_pcreciestima)|| $scope.objObjetivos.soo_pcreciestima == Infinity) {
			$scope.objObjetivos.soo_pcreciestima = 0;
		}
		$scope.calcularVentaMarginalCliente();
		$scope.calcularPorcentajeEstimadoVentaTotalCliente();
		$scope.porcentInverSobreVentaMarginalLineas();
		$scope.ventaPromMesPeriodoComparacion();
	}

	$scope.calcularVentaMarginalCliente = function(){
		/*****************************************************
		* Campo venta marginal cliente
		* Formula= venta estimada del total cliente - (venta promedio mes total cliente periodo comparacion * meses facturacion)        
		******************************************************/
		if($scope.objeto.sol_huella_capitalizar.id == '1'){
		    var soo_ventamargi = parseFloat($scope.objObjetivos.soo_ventaestitotal) - (parseFloat($scope.objObjetivos.soo_ventapromtotal)  * parseFloat($scope.objeto.sol_mesesfactu));	                        
		}else{
		    var soo_ventamargi = (parseFloat($scope.objObjetivos.soo_ventaestitotal) - (parseFloat($scope.objObjetivos.soo_ventapromseisme) * parseFloat($scope.objeto.sol_mesesfactu))).toFixed(2);                                         
		}
		if(isNaN(soo_ventamargi) || soo_ventamargi < 0){
		   	$scope.objObjetivos.soo_ventamargi = 0;	                    
		}else{                    
		    $scope.objObjetivos.soo_ventamargi = parseFloat(soo_ventamargi).toFixed(2);
		}
	}

	$scope.calcularPorcentajeEstimadoVentaTotalCliente = function(){
		/************************************************************
        * Campo % de inversion sobre la venta estimada total cliente 
        * Formula= (costo de la negociacion / venta estimada del total cliente)*100        
        *************************************************************/
        var resul = 0;
        if(parseFloat($scope.objObjetivos.soo_ventaestitotal) > 0){
         resul = ((parseFloat($scope.objObjetivos.soo_costonego) / parseFloat($scope.objObjetivos.soo_ventaestitotal)) * 100).toFixed(2);
        }                
        $scope.objObjetivos.soo_pinverestima = resul;
	}


	$scope.porcentInverSobreVentaMarginalLineas = function(){
		/********************************************************************
	    * Campo % de inversion sobre la venta marginal total cliente
	    * Formula = (costo de la negociacion / venta marginal cliente)* 100
	    *********************************************************************/
	    var resultado = ((parseFloat($scope.objObjetivos.soo_costonego) / parseFloat($scope.objObjetivos.soo_ventamargi)) * 100).toFixed(2);                
	    if(isNaN(resultado) || resultado < 0 || resultado == Infinity){
	        resultado = 0;
	    }
	    $scope.objObjetivos.soo_pinvermargi = resultado;
	}
    
    $scope.ventaPromMesPeriodoComparacion = function(){
    	/***********************************************************************
        * Campo venta promedio mes periodo comparacion
        * Formula= venta promedio mes total cliente periodo comparacion - venta promedio mes lineas periodo comparacion         
        ************************************************************************/
        $scope.objObjetivos.soo_veprome = (parseFloat($scope.objObjetivos.soo_ventapromtotal) - parseFloat($scope.objObjetivos.soo_venpromeslin)).toFixed(2);
        if (isNaN($scope.objObjetivos.soo_veprome) || $scope.objObjetivos.soo_veprome < 0 || $scope.objObjetivos.soo_veprome == Infinity) {
        	$scope.objObjetivos.soo_veprome = 0;
        }
    }	

	$scope.sumarArreglo = function(arreglo){
		var arrayTotales = arreglo.map(function(obj){
			return parseFloat(obj.total);
		});
		return $filter('sum')(arrayTotales).toFixed(2);
	}

	$scope.cambiarPestanaSeleccionada = function(numeroPestana, formulario){
		var pestanaAnterior = $scope.pestanaSeleccionada[0];
		$scope.pestanaSeleccionada[0] = numeroPestana;
		$scope.pestanaSeleccionada[1] = pestanaAnterior;

		if (numeroPestana == 0) {
			$scope.siguiente = 'grabar.1';
		}
		if (numeroPestana == 1) {
			$scope.siguiente = 'grabar.2';
		}
		if (numeroPestana == 2) {
			$scope.siguiente = 'grabar.3';
		}

		if ($scope.pestanaSeleccionada[0] == 0 && $scope.pestanaSeleccionada[1] == 1) {
			$scope.conteo = $scope.conteo + 1;
		}

		if ($scope.conteo == 0 || $scope.conteo == 1) {
			$scope.conteo = $scope.conteo + 1;
		}else if($scope.conteo >= 2){
			$scope.save($scope[$scope.arrayFormularios[$scope.pestanaSeleccionada[1]]]);
		}		
	}


}])