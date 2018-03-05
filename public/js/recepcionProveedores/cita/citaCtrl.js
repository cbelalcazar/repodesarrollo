// Directiva que crea los eventos dragables
app.directive('dragMe', function() {
	return {
		restrict: 'A',
		link: function(scope, elem, attr, ctrl) {
            // Pongo el elemento undefined para yo mismo crearlo en el evento drop
            elem.data('event', undefined);
            // Este es el estilo que permite que el elemento se arrastre
            elem.draggable({
            	zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });
        }
    };
});


app.controller('citaCtrl', ['$scope', '$http', '$filter', 'uiCalendarConfig', '$timeout', '$mdDialog', '$window', '$interval',
	function($scope, $http, $filter, uiCalendarConfig, $timeout, $mdDialog, $window, $interval){

		//Inicializacion de variables
		$scope.progress = true;
		$scope.getUrl = 'citaGetInfo';
		$scope.programaciones = [];
		$scope.seleccionadas = [];
		$scope.events = [];
		$scope.seleccionado = {};
		$scope.fecha = "";
		$scope.Url = "cita";
        $scope.groupChekbox = [];
        $scope.recurso = "";
        $scope.urlConsultaVista = 'consultaProg';

// Funcion que se ejecuta cuando se da click a un elemento arrastrable para ponerlo en el calendario
$scope.seleccionar = function(obj){
	$scope.seleccionado = obj;
}

 // Funcion que consulta la informacion de cargue inicial de la pagina
 $scope.getInfo = function(){
 	// Realiza una peticion para traer la informacion desde el api hacia las variables de angular
 	$http.get($scope.getUrl).then(function(response){
 		var res = response.data;
 		// Obtiene las programaciones pendientes
 		$scope.programaciones = angular.copy(res.programaciones);
 		// Obtiene los muelles y eventos del calendario
 		$scope.muelles = angular.copy(res.muelles);
 		$scope.events = angular.copy(res.citas);

 		// parsea cada uno de los obj que vienen en el array events el cual tiene en cada posicion un string con formato JSON 
 		var eventos = $scope.events.map(function(obj){
            var objParse = JSON.parse(obj);
            uiCalendarConfig.calendars.myCalendar.fullCalendar('renderEvent', objParse);            
            // Si esta confirmada es negro #343a40
            if (objParse.estado == 'CONFIRMADA') {
                objParse.backgroundColor = "#343a40";
                objParse.borderColor = "#343a40";
                objParse.description = "Cita confirmada";
                return objParse;
            }else{
                // Si no esta confirmada queda gris
                objParse.description = "Cita sin confirmar";
                return objParse;
            } 			
 		});
 		$scope.events = eventos;   
 		$scope.progress = false; 
 		// Instancia el objeto de la libreria con toda la informacion para que muestre el calendario
 		$scope.uiConfig = {
 			calendar:{
 				defaultView:'agendaDay',
 				height: 430,
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
 				resources: $scope.muelles,          
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
            	var obj = $filter('filter')($scope.events, {start : event.start._i, nomProveedor : event.nomProveedor, resourceId: event.resourceId});
            	var pos = $scope.events.indexOf(obj[0]);
            	$scope.events.splice(pos, 1);                
            	obj[0].end = String($filter('date')(event.end._d, 'yyyy-MM-dd HH:mm:ss','+0000'));
            	$scope.events.push(obj[0]); 
            	$scope.actualizarLista(String($filter('date')(event.start._d, 'yyyy-MM-dd HH:mm:ss','+0000')));
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
            		var obj = $filter('filter')($scope.events, {start : event.start._i, nomProveedor : event.nomProveedor, resourceId: event.resourceIdOld});
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
                    obj[0].resourceIdOld = obj[0].resourceId;
            		$scope.events.push(obj[0]); 
            		$scope.actualizarLista(String($filter('date')(event.start._d, 'yyyy-MM-dd HH:mm:ss','+0000')));
            	}      
            },
            eventClick : function(event, jsEvent, view){

                $scope.progress = true;
                $scope.progShow = [];
                // Obtengo el objeto que quiero enviar
                var obj = $filter('filter')($scope.events, {start : event.start._i, nomProveedor : event.nomProveedor, resourceId: event.resourceId});
                if(obj[0].estado == "sinGuardar"){           
                    $scope.progShow = event.programacion;
                    $scope.progShow[0]['cita'] = JSON.parse(JSON.stringify(obj[0]));
                    angular.element('.close').trigger('click');
                    $scope.progress = false;
                    $scope.moverCalendarioAFecha();
                }else{
                    $http.post($scope.urlConsultaVista, obj).then(function(response){
                        var res = response.data;
                        $scope.progShow = angular.copy(res.progShow);
                        angular.element('.close').trigger('click');
                        $scope.progress = false;
                    });
                }

                
            }
        }
    };
        //  
    });
}

// Aqui se ejecuta la peticion inicial
$scope.getInfo();

// Esta funcion se ejecuta cuando le das click a uno de los proveedores de la bandeja de solicitud cita
// Su objetivo es mostrar en programaciones pendientes los objetos dropeables que representan programaciones
$scope.mostrarProgramaciones = function(fecha, proveedor){
    $scope.groupChekbox = [];
	$scope.fecha = fecha;
	$scope.seleccionadas = $scope.programaciones[fecha];
	$scope.seleccionadas = $filter('filter')($scope.seleccionadas, {prg_nit_proveedor : proveedor});
	uiCalendarConfig.calendars.myCalendar.fullCalendar('changeView', 'agendaDay', fecha);
}

// Esta funcion se ejecuta cuando se dropea un elemento encima del calendario su objetivo es crearlo solo visualmente
// y realiza validaciones respectivas a la creacion visual
$scope.drop = function(date, jsEvent, ui, resourceId) {
	// Esto se realiza para validar si estoy poniendo un objeto dragable encima de un objeto ya existente
	var eventosMismoDia = $filter('filter')($scope.events, {fechaGroup : $scope.fecha, resourceId: resourceId});
	$scope.fechaEvento = String($filter('date')(date._d, 'yyyy-MM-dd HH:mm:ss','+0000'));
	var eventos = [];
	eventos = eventosMismoDia.map(function(obj){ 
		if (obj.start <= $scope.fechaEvento && obj.end > $scope.fechaEvento) {
			return obj;
		}else{
			return null;
		}
	});
	eventos = $filter('remove')(eventos, null);


    //Ultimos tres dias y proximos tres dias rango para programar al proveedor
    var diasRangoMaximo = 4;   
    var validar = false;
    //Este codigo suma dias o resta segun el rango con el objetivo de validar si la fecha en la que se suelta el elemento
    //en el calendario esta dentro del rango permitido.
    for (var i = -3; i < diasRangoMaximo; i++) {
    	$scope.fechaInicioRango = new Date(String($filter('date')($scope.fecha, 'yyyy-MM-dd HH:mm:ss Z','+0500')));
    	$scope.nuevaFecha = $scope.sumaFecha($scope.fechaInicioRango, i);
    	if (String($filter('date')(new Date($scope.nuevaFecha), 'yyyy-MM-dd')) == String($filter('date')(date._d, 'yyyy-MM-dd','+0000'))) {
    		var validar = true;
    	}

        if (String($filter('date')(new Date(), 'yyyy-MM-dd')) > String($filter('date')(date._d, 'yyyy-MM-dd','+0000'))) {
            var validar = false;
        }
    }

    //Si pasa todas las validaciones entonces se crea el objeto en el calendario, si no muestra mensaje
    if (validar && eventos.length <= 0) {
        // Defino fecha de inicio del objeto
        var start = String($filter('date')(date._d, 'yyyy-MM-dd HH:mm:ss','+0000'));  

        // Defino fecha fin del objeto + 15 minutos
        var d = new Date(date._d);   
        d.setMinutes(d.getMinutes()+15);
        var end = String($filter('date')(d, 'yyyy-MM-dd HH:mm:ss','+0000'));         

        // Creo el objeto del calendario
        obj = {
            overlap: false,
            stick: true,
            title: $scope.groupChekbox[0].prg_nit_proveedor + ' - ' + $scope.groupChekbox[0].prg_razonSocialTercero,
            start: start,
            end : end,
            resourceId : resourceId,
            resourceIdOld : resourceId,
            programacion : $scope.groupChekbox,
            proveedor: $scope.groupChekbox[0].prg_nit_proveedor,
            nomProveedor: $scope.groupChekbox[0].prg_razonSocialTercero,
            estado:'sinGuardar',
            fechaGroup : String($filter('date')(date._d, 'yyyy-MM-dd','+0000')),
        };

        if(String($filter('date')(date._d, 'HH:mm:ss','+0000')) == '00:00:00'){
         obj.allDay = true;
        }
        
        // Quito los elementos agrupados de los arrays donde ya no deben estar.
        $scope.groupChekbox.forEach( function(element, index) {
            var pos = $scope.seleccionadas.indexOf(element);
            $scope.seleccionadas.splice(pos, 1);
            var pos2 = $scope.programaciones[$scope.fecha].indexOf(element);
            $scope.programaciones[$scope.fecha].splice(pos2, 1);
        });

        // Hago render del nuevo evento en el calendario
        $scope.events.push(obj);
        uiCalendarConfig.calendars.myCalendar.fullCalendar('renderEvent', obj);
        // Redirecciono el calendario a la fecha del evento que se acaba de crear
        $timeout(function() {
            // Cambio el tiempo del scroll 
            $scope.uiConfig.calendar.scrollTime = obj.start.split(' ')[1];
        }, 10);
        $timeout(function() {
         uiCalendarConfig.calendars.myCalendar.fullCalendar('changeView', 'agendaDay', String($filter('date')(date._d, 'yyyy-MM-dd','+0000')));
        }, 10);
        //Vacio el grupo de checkbox
        $scope.groupChekbox = [];

    }else{ 
    	if (eventos.length <= 0) {
    		var mensaje = 'la programación debe ser agregada para el dia indicado por planeación';
    	}else{
    		var mensaje = 'No se permite sobreponer elementos en el calendario.';
    	}
    	alert = $mdDialog.alert({
    		title: mensaje,
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

// Esta funcion imprime los elementos que se encuentran renderizados en el calendario
$scope.test = function(){
	console.log(uiCalendarConfig.calendars.myCalendar.fullCalendar('getEventSources'));
}


// Actualiza los elementos renderizados en el calendario
$scope.actualizarLista = function(fecha = $scope.fecha){
	uiCalendarConfig.calendars.myCalendar.fullCalendar('removeEvents');
	uiCalendarConfig.calendars.myCalendar.fullCalendar('addEventSource', $scope.events);
    // console.log(fecha);
    $timeout(function() {
        // Cambio el tiempo del scroll 
        var arregloHorFech = fecha.split(' ');
        console.log(arregloHorFech);
        if (arregloHorFech.length == 2) {
            $scope.uiConfig.calendar.scrollTime = arregloHorFech[1];
            console.log($scope.uiConfig.calendar.scrollTime);
        }
    }, 10);
	$timeout(function() {
		uiCalendarConfig.calendars.myCalendar.fullCalendar('changeView', 'agendaDay', fecha);                   
	}, 25);
};

// Actualiza los elementos renderizados en el calendario
$scope.moverCalendarioAFecha = function(){
    $timeout(function() {
        uiCalendarConfig.calendars.myCalendar.fullCalendar('changeView', 'agendaDay', $scope.fecha);                   
    }, 25);
};



$scope.guardarCitas = function(){
    // Obtiene una lista de todos los objetos que no se han guardado en el calendario
	var objetos = $filter('filter')($scope.events, {estado : 'sinGuardar'});
	if (objetos.length > 0) {
        // Muestra barra de progreso
		$scope.progress = true;
        // Ordena los objetos por fecha de inicio
		objetos = $filter('orderBy')(objetos, 'start');
		$scope.objCitas = objetos;
        // Realizo la peticion POST para guardar las citas en la base de datos
		$http.post($scope.Url, $scope.objCitas).then(function(response){
			var data = response.data;
			$scope.getInfo();
			$scope.progress = true;
			var mensaje = ""; 
			var fecha = "";    
			var proveedor = "";            
			response.data.citas.forEach( function(element, index) {

				if (element.error == true) {
					mensaje += '<strong>Error! - </strong>' + element.mensaje + '<br>';
				}else if(element.error == false){
					mensaje += '<strong>Exito! - </strong>' + element.cit_nombreproveedor + ' - Inicio: ' + element.cit_fechainicio + ' - Fin: ' + element.cit_fechafin + ' - Muelle:' + element.cit_muelle + '<br>';
				}                            
				fecha = element.fechaGroup;
				proveedor = element.cit_nitproveedor;

			});

			$timeout(function() {
				$scope.actualizarLista();      
				$scope.mostrarProgramaciones(fecha, proveedor);            
			}, 3000);  
			$timeout(function() {
				$scope.progress = false;                
			}, 3100);    
			alert = $mdDialog.alert({
				title: 'Resultados creación cita:',
				htmlContent: mensaje,
				ok: 'Cerrar'
			});
			$mdDialog
			.show(alert)
			.finally(function() {
				alert = undefined;
			});    
		}, function(response){
			alert(response.statusText + "  ["+ response.status + "]");
		});
	}else{
		alert = $mdDialog.alert({
			title: 'No se encontraron elementos para crear',
			htmlContent: "",
			ok: 'Cerrar'
		});
		$mdDialog
		.show(alert)
		.finally(function() {
		});  
	}


}

// Muestra input para solicitar la observacion al usuario y rechazar la programacion
$scope.showPrompt = function(ev, lista){
	var confirm = $mdDialog.prompt()
	.title('Desea rechazar la programacion?')
	.textContent('Favor ingresar la observación:')
	.placeholder('Observación')
	.ariaLabel('Observación')
	.initialValue('')
	.targetEvent(ev)
	.ok('Rechazar!')
	.cancel('Cancelar');

	$mdDialog.show(confirm).then(function(result) {
		if (result == undefined) {
			result = "";
		}
		lista.prg_observacion = result;
        $scope.progress = true;
		$http.put($scope.Url + '/' + lista.id, lista).then(function(response){
			var pos = $scope.programaciones[lista.prg_fecha_programada].indexOf(lista);
			$scope.programaciones[lista.prg_fecha_programada].splice(pos, 1);
			var pos = $scope.seleccionadas.indexOf(lista);
			$scope.seleccionadas.splice(pos, 1);
            $scope.getInfo();
            $scope.groupChekbox = [];
			$scope.progress = false;
		}, function(response){
			alert(response.statusText + "  ["+ response.status + "]");
		});
	}, function() {
	});
}
// Funcion que se ejecuta con el boton cancelar, que recarga la pagina
$scope.recargarPagina = function(){
	$window.location.reload();
}

// Funcion que suma o resta dias a la fechaque le pasemos
$scope.sumaFecha = function(fecha1, days){
	milisegundos=parseInt(35*24*60*60*1000);

	fecha= fecha1;
	day=fecha.getDate();
        // el mes es devuelto entre 0 y 11
        month=fecha.getMonth()+1;
        year=fecha.getFullYear();             
        //Obtenemos los milisegundos desde media noche del 1/1/1970
        tiempo=fecha.getTime();
        //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
        milisegundos=parseInt(days*24*60*60*1000);
        //Modificamos la fecha actual
        total=fecha.setTime(tiempo+milisegundos);
        day=fecha.getDate();
        month=fecha.getMonth()+1;
        year=fecha.getFullYear();

        return year+"-"+month+"-"+day;
    }

    //Animacion de sombras 
  this.elevation = 1;
  this.nextElevation = function() {
        if (++this.elevation == 25) {
          this.elevation = 1;
        }
      };
  $interval(this.nextElevation.bind(this), 100);


  //Funciones checkbox
    $scope.toggle = function (item, list) {
    var idx = list.indexOf(item);
        if (idx > -1) {
            list.splice(idx, 1);
        }
        else {
            list.push(item);
        }
    };

    $scope.exists = function (item, list) {
        return list.indexOf(item) > -1;
    };

    $scope.isIndeterminate = function() {
        return ($scope.groupChekbox.length !== 0 &&
        $scope.groupChekbox.length !== $scope.seleccionadas.length);
    };

    $scope.isChecked = function() {
        return $scope.groupChekbox.length === $scope.seleccionadas.length;
    };

    $scope.toggleAll = function() {
        if ($scope.groupChekbox.length === $scope.seleccionadas.length) {
            $scope.groupChekbox = [];
        } else if ($scope.groupChekbox.length === 0 || $scope.groupChekbox.length > 0) {
                $scope.groupChekbox = $scope.seleccionadas.slice(0);
        }
    };
  

}]);
