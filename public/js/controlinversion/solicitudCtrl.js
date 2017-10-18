app.controller('solicitudCtrl', ['$scope', '$filter', '$http', function($scope, $filter, $http){
	
	// Variable fecha para el formulario de creacion	
	var fechahoy = new Date();
	$scope.solicitud = {
			  				fecha:$filter('date')(fechahoy, 'yyyy-MM-dd HH:mm:ss'),
						};
	$scope.motivoSalida = [
							{
								'id'			: 7,
								'descripcion' 	: 'Salida de Obsequios y Muestras Mercadeo'
							},
			  				{
			  					'id'			: 8,
			  					'descripcion' 	: 'Salida Eventos de Mercadeo'
			  				},
			  				{
			  					'id'			: 10,
			  					'descripcion' 	: 'Salida Probadores Mercadeo'
			  				},
						  ];
			  					
	$scope.progress = true;
	$scope.url = '../solicitudGetInfo';
	
	// Campo Facturar A
		$scope.hab_ac_facturara = false;
		$scope.buscar_ac_facturara = '';


	$scope.listadespachar = [];
  $objeto = {};
  $scope.selectedColaboradores = [];
  $scope.autocompleteDemoRequireMatch = true;

	$scope.getInfo = function(){
		$http.get($scope.url).then(function(response){
			var res = response.data;
			console.log(res);
			$scope.personas = angular.copy(res.personas);
			$scope.tiposalida = angular.copy(res.tiposalida);
			$scope.tipopersona = angular.copy(res.tipopersona);
			$scope.cargagasto = angular.copy(res.cargagasto);
			$scope.lineasproducto = angular.copy(res.lineasproducto);
			$scope.colaboradores = angular.copy(res.colaboradores);
			$scope.items = angular.copy(res.item);
			$scope.progress = false;
		});
	}


$scope.qs_facturara = function(string){
							var persona1 = $filter('filter')($scope.personas, {fca_idTercero : string}); 
							if(persona1.length == 0){
								return $filter('filter')($scope.personas, {tercero : {razonSocialTercero : string}}); 
							}else{
								return persona1;
							}
				}

$scope.querySearchPersona = function(string){
					return $filter('filter')($scope.colaboradores, {razonSocialTercero : string}); 			
	}

$scope.filtrapersona = function(){
						if($scope.solicitud.tipopersona1.tpe_tipopersona == 'Colaborador'){
							$scope.listadespachar = $scope.colaboradores;
						}
				}

$scope.addpersonadespachar = function(string){
					console.log(string);
					console.log($scope.selectedColaboradores)

				}


$scope.qs_referencia = function(string){
							var ref1 = $filter('filter')($scope.items, {ite_descripcion : string}); 
							if(ref1.length == 0){
								return $filter('filter')($scope.items, {ite_referencia : string}); 
							}else{
								return ref1;
							}					
	}


	$scope.getInfo();


	/**
     * Return the proper object when the append is called.
     */
    function transformChip(chip) {
      // If it is an object, it's already a known chip
      if (angular.isObject(chip)) {
        return chip;
      }

      // Otherwise, create a new one
      return { name: chip, type: 'new' }
    }

    $scope.scrollto = function($event){
    	console.log($event);
    }


}]);