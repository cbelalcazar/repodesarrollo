app.controller('programacionCtrl', ['$scope', '$http', '$filter', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', function($scope, $http, $filter, DTOptionsBuilder, DTColumnDefBuilder,  $mdDialog){
  $scope.getUrl = "programacionGetInfo";

  $scope.progress = true;
  $scope.getInfo = function(){

    $http.get($scope.getUrl).then(function(response){
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
