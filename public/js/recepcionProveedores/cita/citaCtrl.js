app.directive('dragMe', function() {
    return {
        restrict: 'A',
        link: function(scope, elem, attr, ctrl) {
            elem.data('event', undefined);
            elem.draggable({
                zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });
        }
    };
});

app.controller('citaCtrl', ['$scope', '$http', '$filter', 'uiCalendarConfig', '$timeout', '$mdDialog',
    function($scope, $http, $filter, uiCalendarConfig, $timeout, $mdDialog){

        $scope.progress = true;
        $scope.getUrl = 'citaGetInfo';
        $scope.programaciones = [];
        $scope.seleccionadas = [];
        $scope.events = [];
        $scope.seleccionado = {};
        $scope.fecha = "";
        $scope.Url = "cita";

        $scope.seleccionar = function(obj){
            $scope.seleccionado = obj;
        }

 // Funcion que consulta la informacion de cargue inicial de la pagina
 $scope.getInfo = function(){
    $http.get($scope.getUrl).then(function(response){
        var res = response.data;
        $scope.programaciones = angular.copy(res.programaciones);
        $scope.events = angular.copy(res.citas);
        var eventos = $scope.events.map(function(obj){
            uiCalendarConfig.calendars.myCalendar.fullCalendar('renderEvent', JSON.parse(obj));
            return JSON.parse(obj);
        });
        $scope.events = eventos;   
        $scope.progress = false;   
    });
 }

 $scope.getInfo();

 $scope.mostrarProgramaciones = function(fecha, proveedor){
    $scope.fecha = fecha;
    $scope.seleccionadas = $scope.programaciones[fecha];
    $scope.seleccionadas = $filter('filter')($scope.seleccionadas, {prg_nit_proveedor : proveedor});
    uiCalendarConfig.calendars.myCalendar.fullCalendar('changeView', 'agendaDay', fecha);
 }

 $scope.drop = function(date, jsEvent, ui, resourceId) {
 	console.log($scope.events);
 	var eventosMismoDia = $filter('filter')($scope.events, {fechaGroup : $scope.fecha, resourceId: resourceId});
 	console.log(eventosMismoDia);
    if (String($filter('date')(date._d, 'yyyy-MM-dd','+0000')) == $scope.fecha) {
        var pos = $scope.seleccionadas.indexOf($scope.seleccionado);
        $scope.seleccionadas.splice(pos, 1);
        var d = new Date(date._d);   
        var start = String($filter('date')(date._d, 'yyyy-MM-dd HH:mm:ss','+0000'));      
        d.setMinutes(d.getMinutes()+15);
        var end = String($filter('date')(d, 'yyyy-MM-dd HH:mm:ss','+0000'));     
        obj = {
            overlap: false,
            stick: true,
            title: $scope.seleccionado.id + '-' + $scope.seleccionado.prg_tipo_doc_oc + '-' + $scope.seleccionado.prg_num_orden_compra+ '-' + $scope.seleccionado.prg_referencia+ '-Cant: ' + $scope.seleccionado.prg_cant_programada+ '- Embalaje: ' + $scope.seleccionado.prg_cantidadempaques+ ' en' + $scope.seleccionado.prg_tipoempaque + '-' + $scope.seleccionado.prg_nit_proveedor,
            start: start,
            end : end,
            resourceId : resourceId,
            programacion : $scope.seleccionado.id,
            proveedor: $scope.seleccionado.prg_nit_proveedor,
            nomProveedor: $scope.seleccionado.prg_razonSocialTercero,
            estado:'sinGuardar',
            fechaGroup : String($filter('date')(date._d, 'yyyy-MM-dd','+0000')),
        };
        if(String($filter('date')(date._d, 'HH:mm:ss','+0000')) == '00:00:00'){
            obj.allDay = true;
        }
        $scope.events.push(obj);
        uiCalendarConfig.calendars.myCalendar.fullCalendar('renderEvent', obj);
        $timeout(function() {
                    uiCalendarConfig.calendars.myCalendar.fullCalendar('changeView', 'agendaDay', $scope.fecha);
         }, 10);
        var pos2 = $scope.programaciones[$scope.fecha].indexOf($scope.seleccionado);
        $scope.programaciones[$scope.fecha].splice(pos2, 1);
    }else{ 
        alert = $mdDialog.alert({
            title: 'la programación debe ser agregada para el dia indicado por planeación',
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

 $scope.test = function(){
    console.log(uiCalendarConfig.calendars.myCalendar.fullCalendar('getEventSources'));
    console.log($scope.events);
 }


 

$timeout(function() {
	$scope.uiConfig = {
	    calendar:{
	        defaultView:'agendaDay',
	        height: 500,
	        allDaySlot: false,
	        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
	        editable: true,
	        defaultTimedEventDuration: {minutes : 5},
	        weekends: false,
	        slotEventOverlap: false,
	        eventOverlap: function (stillEvent, movingEvent) {
	            return stillEvent.allDay && movingEvent.allDay;
	        },
	        allDayText: 'Prog. sin hora',
	        slotDuration:'00:15:00',
	        slotLabelInterval :'00:15:00',
	        minTime:'07:00:00',
	        maxTime:'16:00:00',
	        header:{
	            left: 'agendaDay',
	            center: 'title',
	            right: 'prev,next'
	        },
	        droppable: true,
	        drop: $scope.drop,         
	        events: $scope.events,
	        resources: [
	        { id: 'MP', title: 'Materia prima'},
	        { id: 'ME', title: 'Material de empaque', eventColor: 'red'},
	        { id: 'AP', title: 'Apoyo', eventColor: 'green'}
	        ],          
	        timezone: 'America/Bogota', 
	        ignoreTimezone: false,  
	        groupByResource:true,   
	        eventOverlap: false,
	        changeView:'agendaDay',
	        businessHours: {
	                        //Se descarga de lunes a viernes
	                        dow: [ 1, 2, 3, 4, 5], 
	                        // Se descarga de 7 a 4pm
	                        start: '7:00',
	                        end: '16:00', 
	        },       
	        dayRender: function(date, cell){
	            if (String($filter('date')(date._d, 'yyyy-MM-dd','+0000')) != $scope.fecha) {
	                cell.css("background-color", "#eee");
	            }
	        },    
	        eventResize: function (event, delta, revertFunc, jsEvent, ui, view) {
	            var obj = $filter('filter')($scope.events, {programacion : event.programacion});
	            var pos = $scope.events.indexOf(obj[0]);
	            $scope.events.splice(pos, 1);
	            obj[0].end = String($filter('date')(event.end._d, 'yyyy-MM-dd HH:mm:ss','+0000'));
	            $scope.events.push(obj[0]); 
	            $scope.actualizarLista();
	        },
	        eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {  
	            if (String($filter('date')(event.start._d, 'HH:mm:ss','+0000')) < '07:00:00' || String($filter('date')(event.end._d, 'HH:mm:ss','+0000')) > '16:00:00' ) {
	                alert = $mdDialog.alert({
	                    title: 'la cita que intenta guardar esta fuera del rango determinado',
	                    textContent: '',
	                    ok: 'Cerrar'
	                });
	                $mdDialog
	                .show(alert)
	                .finally(function() {
	                    alert = undefined;
	                });    
	                $scope.actualizarLista();
	            }else{
	                var obj = $filter('filter')($scope.events, {programacion : event.programacion});
	                var fechaInicio = String($filter('date')(event.start._d, 'yyyy-MM-dd HH:mm:ss','+0000'));
	                if (event.end == null && event.allDay == true) {
	                    var fechaFin = null;
	                }else if(event.end == null && event.allDay == false){
	                    d = new Date(fechaInicio);
	                    d.setMinutes(d.getMinutes()+15);
	                    var fechaFin = String($filter('date')(d, 'yyyy-MM-dd HH:mm:ss'));
	                }else{
	                    var fechaFin = String($filter('date')(event.end._d, 'yyyy-MM-dd HH:mm:ss','+0000'));
	                }    
	                obj[0].allDay = event.allDay;       
	                var resourceId = event.resourceId;
	                var pos = $scope.events.indexOf(obj[0]);
	                $scope.events.splice(pos, 1);
	                obj[0].start = fechaInicio;
	                obj[0].end = fechaFin;
	                obj[0].resourceId = resourceId;
	                $scope.events.push(obj[0]); 
	                $scope.actualizarLista();
	            }      
	        }
	    }
	};
}, 3000);

            $scope.actualizarLista = function(fecha = $scope.fecha){
                uiCalendarConfig.calendars.myCalendar.fullCalendar('removeEvents');
                uiCalendarConfig.calendars.myCalendar.fullCalendar('addEventSource', $scope.events);
                $timeout(function() {
                    uiCalendarConfig.calendars.myCalendar.fullCalendar('changeView', 'agendaDay', fecha);                   
                }, 25);
            };

            $scope.guardarProgramacion = function(){
            	$scope.progress = true;
                var objetos = $filter('filter')($scope.events, {estado : 'sinGuardar'});
                objetos = $filter('orderBy')(objetos, 'start');
                $scope.objCitas = objetos;
                $http.post($scope.Url, $scope.objCitas).then(function(response){
                    var data = response.data;
                    $scope.getInfo();
                    $scope.progress = true;
                    $timeout(function() {
	                    $scope.actualizarLista();                  
	                }, 3000);  
	                $timeout(function() {
	                    $scope.progress = false;                
	                }, 3100);    
                }, function(response){
                    alert(response.statusText + "  ["+ response.status + "]");
                });
                        
            }

        }]);
