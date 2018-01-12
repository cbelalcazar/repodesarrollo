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


app.controller('solicitudCtrl', ['$scope', '$http', '$filter', '$mdDialog', '$q', '$timeout', '$window', function ($scope, $http, $filter, $mdDialog, $q, $timeout, $window) {
	
	$scope.objeto = {};
	$scope.objNegCliente = {};
	$scope.objtipoNeg = {};
	$scope.objCausalNego = {};
	$scope.objeto.sol_fecha = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
	$scope.progress = true;
	$scope.arrayZona = [];
	$scope.arraySucursales = [];
	$scope.arrayEventoTemp = [];
	$scope.arrayCausalNegociacion = [];
	$scope.arrayTipoNegociacion = [];
	$scope.tipoDeServicioFilt = [];
	$scope.sucubool = true;
	$scope.siguiente = "";

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
	$scope.pasoDosSelect = false;
	$scope.pasoUnoSelect = false;



	$scope.getInfo = function(){
		var url = '../solicitudGetInfo';

		if ($scope.objeto.siguiente == 'create') {			
			$scope.pasoDos = true;
			$scope.pasoTres = true;
			$scope.pasoUnoSelect = true;
		}else if($scope.objeto.siguiente == 'adelante.2'){			
			$scope.pasoTres = true;
			$scope.pasoDosSelect = true;
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
			$scope.multiSelectSucursales = angular.copy(res.VendedorSucursales.t_sucursal);
			$scope.clientes = angular.copy(res.clientes);
			$scope.negociacionPara = angular.copy(res.negociacionPara);
			$scope.zonas = angular.copy(res.zonas);
			$scope.listaPrecios = angular.copy(res.listaPrecios);
			$scope.eventoTemp = angular.copy(res.eventoTemp);
			$scope.tipoDeNegociacion = angular.copy(res.tipoDeNegociacion);
			$scope.tipoDeServicio = angular.copy(res.tipoDeServicio);
			$scope.formaPago = angular.copy(res.formaPago);
			$scope.causalesNego = angular.copy(res.causalesNego);
			$scope.lineas = angular.copy(res.lineas);
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
				$scope.objeto.sol_peri_facturaini = new Date($filter('date')($scope.objeto.sol_peri_facturaini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				$scope.objeto.sol_peri_facturafin = new Date($filter('date')($scope.objeto.sol_peri_facturafin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				$scope.objeto.sol_peri_ejeini = new Date($filter('date')($scope.objeto.sol_peri_ejeini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
				$scope.objeto.sol_peri_ejefin = new Date($filter('date')($scope.objeto.sol_peri_ejefin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));				
				$scope.objeto.sol_ltxt_observ = $scope.objeto.sol_observaciones;
				$scope.objeto.sol_evt_id = $filter('filter')($scope.arrayEventoTemp, {evt_id : $scope.objeto.sol_evt_id})[0];
				
				$scope.objeto.soli_zona = $scope.objeto.soli_zona.map(function(object){
					object.szn_coc_id = $filter('filter')($scope.zonas, {cen_id : object.szn_coc_id})[0];
					return object;
				});
				$scope.arrayZona = $scope.objeto.soli_zona;
				
				$scope.objeto.soli_sucu = $scope.objeto.soli_sucu.map(function(object){
					object.szn_coc_id = $filter('filter')($scope.nuevoFiltrado, {cen_id : object.szn_coc_id})[0];
					return object;
				});
				$scope.arraySucursales = $scope.objeto.soli_sucu;

				$scope.objeto.soli_tipo_nego = $scope.objeto.soli_tipo_nego.map(function(object){
					object.stn_tin_id = $filter('filter')($scope.tipoDeNegociacion, {tin_id : object.stn_tin_id})[0];
					object.stn_ser_id = $filter('filter')($scope.tipoDeServicio, {ser_id : object.stn_ser_id})[0];
					return object;
				});
				$scope.arrayTipoNegociacion = $scope.objeto.soli_tipo_nego;

				$scope.objeto.causal = $scope.objeto.causal.map(function(object){
					object.scn_can_id = $filter('filter')($scope.causalesNego, {can_id : object.scn_can_id})[0];
					$scope.causalesNego = $filter('removeWith')($scope.causalesNego, {can_id : object.scn_can_id.can_id});
					return object;
				});
				$scope.arrayCausalNegociacion = $scope.objeto.causal;

				
			}						
			$scope.objeto.sol_ven_id = angular.copy(res.usuario.idTerceroUsuario);
			$scope.objeto.usuario = angular.copy(res.usuario.nombre + " " + res.usuario.apellido);

			$scope.progress = false;
		}, function(errorResponse){
			$scope.getInfo();
		});
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
		if (obj.szn_coc_id == undefined || obj.szn_ppart == undefined || ($scope.zonas.length == 1 && $scope.objNegCliente.szn_ppart != $scope.calcularMaximo() )) {
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
			$scope.zonas = $filter('removeWith')($scope.zonas, {cen_id : obj.szn_coc_id.cen_id});
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
		$scope.objeto.sol_cli_id = undefined;
		$scope.objeto.sol_tipocliente = undefined;
	}

	$scope.removeZona = function(item) { 
		$scope.zonas.push(item.szn_coc_id);
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

	$scope.removeSucursal = function(item) { 
		$scope.nuevoFiltrado.push(item);
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
		$scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti = (parseFloat($scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti) + parseFloat(faltante)).toFixed(2);   		
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
		$scope.nuevoFiltrado = $filter('filter')($scope.multiSelectSucursales, {cli_id : $scope.objeto.sol_cli_id.cli_id, codcanal : $scope.objeto.sol_can_id.can_id.trim()});
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
			var index = $scope.nuevoFiltrado.indexOf(el);
			$scope.nuevoFiltrado.splice(index, 1);
		});

		$scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti = (parseFloat($scope.arraySucursales[$scope.arraySucursales.length - 1].porcentParti) + parseFloat(faltante)).toFixed(2);
		$scope.objeto.sucursales = [];	
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
			if (element.porcentParti === 'null') {
				element.porcentParti = 0;
			}
			valor = parseFloat(element.porcentParti) + valor;
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

	$scope.save = function(){
		$scope.progress = true;
		// creo la solicitud con estado que se encuentra la solicitud en elaboracion(0) y estado final de la solicitud(1).
		$scope.envioPost = $scope.convertirObjeto(angular.copy($scope.objeto), 0, 1, 0);
		$scope.envioPost.arrayZona = $scope.arrayZona;
		$scope.envioPost.arraySucursales = $scope.arraySucursales;
		$scope.envioPost.arrayTipoNegociacion = $scope.arrayTipoNegociacion;
		$scope.envioPost.arrayCausalNegociacion = $scope.arrayCausalNegociacion;
		$scope.envioPost.redirecTo = $scope.siguiente;
		
		//Debo validar que arrayZonas o ArraySucursales tengan al menos un registro y que la sumatoria de los porcentajes de participacion sea igual a 100 
		if ($scope.objeto.sol_id == undefined) {
			$http.post('../solicitud', $scope.envioPost).then(function(response){
				var res = response.data;
				$window.location = res.url;
			}, function(errorResponse){
				alert("Error al grabar");
			});
		}else{
			$http.put('../../solicitud/' + $scope.objeto.sol_id, $scope.envioPost).then(function(response){
				var res = response.data;
				$scope.progress = false;
				$scope.getInfo();
			}, function(errorResponse){
				alert("Error al grabar");
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
				console.log(element);	    
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


}])