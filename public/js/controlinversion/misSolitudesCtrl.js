app.controller('misSolitudesCtrl', ['$scope',  '$filter', '$http', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope,  $filter, $http, DTOptionsBuilder, DTColumnDefBuilder){

	$scope.getInfoMisolicitudes = "getInfoMisolicitudes";
	$scope.progress = true;
	$scope.count = [];
	$scope.elaboracion = "0";

	$scope.getInfo = function(){
		$scope.todas = [];

		$scope.dtOptions = DTOptionsBuilder.newOptions()
										.withPaginationType('full_numbers')
										.withDisplayLength(2);
	    
	    $scope.dtColumnDefs = [
	        DTColumnDefBuilder.newColumnDef(0)
	    ];

		$http.get($scope.getInfoMisolicitudes).then(function(response){
			data = response.data;
			$scope.todas = angular.copy(data.solicitudes);
			$scope.elaboracion =  $filter('filter')($scope.todas, {sci_soe_id : 0});
			$scope.solicitud =  $filter('filter')($scope.todas, {sci_soe_id : 1});
			$scope.correcciones =  $filter('filter')($scope.todas, {sci_soe_id : 2});
			$scope.anulada =  $filter('filter')($scope.todas, {sci_soe_id : 3});
			$scope.aprobacion =  $filter('filter')($scope.todas, {sci_soe_id : 4});
			$scope.aprobada =  $filter('filter')($scope.todas, {sci_soe_id : 5});
			$scope.cerrada =  $filter('filter')($scope.todas, {sci_soe_id : 6});
			$scope.aprobacionAuditoria =  $filter('filter')($scope.todas, {sci_soe_id : 7});
		}, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});		

		$scope.progress = false;
	};

	$scope.getInfo();



}]);
