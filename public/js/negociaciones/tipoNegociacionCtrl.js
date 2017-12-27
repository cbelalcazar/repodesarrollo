app.controller('tipoNegociacionCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "tiponegociacionInfo";
	$scope.url = "tiponegociacion";

  $scope.progress = true;
  $scope.isEdit = false;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var data = response.data;
      $scope.tipos = angular.copy(data.tipos);
      console.log($scope.tipos);
      $scope.progress = false;
      });
  } 
  $scope.getInfo();
  
  $scope.saveTipo = function(){
    $scope.progress = true;
    if ($scope.isEdit == false) {
      $http.post($scope.url, $scope.tipo).then(function(response){
      console.log(response);
      $scope.getInfo();
      }, function(error){
      console.log(error);
      $scope.getInfo();
      });
    }else{
      $http.put($scope.url + '/' + $scope.tipo.id, $scope.tipo).then(function(response){        
        console.log(response);
        $scope.tipo = {};
        $scope.getInfo();
      });
    }
    angular.element('.close').trigger('click');
  }

  $scope.resetForm = function(){
    $scope.tipo = {};
    $scope.isEdit = false;
  }
  
  $scope.editarTipo = function(tipo){
    $scope.tipo = angular.copy(tipo);
    $scope.isEdit = true;
  }

  $scope.eliminarTipo = function(tipo){
    var confirm = $mdDialog.confirm()
    .title('¡ALERTA!')
    .textContent('¿Realmente desea eliminar el registro?')
    .ariaLabel('Lucky day')
    .targetEvent()
    .ok('Si')
    .cancel('No, gracias');
    $mdDialog.show(confirm).then(function() {
      $http.delete($scope.url + '/' + tipo.id).then(function(response){
        $scope.getInfo();
        $scope.progress = true;
      });
    });
  }

}]);