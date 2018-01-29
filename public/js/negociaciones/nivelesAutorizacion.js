app.controller('nivelesAutorizacion', 
['$scope', '$http', '$filter', '$timeout', '$location', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', '$window',  
function($scope, $http, $filter,$timeout, $location, DTOptionsBuilder, DTColumnDefBuilder, $mdDialog, $window){

	$scope.urlInfo = 'infoAutorizacion';
	$scope.url = 'nivelesAutorizacion';
	$scope.progress = true;
	$scope.infoPerNivel = {};
	$scope.tercerosFiltrados = [];
	$scope.nivelUno = [];
	$scope.nivelDos = [];
	$scope.nivelTres = [];

	$scope.getInfo = function(){
		$http.get($scope.urlInfo).then(function(response){
			$scope.progress = false;
			var info = angular.copy(response.data);
			$scope.canales = angular.copy(info.canales);
			$scope.terceros = angular.copy(info.terceros);
			$scope.todosTerceros = angular.copy($scope.terceros);
			$scope.tipospersona = angular.copy(info.tipospersona);
			$scope.tipospersonaN1 = angular.copy($scope.tipospersona);
			$scope.tipospersonaN2 = angular.copy(info.tipospersonaN2);
			$scope.territorios = angular.copy(info.territorios);
			$scope.niveles = angular.copy(info.niveles);
			$scope.perniveles = angular.copy(info.nivelesCreados);
			$scope.lineas = angular.copy(info.lineas);
			$scope.organiza();
			$scope.nivelUno = angular.copy($filter('filter')($scope.perniveles, {pen_nomnivel : 1}, true));
			$scope.nivelDos = angular.copy($filter('filter')($scope.perniveles, {pen_nomnivel : 2}, true));
			
		}, function(error){
			$scope.getInfo();
		});	
	}

	$scope.getInfo();

	$scope.eliminar = function(arreglo, elemento){
		var posicion = arreglo.indexOf(elemento);
		arreglo.splice(posicion, 1);
	}

	$scope.filtrarTercerosCan = function(tipoPersona, canal, nivel){
		if (nivel.id == 1) {
			return $scope.terceros;
		}else if(nivel.id == 2){
			$idNivelAnterior = $filter('filter')($scope.niveles, {niv_padre : nivel.id}, true)[0]['id'];
			var pernivelesAnteriores = $filter('filter')($scope.perniveles, {pen_idtipoper : tipoPersona.id, pen_nomnivel : $idNivelAnterior}, true);
			var pernivelesPermitidos = [];
			pernivelesAnteriores.forEach(function(pernivel){
				canales = $filter('filter')(pernivel['canales'], {pcan_idcanal : canal.can_id.trim()}, true);
				if (canales.length > 0) {
					pernivelesPermitidos.push(pernivel);
				}				
			});

			var terceros = [];
			pernivelesPermitidos.forEach(function(obj){
				terceros.push($filter('filter')($scope.todosTerceros, {idTercero : obj.pen_cedula}, true)[0]);
    		});
    		console.log($scope.terceros);
    		console.log(terceros);
    		$scope.terceros = terceros;
    		return $scope.terceros;
		}
	}

	$scope.filtrarLineasCanal = function(canal){
		return $scope.lineas;
	}

    $scope.eliminarPersonaDepende = function(persona){
        if(persona){    
            for(var x in $scope.infoPerNivel.personasautoriza){
                var ref = $scope.infoPerNivel.personasautoriza[x];
                if(ref['idRowTercero'] == persona.idRowTercero){
                    $scope.infoPerNivel.personasautoriza.splice(x, 1);
                }
            }
        }
    }

    $scope.organiza = function(){
    	$scope.perniveles = $scope.perniveles.map(function(obj){
    		if (obj.canales.length > 0) {
    			var canalCadena = [];
	    		obj.canales.forEach(function(obj){
	    			var texto = obj['pcan_descripcanal'];
	    			canalCadena.push(texto);
	    		});
	    		obj.stringCanal = canalCadena.join();	
    		}else{
    			obj.stringCanal = null;	
    		}
    		return obj;
    	});

    }

    $scope.cambiarNivel = function(nivel){
    	$scope.nivel = $filter('filter')($scope.niveles, {id: nivel}, true);
    	$scope.infoPerNivel = {};
    	if (nivel == 2) {
    		$scope.tipospersona = $scope.tipospersonaN2;
    	}else{
    		$scope.tipospersona = $scope.tipospersonaN1;
    	}
    	$scope.filtraPer();
    }

    $scope.filtraPer = function(){
    	$scope.perniveles.forEach(function(obj){
			$scope.terceros = $filter('removeWith')($scope.terceros, {idTercero : obj.pen_cedula});
    	});
    }

    $scope.guardarPerNivel = function(){
    	$scope.infoPerNivel.nivel = $scope.nivel;
    	$scope.progress = true;
    	$http.post($scope.url,$scope.infoPerNivel).then(function(response){
    		// setTimeout(function() {
    		// 	angular.element('.close').trigger('click');
    		// }, 1000);
    		$scope.getInfo();
    	}, function(errorResponse){

    	});
    }

    $scope.update = function(obj){   
    	$scope.infoPerNivel = {};
    	$scope.cambiarNivel(obj.pen_nomnivel);
    	$scope.infoPerNivel = angular.copy(obj);
    	$scope.infoPerNivel.tipopersona = obj.t_tipopersona;
    		

    	if ($scope.infoPerNivel.tipopersona.id == 1) {
			var array = [];
	    	obj.canales.forEach(function(obj){
	    		var object = $filter('filter')($scope.canales, {can_id : obj.pcan_idcanal}, true)[0];
	    		array.push(object);
	    	});
	    	$scope.infoPerNivel.percanales = $scope.infoPerNivel.canales;
    		$scope.infoPerNivel.canales = array;   	
    	}else if($scope.infoPerNivel.tipopersona.id == 2){
    		var groupPorTerritorio = $filter('groupBy')(obj.canales, 'pcan_idterritorio');
    		groupPorTerritorio = $filter('toArray')(groupPorTerritorio);
    		arregloTerritorios = [];   
    		groupPorTerritorio.forEach(function(arrayTer){

	    		var territorio = $filter('filter')($scope.territorios, {id : arrayTer[0].pcan_idterritorio})[0];
	    		var arregloCanales = [];
	    		arrayTer.forEach(function(canales){
	    			var canal = $filter('filter')($scope.canales, {can_id : canales.pcan_idcanal}, true)[0];
	    			arregloCanales.push(canal);
	    		});
	    		territorio.canales = arregloCanales;
	    		arregloTerritorios.push(territorio);
	    	}); 
	    	$scope.infoPerNivel.territorio = arregloTerritorios;	
    	}	

    	

    	var tercero = $filter('filter')($scope.todosTerceros, {idTercero : obj.pen_cedula})[0];
    	$scope.infoPerNivel.terceros = [];
    	$scope.infoPerNivel.terceros.push(tercero);
    }

    $scope.delete = function(object){
	    var confirm = $mdDialog.confirm()
	          .title('')
	          .textContent('Esta seguro que desea eliminar este elemento')
	          .ok('Borrar')
	          .cancel('Cancelar');

	    $mdDialog.show(confirm).then(function() {
	    	$scope.progress = true;
	    	$http.delete($scope.url + '/' + object.id, object).then(function(response){
	    		$scope.getInfo();
	    	}, function(errorResponse){
	    		$window.location.reload();
	    	});	    	
	    }, function() {
	    	$scope.progress = false;
	    });
    }

    // $scope.filtrarAutorizaA = function(){
	  	// if ($scope.nivel[0].id > 1 && $scope.infoPerNivel.terceros[0] != undefined && $scope.infoPerNivel.tipopersona != undefined) {
	   //    if ($scope.infoPerNivel.tipopersona.id === 1 || $scope.infoPerNivel.tipopersona.id === 2) {
	   //      if ($scope.infoPerNivel.canales != undefined) {
	   //        	var array = [];
	   //        	$scope.arregloNivel = [];
	   //        	$scope.perniveles.forEach(function(object){
		  //           $scope.bandera = false;
		  //           object.canales.forEach(function(obj){
		  //             	var filt = $filter('filter')($scope.infoPerNivel.canales, {can_id : obj.pcan_idcanal});
		  //             	if (filt.length > 0) {
		  //               	$scope.bandera = true;
		  //             	}
		  //           });
		  //           if ($scope.bandera) {
		  //             $scope.arregloNivel.push(object);
		  //           }
		  //       });

    // 		  var hijo = $filter('filter')($scope.niveles, {niv_padre: $scope.nivel[0].id})[0];
	   //        if ($scope.infoPerNivel.tipopersona.id === 1 || $scope.infoPerNivel.tipopersona.id === 2) {
	   //          $scope.arregloNivel = $filter('filter')($scope.arregloNivel, {pen_nomnivel : hijo.id}, true);
	   //        }

	   //        if ($scope.infoPerNivel.tipopersona.id === 2) {
	   //        	if ($scope.infoPerNivel.territorio != undefined) {
	   //        		$scope.arregloNivel = $filter('filter')($scope.arregloNivel, {pen_idterritorios : $scope.infoPerNivel.territorio[0].id});
	   //        	}	            
	   //        }
	   //      }
	   //    }
	   //  }
    // }

    $scope.calcularCantidadPersonas = function(canales){
    	cantidad = 0;
    	if (canales == undefined && $scope.infoPerNivel.id == undefined) {
    		return '(Personas: ' + 0 + ')';
    	}else if(canales != undefined && $scope.infoPerNivel.id != undefined){
			return '';
    	}else{    		
    		canales.forEach(function(object){
    			if (object.personas != undefined) {
    				cantidad += object.personas.length;
    			}
    		});
    		return '(Personas: ' + cantidad + ')';
    	}
    }



}]);