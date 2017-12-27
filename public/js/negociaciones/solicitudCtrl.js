app.controller('solicitudCtrl', ['$scope', '$http', '$filter',  function ($scope, $http, $filter) {
	
	$scope.objeto = {};
	$scope.objeto.sol_fecha = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
	$scope.progress = true;

	$scope.getInfo = function(){
		$http.get('../solicitudGetInfo').then(function(response){
			var res = response.data;
			$scope.objeto.sol_ven_id = res.usuario.idTerceroUsuario;
			$scope.objeto.usuario = res.usuario.nombre + " " + res.usuario.apellido;
			$scope.claseNegociacion = res.claseNegociacion;			
			$scope.negoAnoAnterior = res.negoAnoAnterior;
			$scope.tipNegociacion = res.tipNegociacion;

			console.log($scope.objeto.usuario);
			$scope.progress = false;
		});
	}

	$scope.getInfo();

}])