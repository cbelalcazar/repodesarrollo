app.controller('negociacionAnoAnteriorCtrl', ['$scope', '$http', '$filter', '$mdDialog', 'DTOptionsBuilder', 'DTColumnDefBuilder', function($scope, $http, $filter, $mdDialog, DTOptionsBuilder, DTColumnDefBuilder){
  $scope.getUrl = "negoanoanteriorInfo";
	$scope.url = "negoanoanterior";

  $scope.progress = true;
  $scope.isEdit = false;

  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var data = response.data;
      $scope.negoanos = angular.copy(data.negoanos);
      console.log($scope.negoanos);
      $scope.progress = false;
      });
  } 
  $scope.getInfo();
  
  $scope.saveNegoano = function(){
    $scope.progress = true;
    if ($scope.isEdit == false) {
      $http.post($scope.url, $scope.negoano).then(function(response){
      console.log(response);
      $scope.getInfo();
      }, function(error){
      console.log(error);
      $scope.getInfo();
      });
    }else{
      $http.put($scope.url + '/' + $scope.negoano.id, $scope.negoano).then(function(response){        
        console.log(response);
        $scope.negoano = {};
        $scope.getInfo();
      });
    }
    angular.element('.close').trigger('click');
  }

  $scope.resetForm = function(){
    $scope.negoano = {};
    $scope.isEdit = false;
  }
  
  $scope.editarNegoano = function(negoano){
    $scope.negoano = angular.copy(negoano);
    $scope.isEdit = true;
  }

  $scope.eliminarNegoano = function(negoano){
    var confirm = $mdDialog.confirm()
    .title('¡ALERTA!')
    .textContent('¿Realmente desea eliminar el registro?')
    .ariaLabel('Lucky day')
    .targetEvent()
    .ok('Si')
    .cancel('No, gracias');
    $mdDialog.show(confirm).then(function() {
      $http.delete($scope.url + '/' + negoano.id).then(function(response){
        $scope.getInfo();
        $scope.progress = true;
      });
    });
  }

}]);