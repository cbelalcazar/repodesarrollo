app.controller('programacionCtrl', ['$scope', '$timeout', '$http', '$filter', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', '$window', function($scope, $timeout, $http, $filter, DTOptionsBuilder, DTColumnDefBuilder,  $mdDialog, $window ){
  $scope.getUrl = "programacionGetInfo";
  $scope.Url = "programacion";
  $scope.urlOC = "referenciasPorOc";
  $scope.referencias = [];
  $scope.ordenes = [];
  $scope.objeto = {};
  $scope.errorCantidad = false;
  $scope.progPendEnvio = [];
  $scope.alertas = false;
  $scope.mensajes = {};
  $scope.mensajeExito = false;

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

  // Funcion que consulta la informacion de cargue inicial de la pagina
  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var res = response.data;
        $scope.autocompProveedor = angular.copy(res.item_txt_nitproveedor);
        $scope.progPendEnvio = angular.copy(res.progPendEnvio);
        $scope.progress = false;     
    });
  }

  $scope.getInfo();

  // funcion que trae las referencias y las ordenes de compra cuando se ingresa el nombre del proveedor
  $scope.getReferenciasPorOc = function(){
    if ($scope.searchTextProveedor != "") {
     $scope.progress = true;
     var data = {};
     data.proveedor = $scope.objeto.selectedItem;
     $http.post($scope.urlOC, data).then(function(response){
      var res = response.data;
      $scope.referencias = angular.copy(res.referencias);
      $scope.ordenes = angular.copy(res.ordenes);
      $scope.todas = angular.copy(res.ordenes);
      $scope.progress = false;
    });
   }else{
    $scope.objeto.referencia = {};
    $scope.objeto.orden = "";
    $scope.objeto.ordenObj = {};
    $scope.ordenes = {};
    $scope.todas = {};
    $scope.referencias = {};
    $scope.objeto.cant_pedida = "";
    $scope.objeto.fechaEntrega = "";
    $scope.objeto.observacion = "";
  }   
}

$scope.filtrarOrdenes = function(){
  if($scope.objeto.referencia == undefined){
    $scope.ordenes = $scope.todas;
  }else if($scope.objeto.referencia != ""){
   $scope.ordenes = $filter('filter')($scope.todas, {Referencia : $scope.objeto.referencia.Referencia});
 }
 $scope.objeto.orden = "";
 $scope.objeto.ordenObj = {};
 $scope.objeto.cant_pedida = "";
 $scope.objeto.observacion = "";
}

$scope.seleccionarOrden = function(orden){
  $scope.objeto.referencia = {'DescripcionReferencia' : orden.DescripcionReferencia,
  'Referencia': orden.Referencia.trim()}
  var f421_fecha_entrega = 
  $scope.objeto.orden = 'Orden de compra: ' + orden.TipoDocto + ' - ' + orden.ConsDocto + ' - Cantidad Maxima:' + parseInt(orden.CantPedida).toFixed();
  $scope.objeto.ordenObj = orden;  
  $scope.objeto.cant_pedida = "";   
  $scope.objeto.fechaEntrega = "";
  $scope.objeto.observacion = "";
  $scope.ordenes = $filter('filter')($scope.todas, {Referencia : $scope.objeto.referencia.Referencia});
}


$scope.dtOptions = DTOptionsBuilder.newOptions();
$scope.dtColumnDefs = [
DTColumnDefBuilder.newColumnDef(3).notSortable()
];




$scope.cambiarFormato = function(fecha){
  return new Date(fecha);
}

//Funcion que le dice al calendario que dias deben estar bloqueados y desbloqueados
$scope.soloDiasSemana = function(date){
  var day = date.getDay();
  return day === 1 || day === 2|| day === 3|| day === 4|| day === 5;
}

$scope.validarCantidadIngresada = function(){
  if(parseInt($scope.objeto.cant_pedida) > parseInt($scope.objeto.ordenObj.CantPendiente)){
    $scope.errorCantidad = true;
    $scope.objeto.cant_pedida = "";
  }else{
    $scope.errorCantidad = false;
  }
}

$scope.save = function(){
  $scope.progress = true;
  $scope.objProg = {
   'prg_num_orden_compra'   : $scope.objeto.ordenObj.ConsDocto,
   'prg_tipo_doc_oc'        : $scope.objeto.ordenObj.TipoDocto,
   'prg_referencia'         : $scope.objeto.ordenObj.Referencia,
   'prg_nit_proveedor'      : $scope.objeto.ordenObj.NitTercero,
   'prg_fecha_programada'   : $scope.objeto.fechaEntrega,
   'prg_cant_programada'    : $scope.objeto.cant_pedida,
   'prg_cant_solicitada_oc' : $scope.objeto.ordenObj.CantPedida,
   'prg_cant_entregada_oc'  : $scope.objeto.ordenObj.CantEntrada,
   'prg_cant_pendiente_oc'  : $scope.objeto.ordenObj.CantPendiente,
   'prg_fecha_ordenCompra'  : $scope.objeto.ordenObj.f421_fecha_entrega,
   'prg_consecutivoRefOc'   : $scope.objeto.ordenObj.f421_rowid,
   'prg_observacion'        : $scope.objeto.observacion,
   'prg_unidad_empaque'     : 1,
   'prg_cant_embalaje'      : 1,
   'prg_estado' : 1
 }
 $http.post($scope.Url, $scope.objProg).then(function(response){
    var res = response.data;
    if (res.errors == undefined) {
      $scope.progPendEnvio.push(res);
      $scope.mensajeExito = true;
      $scope.objeto.cant_pedida = "";
      $scope.objeto.fechaEntrega = "";
      $scope.objeto.observacion = "";         
      $scope.searchTextProveedor = "";
      $scope.objeto.selectedItem = "";   
      $scope.objeto.referencia = {};
    }else{
     $scope.mensajes = res.errors;     
     $scope.alertas = true;
    }
    $scope.progress = false;   
    $timeout(function() {
    $scope.alertas = false;  
    $scope.mensajeExito = false;
    $scope.mensajes = {};
    }, 11000);
  }, function(response){
    alert(response.statusText + "  ["+ response.status + "]");
  });

}


}]);
