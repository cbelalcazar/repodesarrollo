app.controller('misSolitudesCtrl', ['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder){

	$scope.getInfoMisolicitudes = "getInfoMisolicitudes";
	$scope.progress = true;
	$scope.count = [];
	$scope.elaboracion = "0";
	$scope.solicitud =  {};

	$scope.getInfo = function(){
		$scope.todas = [];


		$http.get($scope.getInfoMisolicitudes).then(function(response){
			data = response.data;
			$scope.todas = angular.copy(data.solicitudes);
			console.log($scope.todas);
			$scope.todas.forEach(function(solicitud) {
					var fecha_ini = new Date(solicitud.sci_fecha);
					fecha_ini = fecha_ini.getTime() + fecha_ini.getTimezoneOffset()*60*1000;
					solicitud.sci_fecha = new Date(fecha_ini);
			}, this);

			$scope.elaboracion =  $filter('filter')($scope.todas, {sci_soe_id : 0});
			$scope.solicitud =  $filter('filter')($scope.todas, {sci_soe_id : 1});
			$scope.correcciones =  $filter('filter')($scope.todas, {sci_soe_id : 2});
			$scope.anulada =  $filter('filter')($scope.todas, {sci_soe_id : 3});
			$scope.aprobacion =  $filter('filter')($scope.todas, {sci_soe_id : 4});
			$scope.aprobada =  $filter('filter')($scope.todas, {sci_soe_id : 5});
			$scope.cerrada =  $filter('filter')($scope.todas, {sci_soe_id : 6});
			$scope.aprobacionAuditoria =  $filter('filter')($scope.todas, {sci_soe_id : 7});
			$scope.progress = false;
		}, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});

		$scope.dtOptions = DTOptionsBuilder.newOptions()
										.withOption('aaSorting', [[0, 'desc']]);


		$scope.dtColumnDefs0 = [
		DTColumnDefBuilder.newColumnDef(0).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(1).withClass('text-center').withOption('width', '100px'),
		DTColumnDefBuilder.newColumnDef(2).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(3).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(4).withClass('text-center').withOption('width', '90px'),
		DTColumnDefBuilder.newColumnDef(5).withClass('text-center').withOption('width', '110px'),
		DTColumnDefBuilder.newColumnDef(6).withClass('text-center').withOption('width','60px'),
		DTColumnDefBuilder.newColumnDef(7).withClass('text-left'),
		DTColumnDefBuilder.newColumnDef(8).notSortable().withClass('text-center').withOption('width', '69px')];



		$scope.dtColumnDefs1 = [
		DTColumnDefBuilder.newColumnDef(0).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(1).withClass('text-center').withOption('width', '100px'),
		DTColumnDefBuilder.newColumnDef(2).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(3).withClass('text-center'),
		DTColumnDefBuilder.newColumnDef(4).withClass('text-center').withOption('width', '90px'),
		DTColumnDefBuilder.newColumnDef(5).withClass('text-center').withOption('width', '110px'),
		DTColumnDefBuilder.newColumnDef(6).withClass('text-center').withOption('width','60px'),
		DTColumnDefBuilder.newColumnDef(7).withClass('text-left'),
		DTColumnDefBuilder.newColumnDef(8).notSortable().withClass('text-center').withOption('width', '69px'),
		DTColumnDefBuilder.newColumnDef(9).notSortable().withClass('text-center').withOption('width', '69px'),
		DTColumnDefBuilder.newColumnDef(10).notSortable().withClass('text-center').withOption('width', '69px')];


	};

	$scope.getInfo();

	$scope.setSolicitud = function(solicitud){
		console.log(solicitud);
		$scope.solicitud = solicitud;
	}

	$scope.terminarSolicitud = function(solicitud){
		window.location = solicitud.rutaEdit;
	}



}]);
