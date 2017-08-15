app.controller('programacionCtrl', ['$scope', '$timeout', '$http', '$filter', 'DTOptionsBuilder', 'DTColumnDefBuilder', '$mdDialog', '$window', '$interval', function($scope, $timeout, $http, $filter, DTOptionsBuilder, DTColumnDefBuilder,  $mdDialog, $window, $interval){
  $scope.getUrl = "programacionGetInfo";
  $scope.Url = "programacion";
  $scope.urlOC = "referenciasPorOc";
  $scope.referencias = [];
  $scope.ordenes = [];
  $scope.objeto = {
    'ordenObj':  undefined,
    'id'      :  "",
  };
  $scope.errorCantidad = false;
  $scope.progPendEnvio = [];
  $scope.alertas = false;
  $scope.mensajes = {};
  $scope.mensajeExito = false;
  $scope.progSelected = [];
  $scope.progress = true;
  $scope.datoRestar = 0;
  $scope.mensajeEliminar = false;

 // FUNCIONALIDADES ESPECIFICAS DEL FORMULARIO

  $scope.save = function(){
    // Busco la referencia a guardar en el catalogo de referencias del aplicativo t_inforeferencia para poder calcular
    // Como viene la carga dato que sirve a la persona de bodega en la asignacion de la cita
    var filtro = $filter('filter')($scope.infoReferencia, {iref_referencia : $scope.objeto.ordenObj.Referencia.trim()});
    // Calculo de cantidad de empaques que va a enviar el proveedor
    var canempaques = $scope.objeto.cant_pedida / filtro[0].iref_pesoporempaque;
    //activa la progress bar
    $scope.progress = true;
    //Crea el objeto que se va a guardar en la base de datos
    $scope.objProg = {
     'id'                     : $scope.objeto.id,
     'prg_num_orden_compra'   : $scope.objeto.ordenObj.ConsDocto,
     'prg_tipo_doc_oc'        : $scope.objeto.ordenObj.TipoDocto,
     'prg_referencia'         : $scope.objeto.ordenObj.Referencia,
     'prg_desc_referencia'    : $scope.objeto.ordenObj.DescripcionReferencia,
     'prg_nit_proveedor'      : $scope.objeto.ordenObj.NitTercero,
     'prg_razonSocialTercero' : $scope.objeto.ordenObj.RazonSocialTercero,
     'prg_fecha_programada'   : $scope.objeto.fechaEntrega,
     'prg_cant_programada'    : $scope.objeto.cant_pedida,
     'prg_cant_solicitada_oc' : $scope.objeto.ordenObj.CantPedida,
     'prg_cant_entregada_oc'  : $scope.objeto.ordenObj.CantEntrada,
     'prg_cant_pendiente_oc'  : $scope.objeto.ordenObj.CantPendiente,
     'prg_fecha_ordenCompra'  : $scope.objeto.ordenObj.f421_fecha_entrega,
     'prg_consecutivoRefOc'   : $scope.objeto.ordenObj.f421_rowid,
     'prg_unidadreferencia'   : $scope.objeto.ordenObj.UndOrden,
     'prg_cantidadempaques'   : Math.ceil(canempaques),
     'prg_tipoempaque'        : filtro[0].iref_tipoempaque + ' de ' + filtro[0].iref_pesoporempaque,
     'prg_observacion'        : $scope.objeto.observacion,
     'prg_tipo_programacion'  : filtro[0].iref_programable,
     'prg_estado' : 1
   }
   // Envia el objeto al controlador de laravel
   $http.post($scope.Url, $scope.objProg).then(function(response){
      var res = response.data;
      // valida si en la respuesta esta definido algun error, si hay muestra mensaje
      // si no ahi guarda el objeto en el grupo de objetos y limpia el formulario
      if (res.errors == undefined) {
        existe =  $filter('filter')($scope.progPendEnvio, {id : res.id});
        if (existe.length > 0) {
            var pos = $scope.progPendEnvio.indexOf(existe[0]);
            $scope.progPendEnvio.splice(pos, 1);
            $scope.progPendEnvio.push(res); 
        }else{
          $scope.progPendEnvio.push(res);
          $scope.mostrarTabla = false; 
        }        
        $scope.mensajeExito = true;
        $scope.objeto.cant_pedida = "";
        $scope.objeto.fechaEntrega = "";
        $scope.objeto.observacion = ""; 
        $scope.searchTextProveedor = "";
        $scope.objeto.selectedItem = undefined;   
        $scope.objeto.referencia = {};
        $scope.objeto.ordenObj = undefined;  
        $scope.periodoForm.$setPristine();
        $scope.progSelected = [];    
      }else{
       $scope.mensajes = res.errors;     
       $scope.alertas = true;
      }
      $scope.progress = false;   
      $timeout(function() {
      $scope.alertas = false;  
      $scope.mensajeExito = false;
      $scope.mensajes = {};
      }, 5000);
    }, function(response){
      alert(response.statusText + "  ["+ response.status + "]");
    });

  }

  $scope.cambiaEstado = function(){
    $scope.progress = true;     
    if ($scope.progSelected.length > 0) {
      $http.put($scope.Url + '/2', $scope.progSelected).then(function(response){
        $scope.getInfo();   
        $scope.progSelected = [];
      }, function(response){
        alert(response.statusText + "  ["+ response.status + "]");
      });
    }else{
      $scope.progress = false; 
      alert = $mdDialog.alert({
        title: 'Favor seleccionar al menos un elemento',
        textContent: '',
        ok: 'Cerrar'
      });
      $mdDialog
        .show(alert)
        .finally(function() {
          alert = undefined;
        });
      
    }
  }

  $scope.edit = function(obj){
    $scope.tituloBoton = 'Actualizar';
    $scope.tituloModal = 'Actualizar Programación Orden de Compra: #' + obj.id;
    $scope.objeto.id = obj.id;
    $scope.equisAutocompletar = false;
    $scope.bloqAutocompl = true;
    $scope.mostrarLinkOc = true;
    $scope.searchTextProveedor = obj.prg_razonSocialTercero;
    // Seteo autocomplete
    $scope.objeto.selectedItem = {
                                  'nitTercero' : obj.prg_nit_proveedor,
                                  'razonSocialTercero' : obj.prg_razonSocialTercero
                                  };
    // Seteo combo con referencias
    $scope.objeto.referencia = {
                                  'DescripcionReferencia' : obj.prg_desc_referencia,
                                  'Referencia': obj.prg_referencia.trim()
                                };
    // Seteo orden de compra utilizada                          
    $scope.objeto.ordenObj =  {
                               'ConsDocto'                : obj.prg_num_orden_compra,
                               'TipoDocto'                : obj.prg_tipo_doc_oc,
                               'Referencia'               : obj.prg_referencia,
                               'DescripcionReferencia'    : obj.prg_desc_referencia,
                               'NitTercero'               : obj.prg_nit_proveedor,
                               'RazonSocialTercero'       : obj.prg_razonSocialTercero,
                               'CantPedida'               : obj.prg_cant_solicitada_oc,
                               'CantEntrada'              : obj.prg_cant_entregada_oc,
                               'CantPendiente'            : obj.prg_cant_pendiente_oc,
                               'f421_fecha_entrega'       : obj.prg_fecha_ordenCompra,
                               'f421_rowid'               : obj.prg_consecutivoRefOc,
                             };
    $scope.datoRestar = 0;
    // Calculo la cantidad total maxima posible de programar en la orden de compra
    $scope.datoRestar += obj.prg_cant_programada;
    $scope.seleccionarOrden($scope.objeto.ordenObj, $scope.datoRestar);    
    $timeout(function() {
       $scope.toggle.list1 = false;
       $scope.mostrarTabla = false;
    }, 500);
    // Obtengo la cantidad y fecha programada de la programacion
    $scope.objeto.cant_pedida = obj.prg_cant_programada;  
    $scope.objeto.fechaEntrega = new Date($filter('date')(obj.prg_fecha_programada, 'MM/dd/yyyy', '+0500'));
    $scope.objeto.observacion = obj.prg_observacion;
  }

  $scope.showConfirm = function(ev, prg) {
    // Appending dialog to document.body to cover sidenav in docs app
    var textBorrado = '¿Desea eliminar la programacion #' + prg.id + '?';
    var confirm = $mdDialog.confirm()
    .title(textBorrado)
    .textContent('')
    .ariaLabel('Buen dia')
    .targetEvent(ev)
    .ok('OK')
    .cancel('CANCELAR');

    $mdDialog.show(confirm).then(function() {
      $scope.delete(prg.id, prg);            
    }, function() {
      //
    });


  };

  $scope.delete = function(id, prg){
    $scope.progress = true;     
    // Envia el objeto al controlador de laravel para ser borrado
    $http.delete($scope.Url + '/'+ id).then(function(response){
      if (response.data = 'success') {
        var pos = $scope.progPendEnvio.indexOf(prg);
        $scope.progPendEnvio.splice(pos, 1);
        $scope.mensajeEliminar = true;
        $scope.progress = false; 
      }      
    }, function(response){
      alert(response.statusText + "  ["+ response.status + "]");
    });

    $timeout(function() {
      $scope.mensajeEliminar = false;
    }, 5000);
    $scope.progSelected = [];    
  }

  $scope.eliminarSeleccionadas = function(ev){
    console.log($scope.progSelected);
    
    // Appending dialog to document.body to cover sidenav in docs app
    var textBorrado = '¿Desea eliminar las ' + $scope.progSelected.length + ' seleccionadas';
    var confirm = $mdDialog.confirm()
    .title(textBorrado)
    .textContent('')
    .ariaLabel('Buen dia')
    .targetEvent(ev)
    .ok('OK')
    .cancel('CANCELAR');

    $mdDialog.show(confirm).then(function() {
      $scope.progress = true;
      $scope.progSelected.forEach(function(obj) {
         // uno
         $http.delete($scope.Url + '/'+ obj.id).then(function(response){
          if (response.data = 'success') {
            $scope.mensajeEliminar = true;
          }      
        }, function(response){
          alert(response.statusText + "  ["+ response.status + "]");
        });
          // dos
      }); 
      $scope.getInfo(); 
      $scope.progSelected = [];        
    }, function() {
      //
    });
    
    $timeout(function() {
      $scope.mensajeEliminar = false;
    }, 5000);
  }

  $scope.filtrarOrdenes = function(){
    if($scope.objeto.referencia == undefined){
      $scope.ordenes = $scope.todas;
    }else if($scope.objeto.referencia != ""){
     $scope.ordenes = $filter('filter')($scope.todas, {Referencia : $scope.objeto.referencia.Referencia});
   }
   $scope.objeto.orden = "";
   $scope.objeto.ordenObj = undefined;
   $scope.objeto.cant_pedida = "";
   $scope.objeto.observacion = "";
  }

  $scope.seleccionarOrden = function(orden, datoRestar = 0){
    // crea un objeto referencia con la informacion de la orden seleecionada en el formulario
    var filtro = $filter('filter')($scope.infoReferencia, {iref_referencia : orden.Referencia.trim()});
    if (filtro.length <= 0) {
      $scope.alertas = true;
      $scope.mensajes.obj = ['No existe esta referencia en el catalogo, favor indicar si se puede programar o no'];
      $timeout(function() {
        $scope.alertas = false;
        $scope.mensajes = {};
      }, 6000);
      return false;
    }
    $scope.objeto.referencia = {
                                'DescripcionReferencia' : orden.DescripcionReferencia,
                                'Referencia'            : orden.Referencia.trim()
                               } 
    $scope.toggle.list1 = false;
    $scope.objeto.ordenObj = orden;  
    $scope.cantMaximaProg = 0;
    $scope.datoRestar = datoRestar;
    var existe = [];
    existe =  $filter('filter')($scope.progPendEnvio, {prg_consecutivoRefOc : $scope.objeto.ordenObj.f421_rowid});
    if (existe.length > 0) {
      existe.forEach(function(obj) {
         $scope.cantMaximaProg += obj.prg_cant_programada;
      });
    }  
    $scope.objeto.orden = orden.TipoDocto + ' - ' + orden.ConsDocto + ' - Cantidad Maxima: ' + ($scope.datoRestar += parseInt(orden.CantPendiente).toFixed() -  $scope.cantMaximaProg);
    $scope.objeto.cant_pedida = "";   
    $scope.objeto.fechaEntrega = "";
    $scope.objeto.observacion = "";
    $scope.ordenes = $filter('filter')($scope.todas, {Referencia : $scope.objeto.referencia.Referencia});
  }


  $scope.validarCantidadIngresada = function(){
    if(parseInt($scope.objeto.cant_pedida) > parseInt($scope.datoRestar)){
      $scope.errorCantidad = true;
      $scope.objeto.cant_pedida = "";
    }else{
      $scope.errorCantidad = false;
    }
  }




  // FUNCIONES DEL AUTOCOMPLETE

   // Funcion que filtra el array de proveedores por la palabra ingresada en el autocomplete y retorna el array filtrado
  $scope.query = function(searchTextProveedor) { 
    console.log(searchTextProveedor);
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

  // FUNCIONES QUE CARGAN LA INFORMACION A LA VISTA PARA SER UTILIZADA

  // Funcion que consulta la informacion de cargue inicial de la pagina
  $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
      var res = response.data;
        $scope.autocompProveedor = angular.copy(res.item_txt_nitproveedor);
        $scope.progPendEnvio = angular.copy(res.progPendEnvio);
        $scope.infoReferencia = angular.copy(res.infoReferencia);
        $scope.progress = false;   
    });
  }

  $scope.getInfo();

  // funcion que trae las referencias y las ordenes de compra cuando se ingresa el nombre del proveedor
  $scope.getReferenciasPorOc = function(){
      if ($scope.searchTextProveedor != "") {
       $scope.progress = true;
       $scope.toggle.list1 = true;       
       $scope.mostrarTabla = true;
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
      $scope.objeto.ordenObj = undefined;
      $scope.ordenes = [];
      $scope.todas = [];
      $scope.referencias = {};
      $scope.objeto.cant_pedida = "";
      $scope.objeto.fechaEntrega = "";
      $scope.objeto.observacion = "";
    }   
  }

  $scope.limpiar = function(){      
      $scope.mostrarTabla = false;
      $scope.equisAutocompletar = true;
      $scope.mostrarLinkOc = false;
      $scope.bloqAutocompl = false;
      $scope.objeto.referencia = {};
      $scope.objeto.orden = "";
      $scope.ordenes = [];
      $scope.objeto.ordenObj = undefined;
      $scope.referencias = {};
      $scope.objeto.cant_pedida = "";
      $scope.objeto.fechaEntrega = "";
      $scope.objeto.observacion = "";
      $scope.datoRestar = 0;
      $scope.searchTextProveedor = "";
      $scope.selectedItem = {};
      $scope.objeto.id = "";
      $scope.tituloBoton = 'Adicionar';
      $scope.tituloModal = 'Crear Programación Orden de Compra';
  };

  // ESTAS FUNCIONES CORRESPONDEN A LA FUNCIONALIDAD DE SELECCIONAR UNA O VARIAS PROGRAMACIONES PARA CAMBIAR DE ESTADO 
  // ANGULAR MATERIAL.
  $scope.exists = function (prg, list) {
    return list.indexOf(prg) > -1;
  };

  $scope.toggle = function (prg, list) {
    var idx = list.indexOf(prg);
    if (idx > -1) {
      list.splice(idx, 1);
    }
    else {
      list.push(prg);
    }
  };

  $scope.isChecked = function() {
    var listaSinEstadoUno = $filter('filter')($scope.progPendEnvio, {prg_estado : 1});
    return $scope.progSelected.length === listaSinEstadoUno.length;
  };

  $scope.isIndeterminate = function() {
    var listaSinEstadoUno = $filter('filter')($scope.progPendEnvio, {prg_estado : 1});
    return ($scope.progSelected.length !== 0 &&
        $scope.progSelected.length !== listaSinEstadoUno.length);
  };

  $scope.toggleAll = function() {
    var listaSinEstadoUno = $filter('filter')($scope.progPendEnvio, {prg_estado : 1});
    if ($scope.progSelected.length === listaSinEstadoUno.length) {
      $scope.progSelected = [];
    } else if ($scope.progSelected.length === 0 || $scope.progSelected.length > 0) {
      $scope.progSelected = listaSinEstadoUno.slice(0);
    }
  };

  // INICIALIZACION LIBRERIA DATATABLE
  $scope.dtOptions = DTOptionsBuilder.newOptions();
  $scope.dtColumnDefs = [
  DTColumnDefBuilder.newColumnDef(0).notSortable(),
  DTColumnDefBuilder.newColumnDef(9).notSortable()
  ];
  $scope.dtColumnDefs2 = [];

  // FUNCIONES PARA EL MANEJO DE CALENDARIOS

  $scope.cambiarFormato = function(fecha){
    return new Date(fecha);
  }

  //Funcion que le dice al calendario que dias deben estar bloqueados y desbloqueados
  $scope.soloDiasSemana = function(date){
    var day = date.getDay();
    return day === 1 || day === 2|| day === 3|| day === 4|| day === 5;
  }

  //Animacion de sombras 
  this.elevation = 1;
  this.nextElevation = function() {
        if (++this.elevation == 25) {
          this.elevation = 1;
        }
      };
  $interval(this.nextElevation.bind(this), 50);

}]);
