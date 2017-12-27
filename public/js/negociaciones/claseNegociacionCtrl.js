app.controller('claseNegociacionCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "clasenegociacionInfo";
	$scope.url = "clasenegociacion";

  $scope.progress = true;
  $scope.isEdit = false;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var data = response.data;
      $scope.clases = angular.copy(data.clases);
      console.log($scope.clases);
      $scope.progress = false;
      });
  } 
  $scope.getInfo();
  
  $scope.saveClase = function(){
    $scope.progress = true;
    if ($scope.isEdit == false) {
      $http.post($scope.url, $scope.clase).then(function(response){
      console.log(response);
      $scope.getInfo();
      }, function(error){
      console.log(error);
      $scope.getInfo();
      });
    }else{
      $http.put($scope.url + '/' + $scope.clase.id, $scope.clase).then(function(response){        
        console.log(response);
        $scope.clase = {};
        $scope.getInfo();
      });
    }
    angular.element('.close').trigger('click');
  }

  $scope.resetForm = function(){
    $scope.clase = {};
    $scope.isEdit = false;
  }
  
  $scope.editarClase = function(clase){
    $scope.clase = angular.copy(clase);
    $scope.isEdit = true;
  }

  $scope.eliminarClase = function(clase){
    var confirm = $mdDialog.confirm()
    .title('¡ALERTA!')
    .textContent('¿Realmente desea eliminar el registro?')
    .ariaLabel('Lucky day')
    .targetEvent()
    .ok('Si')
    .cancel('No, gracias');
    $mdDialog.show(confirm).then(function() {
      $http.delete($scope.url + '/' + clase.id).then(function(response){
        $scope.getInfo();
        $scope.progress = true;
      });
    });
  }

}]);