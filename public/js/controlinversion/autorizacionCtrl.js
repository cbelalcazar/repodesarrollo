app.controller('autorizacionCtrl',
['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder',
function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder){


  $scope.urlGetInfo  = './aprobacionGetInfo';
  $scope.zonasSolicitud = [];


	$scope.getInfo = function(){
    $scope.progress = true;

    $http.get($scope.urlGetInfo).then(function(response){
      console.log(response.data);

      var res = response.data;

      $scope.solicitudes = res.solicitudesPorAceptar;
      $scope.estados = res.estados;

      console.log($scope.solicitudes);

      $scope.progress= false;
    }, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
  }

  $scope.getInfo();

  $scope.setSolicitud = function(solicitud){

    console.log(solicitud);

    $scope.solicitud = solicitud;

    if($scope.solicitud.sci_tipopersona == 1){

      solicitud.clientes.forEach(function(cliente){
        if($scope.zonasSolicitud.length == 0){
          $scope.zonasSolicitud.push(cliente.clientes_zonas);
        }else{
          var filterZonas = $filter('filter')($scope.zonasSolicitud, {scz_zon_id: cliente.clientes_zonas.scz_zon_id});
          if(filterZonas.length == 0){
            $scope.zonasSolicitud.push(cliente.clientes_zonas);
          }else if(filterZonas[0].scz_zon_id != cliente.clientes_zonas.scz_zon_id){
            $scope.zonasSolicitud.push(cliente.cliente_zonas);
          }
        }
      })
      console.log($scope.zonasSolicitud);
    }

    if(solicitud.cargaralinea == null){

      if(solicitud.clientes.length > 0){
          solicitud.clientes.forEach(function(cliente){

            cliente.clientes_referencias.forEach(function(referencia){
              if($scope.lineasSolicitud.length == 0){
                  $scope.lineasSolicitud.push(referencia);
              }else{
                var filterLineas = $filter('filter')($scope.lineasSolicitud, {srf_referencia : referencia.srf_referencia});
                if(filterLineas.length == 0){
                  $scope.lineasSolicitud.push(referencia);
                }else if(filterLineas[0].srf_referencia != referencia.srf_referencia){
                  $scope.lineasSolicitud.push(referencia);
                }
              }
            });
          });
        }
    }

  }

  $scope.enviarAprobacion = function(){
    console.log($scope.solicitud);
  }





}]);
