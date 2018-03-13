app.controller('controller', ['$scope', '$http', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$filter', function ($scope, $http, DTOptionsBuilder, DTColumnDefBuilder, $filter) {
	$scope.data = [];
	$scope.urlGetInfo = 'getInfoRefeProgramRecep';
	$scope.url = 'refProgramablesRecep';
	$scope.progress = true;
	$scope.objRefProg = {};
	$scope.mensajeExito = false;

	$scope.getInfo = function(){
		$http.get($scope.urlGetInfo).then(function(response){
			var data = response.data;
			$scope.data.infoReferencias = angular.copy(data.infoReferencias);
			$scope.referenciasTodas = angular.copy(data.referenciasTodas);
		
			$scope.progress = false;

		}, function(errorResponse){
			$scope.getInfo();
		});
	}

	$scope.getInfo();
	$scope.dtOptions = DTOptionsBuilder.newOptions();
	$scope.dtColumnDefs = [];

	$scope.save = function(){
		$scope.progress = true;
		$http.post($scope.url, $scope.objRefProg).then(function(response){
			var data = response.data;
			$scope.mensajeExito = true;
			setTimeout(function() {
				$scope.mensajeExito = false;
			}, 5000);
			$scope.getInfo();
		});
		$scope.objRefProg = {};
		angular.element('.close').trigger('click');
	}

	$scope.query = function(string){
		return $filter('filter')($scope.referenciasTodas, {ite_descripcion : string});
	}

	$scope.borrar = function(obj){
		$scope.progress = true;
		$http.delete($scope.url  + '/' + obj.id).then(function(response){
			var data = response.data;
			$scope.getInfo();
		})
	}

	$scope.limpiar = function(){
		$scope.objRefProg = {};
		$scope.accion = 'Crear';
	}

	$scope.actualizar = function(obj){
		var objeto = angular.copy(obj);
		$scope.accion = 'Actualizar';
		objeto.iref_referencia = objeto.referencia;
		objeto.iref_pesoporempaque = parseInt(objeto.iref_pesoporempaque);
		$scope.objRefProg = objeto;
	}
}])