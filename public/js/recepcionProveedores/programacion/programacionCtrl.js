app.controller('programacionCtrl', ['$scope', '$http', '$filter', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', function($scope, $http, $filter, DTOptionsBuilder, DTColumnDefBuilder,  $mdDialog){
  $scope.getUrl = "programacionGetInfo";
  $scope.urlOC = "referenciasPorOc";

  $scope.progress = true;

  // Funcion que filtra el array de proveedores por la palabra ingresada en el autocomplete y retorna el array filtrado
  $scope.query = function(searchTextProveedor) {    
    if(searchTextProveedor != ""){
      var filtroDoble = $filter('filter')($scope.autocompProveedor, {nitTercero: searchTextProveedor}); 
      if(filtroDoble.length == 0){
        return $filter('filter')($scope.autocompProveedor, {razonSocialTercero : searchTextProveedor});
      }else{
        return filtroDoble; 
      }
    }else{
      return $scope.autocompProveedor;
    }
  };

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var res = response.data;
      $scope.autocompProveedor = angular.copy(res.item_txt_nitproveedor);
      $scope.progress = false;
    });
  }

  $scope.getReferenciasPorOc = function(){
    $scope.progress = true;
    console.log($scope.searchTextProveedor);
    var data = {};
    data.proveedor = $scope.selectedItem;
    $http.post($scope.urlOC, data, []).then(function(response){
      var res = response.data;
      console.log(res);
      $scope.progress = false;

    });
  }

  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
    DTColumnDefBuilder.newColumnDef(3).notSortable()
  ];


  $scope.getInfo();

}]);
