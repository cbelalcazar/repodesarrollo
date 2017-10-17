app.controller('docEntradaAlmacenCtrl', ['$scope', '$http', '$window', function ($scope, $http, $window) {
	$scope.entradas = [];
	$scope.urlGetInfo = "docEntradaAlmacenGetInfo";
	$scope.progress = true;

	$scope.getInfo = function(){
		$http.get($scope.urlGetInfo).then(function(response){
			res = response.data;
			$scope.entradas = angular.copy(res.entradas);
			$scope.progress = false;
		});
	}

	$scope.edit = function(obj){
		$window.location.href = 'docEntradaAlmacen/' + obj.entm_int_id + '/edit';
	}

	$scope.getInfo();

	
}])