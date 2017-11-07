app.controller('autorizacionCtrl',
['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder',
function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder){


  $scope.urlGetInfo  = './aprobacionGetInfo';


	$scope.getInfo = function(){

    $http.get($scope.urlGetInfo).then(function(response){
      console.log(response.data);
    })

		// $scope.todas = [];
		// $http.get($scope.getInfoMisolicitudes).then(function(response){
		// 	data = response.data;
		// 	$scope.todas = angular.copy(data.solicitudes);
		// 	console.log($scope.todas);
		// 	$scope.todas.forEach(function(solicitud) {
		// 			var fecha_ini = new Date(solicitud.sci_fecha);
		// 			fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
		// 			solicitud.sci_fecha = new Date(fecha_ini);
		// 	}, this);
    //
		// 	$scope.elaboracion =  $filter('filter')($scope.todas, {sci_soe_id : 0});
		// 	$scope.solicitud =  $filter('filter')($scope.todas, {sci_soe_id : 1});
		// 	$scope.correcciones =  $filter('filter')($scope.todas, {sci_soe_id : 2});
		// 	$scope.anulada =  $filter('filter')($scope.todas, {sci_soe_id : 3});
		// 	$scope.aprobacion =  $filter('filter')($scope.todas, {sci_soe_id : 4});
		// 	$scope.aprobada =  $filter('filter')($scope.todas, {sci_soe_id : 5});
		// 	$scope.cerrada =  $filter('filter')($scope.todas, {sci_soe_id : 6});
		// 	$scope.aprobacionAuditoria =  $filter('filter')($scope.todas, {sci_soe_id : 7});
		// 	$scope.progress = false;
		// }, function(errorResponse){
		// 	console.log(errorResponse);
		// 	$scope.getInfo();
		// });


  }





}]);
