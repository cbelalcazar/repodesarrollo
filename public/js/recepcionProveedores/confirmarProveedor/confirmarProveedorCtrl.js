app.controller('confirmProveedorCtrl', ['$scope', '$http', '$filter', 'DTOptionsBuilder','DTColumnDefBuilder',
	function($scope, $http, $filter, DTOptionsBuilder, DTColumnDefBuilder){

// Definicion de variables
$scope.Url = "confirmarProveedorGetInfo";
$scope.progress = true;

$scope.getInfo = function(){
	$http.get($scope.Url).then(function(response){
		data = response.data;
		$scope.datos = angular.copy(data.programaciones);
		$scope.noProgramables = $filter('filter')($scope.datos, {prg_tipo_programacion: 'NoProgramable'});
		console.log($scope.noProgramables);
		$scope.progress = false;
	}, function errorCallback(response) {
  	console.log(response);
  });
} 

// INICIALIZACION LIBRERIA DATATABLE
$scope.dtOptions = DTOptionsBuilder.newOptions();
$scope.dtColumnDefs = [
DTColumnDefBuilder.newColumnDef(0).notSortable(),
DTColumnDefBuilder.newColumnDef(9).notSortable()
];



$scope.getInfo();






}]);

