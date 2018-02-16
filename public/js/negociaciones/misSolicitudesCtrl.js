app.controller('misSolicitudesCtrl', ['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder, $mdDialog){

	$scope.getUrl = "misSolicitudesInfo";
	$scope.Url = "misSolicitudes";
	$scope.periEjeUrl = "misSolicitudesPeriEje";
	$scope.confirBono = "misSolicitudesConfirBono";
    $scope.progress = true;
    $scope.recarguemos = "";
    $scope.mensajeExito = false;
	
	$scope.getInfo = function(){
		$scope.todas = [];
		$scope.aprobacion = [];
		$http.get($scope.getUrl).then(function(response){			
			data = response.data;
			$scope.todas = angular.copy(data.solicitudes);
			$scope.usuariolog = angular.copy(data.usuario);
			$scope.urlImprimirActa = angular.copy(data.urlImprimirActa);

			$scope.elaboracion =  $filter('filter')($scope.todas, {sol_ser_id : 0, sol_sef_id : 1});
			$scope.correciones =  $filter('filter')($scope.todas, {sol_ser_id : 8, sol_sef_id : 1});
			$scope.anuladas =  $filter('filter')($scope.todas, {sol_ser_id : 9, sol_sef_id : 4});
			$scope.solicitudes =  $filter('filter')($scope.todas, {sol_ser_id : 1, sol_sef_id : 1});
			$scope.filtros =  $filter('filter')($scope.todas, {sol_ser_id : 2, sol_sef_id : 1});

			$scope.filtrosAprobacion = [3, 4, 5, 6, 7];
			$scope.aprobacion = [];
			$scope.filtrosAprobacion.forEach(function(element){
				var arregloAprobacion = $filter('filter')($scope.todas, {sol_ser_id : element, sol_sef_id : 1});
				arregloAprobacion.forEach(function(obj){
					$scope.aprobacion.push(obj);
				});				
			});

			$scope.filtrosEvaluacion = [2, 3, 5];
			$scope.evaluacion = [];
			$scope.filtrosEvaluacion.forEach(function(element){
				var arregloEvaluacion = $filter('filter')($scope.todas, {sol_sef_id : element});
				arregloEvaluacion.forEach(function(obj){
					$scope.evaluacion.push(obj);
				});				
			});

			$scope.cerradas =  $filter('filter')($scope.todas, {sol_sef_id : 6});
			$scope.tesoPendientes =  $filter('filter')($scope.todas, {sol_set_id : 3});
			$scope.tesoConfirmadas =  $filter('filter')($scope.todas, {sol_set_id : 4});

			if ($scope.recarguemos != "") {
				var solicitudSeleccionar = $filter('filter')($scope.todas, {sol_id : $scope.recarguemos})[0];
				$scope.setSolicitud(solicitudSeleccionar);
				setTimeout(function() {
					console.log('.' + $scope.recarguemos);
					angular.element('.' + $scope.recarguemos).trigger('click');
					$scope.recarguemos = "";
					$scope.mensajeExito = true;
				}, 10);
				setTimeout(function() {					
					$scope.mensajeExito = false;
				}, 3000);
			}
			$scope.progress = false;
		}), function(errorResponse){
				console.log(errorResponse);
				$scope.getInfo();
			};
	};
	$scope.getInfo();

	$scope.retornarCadena = function(arregloDeObjetos){
    	if (arregloDeObjetos != undefined) {
    		var arreglo = arregloDeObjetos.map(function(objeto){
	      		return objeto.lineas_detalle.lin_txt_descrip;
	    	});
	    	return arreglo.join(', ');
    	}else{
    		return "";
    	}
  	}

  	$scope.setSolicitud = function(objeto){
  		$scope.infoSolicitud = objeto;
  		$scope.reset = true;
  		$scope.date = new Date();

  		if (($scope.infoSolicitud.sol_sef_id == 2) || ($scope.infoSolicitud.sol_sef_id == 3)) {
  			$scope.pendienteGestion = 'Evaluación';
  		}else{
  			$scope.pendienteGestion = 'Ninguno';	
  		}
  		
  		$scope.infoSolicitud.sol_peri_ejeini = new Date($filter('date')($scope.infoSolicitud.sol_peri_ejeini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
  		$scope.infoSolicitud.sol_peri_ejefin = new Date($filter('date')($scope.infoSolicitud.sol_peri_ejefin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));

  		$scope.ultimoProceso = $scope.infoSolicitud.his_proceso.slice(-1);
  		$scope.variacionObj = ($scope.infoSolicitud.objetivo.soo_vemesdespues/$scope.infoSolicitud.objetivo.soo_veprome);

  		$scope.ventaRealMarginal = ($scope.infoSolicitud.cumplimiento.scu_venreallineas - 
  			($scope.infoSolicitud.objetivo.soo_venpromeslin * $scope.infoSolicitud.sol_mesesfactu));
  		$scope.ventaReal = ($scope.infoSolicitud.cumplimiento.scu_venreallineas - 
  			($scope.infoSolicitud.objetivo.soo_venpromeslin * $scope.infoSolicitud.sol_meseseje));

  		console.log($scope.infoSolicitud);
  	}
  	
  	$scope.diffmesesFechaEjecucion = function(){
		if ($scope.infoSolicitud.sol_peri_ejefin != undefined && $scope.infoSolicitud.sol_peri_ejeini != undefined && $scope.infoSolicitud.sol_peri_ejefin > $scope.infoSolicitud.sol_peri_ejeini) {
			var fecha1 = moment($scope.infoSolicitud.sol_peri_ejefin);
			var fecha2 = moment($scope.infoSolicitud.sol_peri_ejeini);
			$scope.infoSolicitud.sol_meseseje = fecha1.diff(fecha2, 'months', true).toFixed(1);
		}else if($scope.infoSolicitud.sol_peri_ejefin < $scope.infoSolicitud.sol_peri_ejeini){
			$mdDialog.show(
		      $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('ALERTA!')
		        .textContent('La fecha inicial del periodo de ejecución no puede ser mayor a la fecha final')
		        .ariaLabel('')
		        .ok('Cerrar')
		    );
		    $scope.infoSolicitud.sol_meseseje = undefined;
		    $scope.infoSolicitud.sol_peri_ejefin = undefined;
		}
	}

	$scope.anular = function(){
		$http.put($scope.Url + '/' + $scope.infoSolicitud.sol_id, $scope.infoSolicitud).then(function(response){
	   		console.log(response);
	   		$scope.infoSolicitud = {};
	   		$scope.getInfo();
	   	});
	   	$mdDialog.show(
		    $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('Anulación Exitosa!')
		        .textContent('Se anula de manera satisfactoria la solicitud #'+ $scope.infoSolicitud.sol_id)
		        .ariaLabel('')
		        .ok('Cerrar')
		);
	   	angular.element('.close').trigger('click');
	}

	$scope.cambiarPeriEje = function(){
		$http.post($scope.periEjeUrl, $scope.infoSolicitud).then(function(response){
	   		console.log(response);
	   		$scope.infoSolicitud = {};
	   		$scope.getInfo();
	   	});
	   	$mdDialog.show(
		    $mdDialog.alert()
		        .parent(angular.element(document.querySelector('#popupContainer')))
		        .clickOutsideToClose(true)
		        .title('Cambio de Fecha Exitoso!')
		        .textContent('Se cambia la fecha del periodo de ejecucion de manera satisfactoria en la solicitud #'+ $scope.infoSolicitud.sol_id)
		        .ariaLabel('')
		        .ok('Cerrar')
		);
	   	angular.element('.close').trigger('click');
	}

	$scope.confirmarBono = function(){
  		$scope.infoSolicitud.usuarioLog = $scope.usuariolog;
		$http.post($scope.confirBono, $scope.infoSolicitud).then(function(response){
			$scope.progress = true;
	   		console.log(response);
	   		$scope.infoSolicitud = {};
	   		$scope.getInfo();
	   	});
	   	angular.element('.close').trigger('click');
	}

	$scope.redireccionarEdit = function(url){
		$window.location = url;
	}


	$scope.duplicarSolicitud = function(objetoDuplicar){
		$scope.duplicarSoli = objetoDuplicar;
  		$scope.duplicarSoli.sol_fecha = new Date();

  		$scope.duplicarSoli.sol_peri_ejeini = new Date($filter('date')($scope.duplicarSoli.sol_peri_ejeini, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));
  		$scope.duplicarSoli.sol_peri_ejefin = new Date($filter('date')($scope.duplicarSoli.sol_peri_ejefin, 'yyyy-MM-dd HH:mm:ss Z', '+0500'));

		var confirm = $mdDialog.confirm()
    	.title('¡ALERTA!')
    	.textContent('¿Realmente desea duplicar la solicitud?')
    	.ariaLabel('Lucky day')
    	.targetEvent()
     	.ok('Si')
    	.cancel('No, gracias');
    	$mdDialog.show(confirm).then(function() {
        	$scope.progress = true;
    		$http.post($scope.Url, $scope.duplicarSoli).then(function(response){
        		console.log(response);
        		$scope.getInfo();
        	}, function(error){
        		console.log(error);
        		$scope.getInfo();
        		});
    	});
    	$scope.getInfo();
	}

	$scope.generarPdf = function(){
  		$window.location = $scope.urlImprimirActa;
  	}

  	$scope.resetTab = function(){
		$scope.reset = false;
	}

	$scope.newVentana = function(urlVentana){
		var url = urlVentana.urlImagen;
		return $window.open(url, '_blank');
	}

}]);