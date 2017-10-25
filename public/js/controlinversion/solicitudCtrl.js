app.controller('solicitudCtrl', ['$scope', '$filter', '$http', '$window', function($scope, $filter, $http, $window){

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


$scope.zonas = [
			{
				'id'			: 1,
				'descripcion' 	: 'ZONA 1'
			},
			{
				'id'			: 2,
				'descripcion' 	: 'ZONA 2'
			},
			{
				'id'			: 3,
				'descripcion' 	: 'ZONA 3'
			},
			{
				'id'			: 4,
				'descripcion' 	: 'ZONA 4'
			},
];

	$scope.progress = true;
	$scope.url = '../solicitudGetInfo';
	$scope.refUrl = '../consultarReferencia';

	// Campo Facturar A
		$scope.hab_ac_facturara = false;
		$scope.buscar_ac_facturara = '';


	$scope.listadespachar = [];

	$scope.colaboradoresGeneral = [];
	$scope.colaboradoresAutocomplete = [];
  $scope.selectedColaboradores = [];

  $scope.autocompleteDemoRequireMatch = true;
	$scope.esVendedor = false;
	$scope.colaboradorText;

	$scope.filtrado = [];

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
			$scope.vendedoresBesa = angular.copy(res.vendedoresBesa);
			$scope.items = angular.copy(res.item);
			$scope.progress = false;
		});
	}

$scope.onCantidadChange = function(referencia){

	console.log($scope.selectedColaboradores);

	referencia.referenciaValorTotal = referencia.referenciaCantidad * referencia.referenciaPrecio;


}

$scope.qs_facturara = function(string){
			var persona1 = $filter('filter')($scope.personas, {fca_idTercero : string});
			if(persona1.length == 0){
				return $filter('filter')($scope.personas, {tercero : {razonSocialTercero : string}});
			}else{
				return persona1;
			}
}

$scope.agregarReferenciaTodos = function(){

	$http.get($scope.refUrl+"/"+$scope.objeto.referenciaGeneral.referenciaCodigo).then(function(response){

			$scope.selectedColaboradores.map(function(colaborador){
				if(colaborador.referencias == undefined){
					colaborador.referencias = [];
				}

				$scope.objeto.referenciaGeneral.referenciaPrecio = response.data.infoRefe.length > 0 ? response.data.infoRefe[0].precio : 1;
				$scope.objeto.referenciaGeneral.referenciaCantidad = 0;
				$scope.objeto.referenciaGeneral.referenciaValorTotal = 0;
				colaborador.referencias.push(angular.copy($scope.objeto.referenciaGeneral));

				return colaborador;
			})

			console.log($scope.selectedColaboradores);

			$scope.objeto.referenciaGeneral = "";

	});
}

$scope.agregarReferenciaVendedor = function(colaborador,ev){

	console.log(ev.offsetX);
	console.log(ev.offsetY);

	$http.get($scope.refUrl+"/"+colaborador.referenciaSearchItem.referenciaCodigo).then(function(response){

				if(colaborador.referencias == undefined){
					colaborador.referencias = [];
				}

				colaborador.referenciaSearchItem.referenciaPrecio = response.data.infoRefe.length > 0 ? response.data.infoRefe[0].precio : 1;
				colaborador.referenciaSearchItem.referenciaCantidad = 0;
				colaborador.referenciaSearchItem.referenciaValorTotal = 0;
				colaborador.referencias.push(colaborador.referenciaSearchItem);

				console.log(colaborador.referencias);

				colaborador.referenciaSearchItem="";

	});

	// $scope.scrollToElement(ev.offsetX, ev.offsetY);

}


/*
*Filtra el arreglo de selección de colaboradores por zonas dado el caso que sean vendedores
*/
$scope.filtrarVendedorZona = function(item){
	if($scope.esVendedor == true){
		var filtradoZona = $filter('filter')($scope.solicitud.zonasSelected,{descripcion: item.NomZona});
		if(filtradoZona.length > 0){
			return item;
		}
	}else	if($scope.esVendedor == false){
		return item;
	}
}

/*
*Filtra el arreglo de selección de colaboradores dependiendo del tipo de persona que es
*sí es una vendedor el arreglo de selección será filtrado desde $scope.vendedoresBesa y sí no
*será filtrado desde $scope.colaboradores
*/
$scope.filtrapersona = function(){

			$scope.colaboradoresGeneral = [];

			if($scope.solicitud.tipopersona1.tpe_tipopersona != 'Vendedor'){

					$scope.esVendedor = false;
					$scope.colaboradoresGeneral = $scope.colaboradores;

			}else if($scope.solicitud.tipopersona1.tpe_tipopersona == 'Vendedor'){

					$scope.esVendedor = true;
					$scope.colaboradoresGeneral = $scope.vendedoresBesa;

			}

}


/*
*Obtiene la lista de colaboradores previamente filtrada desde el metodo $scope.filtrapersona
*El cual detecta cada que hay un cambio en el modelo del autocomplete de colaboradores y
*Determina si lo que esta buscando es un vendedor o un tercero normal.
*/
$scope.onSearchQueryChange = function(colaboradorText){

			$scope.colaboradoresAutocomplete = [];

			$scope.colaboradoresAutocomplete =  $filter('filter')($scope.colaboradoresGeneral, {nombreVendedor : colaboradorText});

			if($scope.colaboradoresAutocomplete.length == 0){
				$scope.colaboradoresAutocomplete =  $filter('filter')($scope.colaboradoresGeneral, {nitVendedor : colaboradorText});
			}

			return $scope.colaboradoresAutocomplete

}


$scope.addpersonadespachar = function(string){

					console.log(string);
					console.log($scope.selectedColaboradores)

}


$scope.qs_referencia = function(string){
							var ref1 = $filter('filter')($scope.items, {referenciaDescripcion : string});
							if(ref1.length == 0){
								return $filter('filter')($scope.items, {referenciaCodigo : string});
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

    $scope.scrollToElement = function(x,y){
    	$window.scrollTo(x,y);
    }


}]);
