app.controller('controller', ['$scope', '$http', 'DTOptionsBuilder', 'DTColumnDefBuilder', function ($scope, $http, DTOptionsBuilder, DTColumnDefBuilder) {
	$scope.data = [];
	$scope.urlGetInfo = 'getInfoRefeProgramRecep';
	$scope.progress = true;
	$scope.objRefProg = {};

	$scope.getInfo = function(){
		$http.get($scope.urlGetInfo).then(function(response){
			var data = response.data;
			$scope.data.infoReferencias = data.infoReferencias;
			$scope.dtOptions = DTOptionsBuilder.newOptions();
			$scope.dtColumnDefs = [];
			$scope.progress = false;

		}, function(errorResponse){
			$scope.getInfo();
		});
	}

	$scope.getInfo();

	$scope.save = function(){
		console.log($scope.objRefProg);
	}
}])