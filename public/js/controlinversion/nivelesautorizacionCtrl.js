app.controller('nivelesautorizacionCtrl', ['$scope', '$http', '$filter', '$window',function ($scope, $http, $filter, $window) {
	$scope.getUrl = "nivelesAutorizacionGetInfo";
	$scope.url = "nivelesAutorizacion";
	$scope.objeto = {};
	$scope.arregloFiltrar = [];
	$scope.progress = true;
	$scope.canalesBool = false;
	$scope.lineasBool = false;

	$scope.tipoPersona = [
	{
		id : 1,
		tip_descripcion : 'Vendedor'
	},
	{
		id : 2,
		tip_descripcion : 'Mercadeo'
	},
	{
		id : 3,
		tip_descripcion : 'Colaborador'
	},
	];

	$scope.objeto.lineas = [];
	$scope.objeto.canales = [];
	$scope.validoSiGrabo = true;
	$scope.validoSiExisteNombre = false;



	$scope.getInfo = function(){
		$http.get($scope.getUrl).then(function(response){			
			var res = response.data;
			$scope.terceros = angular.copy(res.terceros);
			$scope.niveles = angular.copy(res.niveles);
			$scope.VendedorZona = angular.copy(res.VendedorZona);
			$scope.arregloFiltrar = angular.copy($scope.terceros);
			$scope.lineas = angular.copy(res.lineas);
			$scope.canales = angular.copy(res.canales);
			$scope.canalPernivel = angular.copy(res.canalPernivel);
			$scope.perniveles = angular.copy(res.perniveles);
			$scope.progress = false;
		},function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
	};

	$scope.getInfo();

	$scope.querySearch = function(string){
		var persona = $filter('filter')($scope.arregloFiltrar, {idTercero : string});	
		if(persona.length == 0){
			return $filter('filter')($scope.arregloFiltrar, {razonSocialTercero : string});
		}else{
			return persona;
		}
	}

	$scope.cambioConsultaArreglo = function(){
		if ($scope.objeto.tipo.id == 1) {
			$scope.arregloFiltrar = angular.copy($scope.VendedorZona);
			$scope.objeto.selectedItem = undefined;
		}else{
			$scope.arregloFiltrar = angular.copy($scope.terceros);
			$scope.objeto.selectedItem = undefined;
		}		
	}

	$scope.nivelesCambio = function(){
		if($scope.objeto.nivel.id != 1){
			$scope.arregloFiltrar = $scope.terceros;
			$scope.objeto.tipo = undefined;
			$scope.objeto.selectedItem = undefined;
		}
		if($scope.objeto.nivel.id != 3){
			$scope.objeto.canales = [];
			$scope.objeto.lineas = [];
		}
	}

	$scope.save = function(){
		if ($scope.objeto.canales.length > 0 && $scope.objeto.lineas.length > 0) {
			$scope.progress = true;
			$http.post($scope.url, $scope.objeto).then(function(response){
				$window.location.reload();						
			});
		}		
	}

	// Funciones del multiselect
	$scope.clearSearchTerm = function() {
		$scope.searchTerm = '';
	};

	$scope.agregarLinea = function(objeto){
		$scope.validoSiGrabo = true;
		$scope.objeto.canales.forEach(function(canal){
			var validemos = $filter('filter')($scope.canalPernivel, { cap_idlinea : objeto.lin_id, cap_idcanal : canal.can_id.trim()});
			if (validemos.length > 0) {
				$scope.validoSiGrabo = false;
			}
		});
		console.log($scope.validoSiGrabo);
		if ($scope.validoSiGrabo) {
			$scope.objeto.lineas.push(objeto);
			$scope.lineas = angular.copy($filter('removeWith')($scope.lineas, { lin_id : objeto.lin_id}));	
		}		
	}

	$scope.borrarEsteElemento = function(objeto){
		$scope.objeto.lineas = angular.copy($filter('removeWith')($scope.objeto.lineas, { lin_id : objeto.lin_id}));
	}

    //AgregarCanal
    $scope.AgregarCanal = function(objeto){
    	$scope.objeto.canales.push(objeto);
    	$scope.canales = angular.copy($filter('removeWith')($scope.canales, { can_id : objeto.can_id}));
    }

    //BorrarElemento
    $scope.borrarElemento = function(objeto){
    	$scope.objeto.canales = angular.copy($filter('removeWith')($scope.objeto.canales, { can_id : objeto.can_id}));
    }

    $scope.cambioPersonaInAutocomplete = function(objeto){
    	console.log($scope.perniveles);
    	if(objeto != undefined && objeto != null){
    		console.log(objeto);
    		var buscoSiExiste = $filter('filter')($scope.perniveles, { pern_cedula : objeto.idTercero});
    		console.log(buscoSiExiste);
    		if (buscoSiExiste.length > 0) {
    			$scope.objeto.selectedItem = undefined;
    			$scope.validoSiExisteNombre = true;
    		}else{
    			$scope.validoSiExisteNombre = false;
    		}
    	}
    	
    }

}])