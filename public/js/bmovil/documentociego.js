app.controller('indexciego', ['$scope', '$http', '$filter',
	function($scope, $http, $filter){
    $scope.urlGetInfo = 'documentociegoGetInfo';
    $scope.citas = [];
    $scope.progress = true;

    $scope.getInfo = function(){
      $http.get($scope.urlGetInfo).then(function(response){
        res = response.data;
        console.log(res);
        $scope.citas = angular.copy(res.citas);  
        $scope.progress = false;
      });
    }
    $scope.getInfo();


    $scope.filtrarFecha = function(fecha){
      console.log(fecha)
      return $filter('date')(fecha, 'dd/MM/yyyy');
    }



     
}]);

