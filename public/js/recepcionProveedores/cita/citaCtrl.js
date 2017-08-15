app.controller('citaCtrl', ['$scope', '$http', '$filter', function($scope, $http, $filter){

  $scope.progress = true;
  $scope.getUrl = 'citaGetInfo';
  $scope.programaciones = [];

 // Funcion que consulta la informacion de cargue inicial de la pagina
  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var res = response.data;
        $scope.programaciones = angular.copy(res.programaciones);
        $scope.progress = false;   
    });
  }
  
  $scope.getInfo();

}]);
