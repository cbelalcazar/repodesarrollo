app.controller('formValidacionCiegoCtrl', ['$scope', '$http', '$filter', '$mdDialog', '$window', '$timeout' ,function ($scope, $http, $filter, $mdDialog, $window, $timeout) {
	$scope.entm_int_id = "";
	$scope.entrada = {};
	$scope.tiposMercancia = ['INSUMOS', 'Material de Empaque', 'P.O.P', 'PROMOCIONAL'];
	$scope.urlGetInfo = '../../formValidacionCiegoGetInfo';
	$scope.urlGuardarEntrada = '../../guardarEntrada';
	$scope.progress = true;
	$scope.novedad = ['Normal', 'Sobrante', 'Error de auxiliar', 'Faltante'];
	$scope.novedades = [];
	$scope.mensajes = false;


	// El get info se manda a ejecutar cuando se activa el evento ng-init que inicializa la variable con el id del documento ciego
	$scope.getInfo = function(){
		$http.post($scope.urlGetInfo, $scope.entm_int_id).then(function(response){
			res = response.data;
			$scope.entrada = angular.copy(res.entrada);
			$scope.progress = false;
			if ($scope.entrada.entm_txt_factura == 0) {
				$scope.entrada.entm_txt_factura = "";
			}
		});
	}

	$scope.totalReferencia = function(lista){
		var soloCantidades = $filter('map')(lista, 'rec_int_cantidad');
		var cantSinUndefined = $filter('remove')(soloCantidades, undefined);
		var sumatoriaTotal = $filter('sum')(cantSinUndefined);
		return sumatoriaTotal;
	}


	$scope.save = function(){
		console.log($scope.entrada);
		$http.post($scope.urlGuardarEntrada, $scope.entrada).then(function(response){
			res = response.data;
		});
	}

	$scope.calcular = function(objeto){
		// Calculo el numero de cajas redondeando hacia abajo para posteriormente obtener el saldo: cantidad de unidades / unidad de empaque
		objeto.rec_int_cajas =  Math.floor((objeto.rec_int_cantidad / objeto.rec_int_undempaque));
		// Obtengo el saldo sacando el valor absoluto de: (numero de cajas * unidad de empaque) - cantidad de unidades
		objeto.rec_int_saldo = Math.abs((objeto.rec_int_cajas * objeto.rec_int_undempaque) - objeto.rec_int_cantidad);
		// Si se borra alguno de los dos campos de informacion base los otros se limpian asegurando que el usuario llene la informacion
		if (objeto.rec_int_cajas == Infinity || objeto.rec_int_cantidad == "") {
			objeto.rec_int_cajas = "";
			objeto.rec_int_saldo = "";
		}
	}

	$scope.subir = function(){
		$window.scrollTo(0, 0);
		$scope.mensajes = true;
		$timeout(function() {
			$scope.mensajes = false;
        }, 7000);
	}

	$scope.menorACero = function(numero){
		if(numero == undefined){
			return true;
		}
		return false;
	}

	
}])