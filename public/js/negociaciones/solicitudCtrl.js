app.controller('solicitudCtrl', ['$scope', '$http', '$filter', '$mdDialog',  function ($scope, $http, $filter, $mdDialog) {
	
	$scope.objeto = {};
	$scope.objNegCliente = {};
	$scope.objeto.sol_fecha = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
	$scope.progress = true;
	$scope.arrayZona = [];

	$scope.getInfo = function(){
		$http.get('../solicitudGetInfo').then(function(response){
			var res = response.data;
			$scope.objeto.sol_ven_id = res.usuario.idTerceroUsuario;
			$scope.objeto.usuario = res.usuario.nombre + " " + res.usuario.apellido;
			$scope.claseNegociacion = res.claseNegociacion;			
			$scope.negoAnoAnterior = res.negoAnoAnterior;
			$scope.tipNegociacion = res.tipNegociacion;
			$scope.canales = res.canales;
			$scope.VendedorSucursales = res.VendedorSucursales
			$scope.clientes = res.clientes;
			$scope.negociacionPara = res.negociacionPara;
			$scope.zonas = res.zonas;
			$scope.listaPrecios = res.listaPrecios;
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
	}

	$scope.removeZona = function(item) { 
		$scope.zonas.push(item.szn_coc_id);
		var index = $scope.arrayZona.indexOf(item);
		$scope.arrayZona.splice(index, 1);     
	}

	$scope.formatoDescuentoComer = function(){		
		if ($scope.objeto.sol_cli_id != undefined) {
			console.log($scope.listaPrecios);
			console.log($scope.objeto.sol_cli_id.lis_id);
			var lista = $filter('fuzzyBy')($scope.listaPrecios, {lis_id : $scope.objeto.sol_cli_id.lis_id});
			console.log(lista);
			$scope.objeto.sol_cli_id.cli_txt_dtocome = Math.round($scope.objeto.sol_cli_id.cli_txt_dtocome);
		}
	}



}])