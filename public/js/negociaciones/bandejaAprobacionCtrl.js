app.controller('bandejaCtrl', ['$scope', '$http', '$filter', '$window', function($scope, $http, $filter, $window){

	$scope.getUrl = "bandejaGetInfo";
	$scope.progress = true;

	$scope.tipoNegociacion = ['Comercial', 'Mercadeo', 'Comercial y Mercadeo'];
	
	$scope.getInfo = function(){
		$http.get($scope.getUrl).then(function(response){			
			data = response.data;
			$scope.solicitudes = angular.copy(data.solicitudes);
			$scope.pernivelUsu = angular.copy(data.pernivelUsu);
			$scope.usuario = angular.copy(data.usuario);
			$scope.progress = false;
		}), function(errorResponse){
				console.log(errorResponse);
				$scope.getInfo();
		};
	};

	$scope.getInfo();


  	$scope.setSolicitud = function(objeto){
  		$scope.infoSolicitud = objeto;
  		$scope.date = new Date();

  		if (($scope.infoSolicitud.sol_sef_id == 2) || ($scope.infoSolicitud.sol_sef_id == 3)) {
  			$scope.pendienteGestion = 'Evaluación';
  		}else{
  			$scope.pendienteGestion = 'Ninguno';	
  		}
  		
  		$scope.infoSolicitud.sol_peri_ejeini = new Date($filter('date')($scope.infoSolicitud.sol_peri_ejeini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
  		$scope.infoSolicitud.sol_peri_ejefin = new Date($filter('date')($scope.infoSolicitud.sol_peri_ejefin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));

  		$scope.ultimoProceso = $scope.infoSolicitud.his_proceso.slice(-1);
  		$scope.variacionObj = ($scope.infoSolicitud.objetivo.soo_vemesdespues/$scope.infoSolicitud.objetivo.soo_veprome);

  	}

  	$scope.aprobar = function(obj){
  		$scope.message = [];
  		$scope.infoSolicitud = obj;
  	}

  	$scope.validarTipoSolicitud = function(obj){
  		if (obj == undefined) {
  			return false;
  		}
  		return (obj.sol_tipnegoniv == "Mercadeo" || obj.sol_tipnegoniv == "Comercial y Mercadeo");
  	}

  	$scope.generarAprobacion = function(obj){
  		obj.usuarioAprobador = $scope.usuario;
  		$scope.progress = true;
  		$http.put('bandejaAprobacion/' + obj.sol_id, obj).then(function(response){
      var res = response.data;			
			if (res.errorRuta.length == 0) {
        $window.location = res.url;
      }else{
        $scope.progress = false;
        $scope.errorMessage = res.errorRuta;
        $interval(function() {
          $scope.errorMessage = [];
            }, 20000);
      }
	
		}), function(errorResponse){
				console.log(errorResponse);
				$scope.getInfo();
		};
  	}

}]);