app.controller('areasCtrl', ['$scope', '$http', '$filter', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', function($scope, $http, $filter, DTOptionsBuilder, DTColumnDefBuilder, $mdDialog){
  $scope.getUrl = "periodosInfo";
  $scope.url = "periodos";

  $scope.getInfo = function(){

    $http.get($scope.getUrl).then(function(response){
      var res = response.data;
      $scope.periodos = angular.copy(res.periodos);
    });

  }


}]);
