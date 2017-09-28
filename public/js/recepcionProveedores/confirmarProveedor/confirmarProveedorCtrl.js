app.controller('confirmProveedorCtrl', ['$scope', '$http', '$filter', 'DTOptionsBuilder','DTColumnDefBuilder', '$mdDialog',
	function($scope, $http, $filter, DTOptionsBuilder, DTColumnDefBuilder, $mdDialog){

// Definicion de variables
$scope.Url = "confirmarProveedorGetInfo";
$scope.urlResource = "confirmarProveedor";
$scope.urlRechazo = "rechazo";
$scope.titulocitas = "Seleccionar referencias"
$scope.progress = true;
$scope.tablaClase = "col-md-12";
$scope.accionGenerarCita = false;
$scope.minDate = new Date();
$scope.fechaEntrega = "";
$scope.seleccionadasCita = [];
$scope.tituloModal = "Informacion cita";
$scope.citaSeleccionada = {};
$scope.obsRechazo = false;
$scope.mensajes = [];
$scope.checkbox = {
										probFecha    : false,
										probHora     : false, 
										probCantidad : false
									};
$scope.observacionRechazo = {};


$scope.getInfo = function(){
	$http.get($scope.Url).then(function(response){
		data = response.data;
		$scope.datos = angular.copy(data.programaciones);
		$scope.noProgramables = $filter('filter')($scope.datos, {prg_tipo_programacion: 'NoProgramable'});
		$scope.citasTodas = angular.copy(data.citas);
		$scope.citas = $filter('filter')($scope.citasTodas, {cit_estado : "PENDCONFIRPROVEE"});
		$scope.confirmadas = $filter('filter')($scope.citasTodas, {cit_estado : "CONFIRMADA"});
		$scope.progress = false;
	}, function errorCallback(response) {
		console.log(response);
	});
} 


$scope.getInfo();




$scope.validarSiCambioFecha = function(fechanueva){		
	$scope.fechaEntrega = new Date($filter('date')(fechanueva.fechaEntrega, 'MM/dd/yyyy'));
	var recalculoDifDias = $scope.noProgramables.map(function(prog) {
		var fecha = new Date($filter('date')(prog.prg_fecha_programada, 'MM/dd/yyyy'));
		var cumple = Math.abs(moment($scope.fechaEntrega).diff(moment(fecha), 'days'));
		prog.difDias = cumple;
		return prog;
	})
	$scope.noProgramables = recalculoDifDias;
}


$scope.generarCita = function(ev){
	var progConCantidad = $filter('filter')($scope.noProgramables, {'confirCantidad' : ""});
	console.log(progConCantidad);
	if (progConCantidad.length > 0) {
		var confirm = $mdDialog.prompt()
		.title('Desea agregar alguna observacion a su solicitud de cita?')
		.textContent('')
		.placeholder('Ingresar observación')
		.ariaLabel('Observación')
		.initialValue('')
		.targetEvent(ev)
		.ok('Enviar!')
		.cancel('Cancelar');

		$mdDialog.show(confirm).then(function(result) {
			if (result == undefined) {
				result = "";
			}
			progConCantidad[0].observacionNueva = result;
		  progConCantidad[0].fechaEntrega = $scope.fechaEntrega;

	    $scope.progress = true;
			$http.put($scope.urlResource + '/1', progConCantidad).then(function(response){
				$scope.getInfo();
				$scope.fechaEntrega = "";
			}, function(response){
				alert(response.statusText + "  ["+ response.status + "]");
			});
		}, function() {

		});
	}else if(progConCantidad.length <= 0){
			$mdDialog.show(
	      $mdDialog.alert()
	        .parent(angular.element(document.querySelector('#popupContainer')))
	        .clickOutsideToClose(true)
	        .title('No se encontraron elementos para guardar')
	        .textContent('Favor ingresar la confirmacion de cantidad en algun registro para solicitar la cita')
	        .ariaLabel('Alert Dialog Demo')
	        .ok('Entendido!')
	    );

	}
	
}

$scope.validarVacios = function(dato){
	if (dato == "" || dato == undefined) {
		return false;
	}else{
		return true;
	}
}

$scope.seleccionarCita = function(cita, conBotones = true){
	$scope.limpiar();
	$scope.mostrarBotones = conBotones;
	$scope.citaSeleccionada = cita;
}

$scope.confirmarCita = function(){
	if ($scope.citaSeleccionada.id != "") {		
		$scope.progress = true;
		$http.post($scope.urlResource, $scope.citaSeleccionada).then(function(response){
			console.log(response.data);
			$scope.getInfo();
			$scope.citaSeleccionada = {};
			angular.element('.close').trigger('click');
		});
	}
}

$scope.generarRechazo = function(){
	$scope.mensajes = [];
	if (($scope.checkbox.probFecha == false && $scope.checkbox.probHora == false && $scope.checkbox.probCantidad == false )) {
		$scope.mensajes.push(['Favor seleccionar al menos un motivo de rechazo']);
	}
	if ($scope.observacionRechazo.obs == undefined) {
		$scope.mensajes.push(['Favor Ingresar una observacion']);
	}

	if ($scope.mensajes.length <= 0) {
		$scope.alertas = false;
		console.log($scope.citaSeleccionada);
		$http.post($scope.urlRechazo, $scope.citaSeleccionada).then(function(response){
			console.log(response.data);
			$scope.getInfo();
			$scope.citaSeleccionada = {};
			angular.element('.close').trigger('click');
		});
	}else{
		$scope.alertas = true;
	}
}

$scope.limpiar = function(){
	$scope.obsRechazo = false;
	$scope.observacionRechazo.obs = "";
	$scope.checkbox.probFecha    = false;
	$scope.checkbox.probHora     = false; 
	$scope.checkbox.probCantidad = false;
	$scope.alertas = false;
	$scope.mensajes = [];
}

$scope.cambiaEstado = function(){
	$scope.obsRechazo = true;
}

}]);

