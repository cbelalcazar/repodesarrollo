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
  	}

}]);