app.controller('misSolicitudesCtrl', ['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder, $mdDialog){

	$scope.getUrl = "misSolicitudesInfo";
	$scope.Url = "misSolicitudes";
    $scope.progress = true;
	
	$scope.getInfo = function(){
		$scope.todas = [];
		$scope.aprobacion = [];
		$http.get($scope.getUrl).then(function(response){
			
			data = response.data;
			$scope.todas = angular.copy(data.solicitudes);
			$scope.usuariolog = angular.copy(data.usuario);
			console.log($scope.todas);
			console.log($scope.usuariolog);

			$scope.elaboracion =  $filter('filter')($scope.todas, {sol_ser_id : 0, sol_sef_id : 1});
			$scope.correciones =  $filter('filter')($scope.todas, {sol_ser_id : 8, sol_sef_id : 1});
			$scope.anuladas =  $filter('filter')($scope.todas, {sol_ser_id : 9, sol_sef_id : 4});
			$scope.solicitudes =  $filter('filter')($scope.todas, {sol_ser_id : 1, sol_sef_id : 1});
			$scope.filtros =  $filter('filter')($scope.todas, {sol_ser_id : 2, sol_sef_id : 1});

			$scope.filtrosAprobacion = [3, 4, 5, 6, 7];
			$scope.aprobacion = [];
			$scope.filtrosAprobacion.forEach(function(element){
				var arregloAprobacion = $filter('filter')($scope.todas, {sol_ser_id : element, sol_sef_id : 1});
				arregloAprobacion.forEach(function(obj){
					$scope.aprobacion.push(obj);
				});				
			});

			$scope.filtrosEvaluacion = [2, 3, 5];
			$scope.evaluacion = [];
			$scope.filtrosEvaluacion.forEach(function(element){
				var arregloEvaluacion = $filter('filter')($scope.todas, {sol_sef_id : element});
				arregloEvaluacion.forEach(function(obj){
					$scope.evaluacion.push(obj);
				});				
			});

			$scope.cerradas =  $filter('filter')($scope.todas, {sol_sef_id : 6});
			$scope.tesoPendientes =  $filter('filter')($scope.todas, {sol_set_id : 3});
			$scope.tesoConfirmadas =  $filter('filter')($scope.todas, {sol_set_id : 4});

			$scope.progress = false;
		}), function(errorResponse){
				console.log(errorResponse);
				$scope.getInfo();
			};
	};
	$scope.getInfo();

	$scope.retornarCadena = function(arregloDeObjetos){
    	var arreglo = arregloDeObjetos.map(function(objeto){
      		return objeto.lineas_detalle.lin_txt_descrip;
    	});
    	return arreglo.join(', ');
  	}

  	$scope.setSolicitud = function(objeto){
  		$scope.infoSolicitud = objeto;
  		$scope.date = new Date();

  		if (($scope.infoSolicitud.sol_sef_id == 2) || ($scope.infoSolicitud.sol_sef_id == 3)) {
  			$scope.pendienteGestion = 'Evaluación';
  		}else{
  			$scope.pendienteGestion = 'Ninguno';	
  		}
  		
  		$scope.ultimoProceso = $scope.infoSolicitud.his_proceso.slice(-1);
  		$scope.variacionObj = ($scope.infoSolicitud.objetivo.soo_vemesdespues/$scope.infoSolicitud.objetivo.soo_veprome);
  		$scope.ventaRealMarginal = ($scope.infoSolicitud.cumplimiento.scu_venreallineas - 
  			($scope.infoSolicitud.objetivo.soo_venpromeslin * $scope.infoSolicitud.sol_mesesfactu));
  		$scope.ventaReal = ($scope.infoSolicitud.cumplimiento.scu_venreallineas - 
  			($scope.infoSolicitud.objetivo.soo_venpromeslin * $scope.infoSolicitud.sol_meseseje));
  		$scope.infoSolicitud.sol_peri_ejeini = new Date($filter('date')($scope.infoSolicitud.sol_peri_ejeini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
  		$scope.infoSolicitud.sol_peri_ejefin = new Date($filter('date')($scope.infoSolicitud.sol_peri_ejefin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
  	}

  	$scope.imprimir = function(){
  		console.log($scope.fotoGuardar);
  	}
  	
  	$scope.diffmesesFechaEjecucion = function(){
		if ($scope.infoSolicitud.sol_peri_ejefin != undefined && $scope.infoSolicitud.sol_peri_ejeini != undefined && $scope.infoSolicitud.sol_peri_ejefin > $scope.infoSolicitud.sol_peri_ejeini) {
			var fecha1 = moment($scope.infoSolicitud.sol_peri_ejefin);
			var fecha2 = moment($scope.infoSolicitud.sol_peri_ejeini);
			$scope.infoSolicitud.sol_meseseje = fecha1.diff(fecha2, 'months', true).toFixed(1);
		}else if($scope.infoSolicitud.sol_peri_ejefin < $scope.infoSolicitud.sol_peri_ejeini){
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('ALERTA!')
		        .textContent('La fecha inicial del periodo de ejecución no puede ser mayor a la fecha final')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		    $scope.infoSolicitud.sol_meseseje = undefined;
		    $scope.infoSolicitud.sol_peri_ejefin = undefined;
		}
	}
}]);