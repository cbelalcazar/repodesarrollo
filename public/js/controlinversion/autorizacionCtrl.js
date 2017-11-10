app.controller('autorizacionCtrl',
['$scope',  '$filter', '$http', '$window', 'DTOptionsBuilder', 'DTColumnDefBuilder',
function($scope,  $filter, $http, $window, DTOptionsBuilder, DTColumnDefBuilder){


  $scope.urlGetInfo  = './aprobacionGetInfo';
  $scope.url  = 'aprobacion';
  $scope.zonasSolicitud = [];
  $scope.lineasSolicitud = [];


	$scope.getInfo = function(){
    $scope.progress = true;

    $http.get($scope.urlGetInfo).then(function(response){
      var res = response.data;
      $scope.usuarioLogeado = angular.copy(res.userLogged);
      $scope.solicitudes = angular.copy(res.solicitudesPorAceptar);
      $scope.estados = angular.copy(res.estados);
      $scope.progress= false;
    }, function(errorResponse){
			console.log(errorResponse);
			$scope.getInfo();
		});
  }

  $scope.getInfo();

  $scope.setSolicitud = function(solicitud, boton = 0){

    if (boton == 0) {

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
      }

      if(solicitud.cargaralinea == null){

        if(solicitud.clientes.length > 0){

          solicitud.clientes.forEach(function(cliente){

            cliente.clientes_referencias.forEach(function(referencia){
              console.log($scope.lineasSolicitud);

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
    }else if(boton == 1){
      $scope.solicitud = solicitud;
    }

  }

  $scope.enviarAprobacion = function(){
    $scope.progress = true;
    console.log($scope.solicitud);
    $scope.solicitud.usuarioLogeado = $scope.usuarioLogeado;
    $http.post($scope.url, $scope.solicitud).then(function(response){
      var data = response.data;
      console.log('Respuesta:');
      if (data == 'errorNoExisteNivelTres') {
        // Muestro mensaje de error
        $scope.progress = false;
        alert("No se encuentra ninguna persona para realizar la aprobacion en niveles de autorizacion");
      }else{
        $window.location.reload();
      }
    }, function(errorResponse){

    });
  }






}]);
