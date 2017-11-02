app.controller('nivelesautorizacionCtrl', ['$scope', '$http', '$filter',function ($scope, $http, $filter) {
	$scope.getUrl = "nivelesAutorizacionGetInfo";
	$scope.url = "nivelesAutorizacion";
	$scope.objeto = {};
	$scope.arregloFiltrar = [];
	$scope.progress = true;
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


	$scope.getInfo = function(){
		$http.get($scope.getUrl).then(function(response){			
			var res = response.data;
			$scope.terceros = angular.copy(res.terceros);
			$scope.niveles = angular.copy(res.niveles);
			$scope.VendedorZona = angular.copy(res.VendedorZona);
			$scope.arregloFiltrar = angular.copy($scope.terceros);
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
	}

	$scope.save = function(){
		$scope.progress = true;
		$http.post($scope.url, $scope.objeto).then(function(response){
			var res = response.data;
			$scope.progress = false;
		});
	}

}])