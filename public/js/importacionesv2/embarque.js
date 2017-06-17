jQuery(document).ready(function($) {

//Poner los calendarios en las cajas de texto
$('#emim_fecha_etd').datepicker();
$('#emim_fecha_eta').datepicker();
$('#emim_fecha_recibido_documentos_ori').datepicker();
$('#emim_fecha_envio_aduana').datepicker();
$('#emim_fecha_envio_ficha_tecnica').datepicker();
$('#emim_fecha_envio_lista_empaque').datepicker();
$('#emim_fecha_solicitud_reserva').datepicker();
$('#emim_fecha_confirm_reserva').datepicker();
$('#ocultar1').hide();
$("#tabs").tabs ('disable', 1);
$("#tabs").tabs ('disable', 2);
$("#tabs").tabs ('disable', 3);
//End calendarios

setTimeout(function(){
	if($('#emim_tipo_carga').val() == 3){
		fcl();
		$('#agregar').show();
	}
	$('#guardartablahtml').val($('#agregar').html());

}, 500)




//Validaciones al dar siguiente a la pagina 1 del menu
$('#siguiente1').click(function() {
	var continuar = true;
	if ($('#emim_embarcador').val() == ""){
		$('#error_embarcador').html('Favor buscar un embarcador');
		$('#embarcador_div').addClass('has-error');
		continuar = false;
	}
	if ($('#emim_linea_maritima').val() == ""){
		$('#error_lineamaritima').html('Favor buscar una linea maritima');
		$('#linea_div').addClass('has-error');
		continuar = false;
	}
	if ($('#emim_aduana').val() == ""){
		$('#error_agencia').html('Favor buscar una aduana');
		$('#agencia_div').addClass('has-error');
		continuar = false;
	}
	if ($('#emim_transportador').val() == ""){
		$('#error_transportador').html('Favor buscar un transportador');
		$('#transportador_div').addClass('has-error');
		continuar = false;
	}



	if (continuar) {
		$("#tabs").tabs ();
		$("#tabs").tabs ('enable', 1);
		$('#menu2').click();
		$("#tabs").tabs ('disable', 0);
	}

});

//Boton atras tab 2
$('#atras2').click(function() {
	$("#tabs").tabs ('enable', 0);
	$('#menu1').click();
	$("#tabs").tabs ('disable', 1);
});

$('#siguiente2').click(function() {
	var continuar = true;
	if ($('#emim_tipo_carga').val() == ""){
		$('#error_tipocarga').html('Favor seleccionar un tipo de carga');
		$('#tipo_carga_div').addClass('has-error');
		continuar = false;
	}else if($('#emim_tipo_carga').val() == 1 || $('#emim_tipo_carga').val() == 2){
		if ($('#cubicaje').val() == ""){
			$('#error_cubicaje').html('Favor ingresar el cubicaje');
			$('#cubicaje_div').addClass('has-error');
			continuar = false;
		}
		var validarmo = $('#cubicaje').val();
		if (typeof validarmo === 'undefined'){
			$('#error_tipocarga').html('Favor ingresar nuevamente cubicaje, peso y cajas');
			$('#tipo_carga_div').addClass('has-error');
			continuar = false;
		}
		if ($('#peso').val() == ""){
			$('#error_peso').html('Favor ingresar el peso');
			$('#peso_div').addClass('has-error');
			continuar = false;
		}
		if ($('#cajas').val() == ""){
			$('#error_cajas').html('Favor ingresar el numero de cajas');
			$('#cajas_div').addClass('has-error');
			continuar = false;
		}
		
	}else if($('#emim_tipo_carga').val() == 3){
		if (document.getElementById('tablaContenedor').rows.length == 1){
			$('#errorgenerado').html('Favor asociar minimo un contenedor a la importacion');
			$('#formTipocarga').addClass('has-error');
			continuar = false;
		}    
	}

	if (continuar) {
		$("#tabs").tabs ();
		$("#tabs").tabs ('enable', 2);
		$('#menu3').click();
		$("#tabs").tabs ('disable', 1);
	}

});

$('#siguiente3').click(function() {
	var continuar = true;
	if ($('#emim_fecha_etd').val() == ""){
		$('#error_etd').html('Favor ingresar la fecha del ETD');
		$('#etd_div').addClass('has-error');
		continuar = false;
	}

	if ($('#emim_fecha_eta').val() == ""){
		$('#error_eta').html('Favor ingresar la fecha del ETA');
		$('#eta_div').addClass('has-error');
		continuar = false;
	}
	
	
	if ($('#emim_fecha_solicitud_reserva').val() == ""){
		$('#error_fechsolicreser').html('Favor ingresar la fecha de solicitud de la reserva');
		$('#fechsolicreser_div').addClass('has-error');
		continuar = false;
	}

	if ($('#emim_fecha_confirm_reserva').val() == ""){
		$('#error_fechconfirreser').html('Favor ingresar la fecha de solicitud de la reserva');
		$('#fechconfirreser_div').addClass('has-error');
		continuar = false;
	}

	if (continuar) {
		$("#tabs").tabs ('enable', 3);
		$('#menu4').click();
		$("#tabs").tabs ('disable', 2);
	}
});

  //Boton atras tab 2
  $('#atras3').click(function() {
  	$("#tabs").tabs ('enable', 1);
  	$('#menu2').click();
  	$("#tabs").tabs ('disable', 2);
  });
  //End Boton atras tab 2



  $('#importacionform').submit(function() {
  	var continuar = true;
  	if ($('#emim_documento_transporte').val() == ""){
  		$('#error_doctranspor').html('Favor ingresar el numero de documento de trasnporte');
  		$('#doctranspor_div').addClass('has-error');
  		continuar = false;
  	}

  	if (continuar) {
  		return true;
  	}else{
  		return false;
  	}
  });


//Boton atras tab 2
$('#atras4').click(function() {
	$("#tabs").tabs ('enable', 2);
	$('#menu3').click();
	$("#tabs").tabs ('disable', 3);
});

$('.validemos').blur(function() {

	if ($('#emim_embarcador').val() == ""){
		$('#error_embarcador').html('Favor buscar un embarcador');
		$('#embarcador_div').addClass('has-error');
	}else if ($('#emim_embarcador').val() != ""){
		$('#error_embarcador').html('');
		$('#embarcador_div').removeClass('has-error');
		$('#embarcador_div').addClass('has-success');
	}

	if ($('#emim_linea_maritima').val() == ""){
		$('#error_lineamaritima').html('Favor buscar una linea maritima');
		$('#linea_div').addClass('has-error');
	}else if ($('#emim_linea_maritima').val() != ""){
		$('#error_lineamaritima').html('');
		$('#linea_div').removeClass('has-error');
		$('#linea_div').addClass('has-success');
	}

	if ($('#emim_aduana').val() == ""){
		$('#error_agencia').html('Favor buscar una aduana');
		$('#agencia_div').addClass('has-error');
	}else if ($('#emim_aduana').val() != ""){
		$('#error_agencia').html('');
		$('#agencia_div').removeClass('has-error');
		$('#agencia_div').addClass('has-success');
	}

	if ($('#emim_transportador').val() == ""){
		$('#error_transportador').html('Favor buscar un transportador');
		$('#transportador_div').addClass('has-error');
	}else if ($('#emim_transportador').val() != ""){
		$('#error_transportador').html('');
		$('#transportador_div').removeClass('has-error');
		$('#transportador_div').addClass('has-success');
	}
	if ($('#emim_tipo_carga').val() == ""){
		$('#error_tipocarga').html('Favor seleccionar un tipo de carga');
		$('#tipo_carga_div').addClass('has-error');
	}else if ($('#emim_tipo_carga').val() != ""){
		$('#error_tipocarga').html('');
		$('#tipo_carga_div').removeClass('has-error');
		$('#tipo_carga_div').addClass('has-success');
	}

	if ($('#cubicaje').val() == ""){
		$('#error_cubicaje').html('Favor ingresar el cubicaje');
		$('#cubicaje_div').addClass('has-error');
	}else if ($('#cubicaje').val() != ""){
		$('#error_cubicaje').html('');
		$('#cubicaje_div').removeClass('has-error');
		$('#cubicaje_div').addClass('has-success');
	}

	if ($('#peso').val() == ""){
		$('#error_peso').html('Favor ingresar el peso');
		$('#peso_div').addClass('has-error');
	}else if ($('#peso').val() != ""){
		$('#error_peso').html('');
		$('#peso_div').removeClass('has-error');
		$('#peso_div').addClass('has-success');
	}

	if ($('#cajas').val() == ""){
		$('#error_cajas').html('Favor ingresar el numero de cajas');
		$('#cajas_div').addClass('has-error');
	}else if ($('#cajas').val() != ""){
		$('#error_cajas').html('');
		$('#cajas_div').removeClass('has-error');
		$('#cajas_div').addClass('has-success');
	}

	if ($('#emim_fecha_etd').val() == ""){
		$('#error_etd').html('Favor ingresar la fecha del ETD');
		$('#etd_div').addClass('has-error');
	}else if ($('#emim_fecha_etd').val() != ""){
		$('#error_etd').html('');
		$('#etd_div').removeClass('has-error');
		$('#etd_div').addClass('has-success');
	}

	if ($('#emim_fecha_eta').val() == ""){
		$('#error_eta').html('Favor ingresar la fecha del ETA');
		$('#eta_div').addClass('has-error');
	}else if ($('#emim_fecha_eta').val() != ""){
		$('#error_eta').html('');
		$('#eta_div').removeClass('has-error');
		$('#eta_div').addClass('has-success');
	}




	if ($('#emim_fecha_solicitud_reserva').val() == ""){
		$('#error_fechsolicreser').html('Favor ingresar la fecha de solicitud de la reserva');
		$('#fechsolicreser_div').addClass('has-error');
	}else if ($('#emim_fecha_solicitud_reserva').val() != ""){
		$('#error_fechsolicreser').html('');
		$('#fechsolicreser_div').removeClass('has-error');
		$('#fechsolicreser_div').addClass('has-success');
	}

	if ($('#emim_fecha_confirm_reserva').val() == ""){
		$('#error_fechconfirreser').html('Favor ingresar la fecha de solicitud de la reserva');
		$('#fechconfirreser_div').addClass('has-error');
	}else if ($('#emim_fecha_confirm_reserva').val() != ""){
		$('#error_fechconfirreser').html('');
		$('#fechconfirreser_div').removeClass('has-error');
		$('#fechconfirreser_div').addClass('has-success');
	}

	if ($('#emim_documento_transporte').val() == ""){
		$('#error_doctranspor').html('Favor ingresar el numero de documento de trasnporte');
		$('#doctranspor_div').addClass('has-error');
	}else if ($('#emim_documento_transporte').val() != ""){
		$('#error_doctranspor').html('');
		$('#doctranspor_div').removeClass('has-error');
		$('#doctranspor_div').addClass('has-success');
	}




});

  //End Validaciones basadas en eventos formulario pestaña 1




//Quitar filas de la tabla 
$(document).on('click', '.borrar', function (event) {
	event.preventDefault();
	$(this).closest('tr').remove();
	if(document.getElementById('tablaContenedor').rows.length == 1){  	
		$('#ocultar1').hide();
		$('#tablaContenedorGuardar').val("");	
	}
});


$('#emim_tipo_carga').click(function(event) {
	if(this.value == 1 || this.value == 2){
		$('#formTipocarga').html("");
		$('#agregar').html("");		
		$('#ocultar1').hide();
		$('#tablaContenedorGuardar').val("");		
		$('#formTipocarga').show();
		var labelCubicaje = "<label  class='control-label'>Cubicaje: (*)</label>";
		var labelPeso = "<label  class='control-label'>Peso: (*)</label>";
		var labelNumcajas = "<label  class='control-label'>No. cajas: (*)</label>";
		var cubicaje = "<div class='col-sm-4' id='cubicaje_div'>"+labelCubicaje+"<input type='text' name='cubicaje' id='cubicaje' class='form-control' onblur='cubiValida(this);' placeholder='Favor ingresar el cubicaje'> <div class='help-block error-help-block' id='error_cubicaje'></div></div>";
		var peso ="<div class='col-sm-4' id='peso_div'>"+labelPeso+"<input type='text'  name='peso' id='peso'  class='form-control' onblur='pesoValida(this);' placeholder='Favor ingresar el peso'><div class='help-block error-help-block' id='error_peso'></div></div>";
		var numCajas = "<div class='col-sm-4' id='cajas_div'>"+labelNumcajas+"<input type='text'  name='cajas' id='cajas' onblur='cajaValida(this);' class='form-control' placeholder='Favor ingresar el numero de cajas'><div class='help-block error-help-block' id='error_cajas'></div></div>";
		$('#formTipocarga').html('<div class="row">'+cubicaje+peso+numCajas+"</div>");
	}

	if(this.value == 3){
		$('#formTipocarga').html("");
		$('#agregar').html("");	
		$('#formTipocarga').show();	
		$('#ocultar1').hide();	
		$('#tablaContenedorGuardar').val("");
		comboTipoContenedor = "";
		var json = $('#infoTipoContenedor').val();
		var jsonParce = JSON.parse(json);
		comboTipoContenedor += "<select id='tipoContenedor' class='form-control'>";
		comboTipoContenedor += "<option value=''>Seleccione un tipo de contenedor</option>";


		for(var key in jsonParce){
			comboTipoContenedor += "<option value=" + key  + ">" +jsonParce[key] + "</option>";
		}
		comboTipoContenedor += "</select>";
		var labelTipoContenedor = "<label  class='control-label'>Tipo Contenedor: (*)</label>";
		var labelCantidad = "<label  class='control-label'>Cantidad de cajas: (*)</label>";
		var labelNumeroImportacion = "<label  class='control-label'>No. Contenedor: (*)</label>";
		var labelCubicaje = "<label  class='control-label'>Cubicaje: (*)</label>";
		var labelPeso = "<label  class='control-label'>Peso: (*)</label>";
		var TipoContenedor ="<div class='form-group col-sm-4'>"+labelTipoContenedor+comboTipoContenedor+"</div>";
		var Cantidad ="<div class='form-group col-sm-4'>"+labelCantidad+"<input type='text'  name='cantidad' id='cantidad'  class='form-control' placeholder='Favor ingresar la cantidad'></div>";
		var numeroImportacion = "<div class='form-group col-sm-4'>"+labelNumeroImportacion+"<input type='text'  name='numeroImportacion' id='numeroImportacion'  class='form-control' placeholder='Favor ingresar el numero de importacion'></div>";
		var cubicaje = "<div class='form-group col-sm-4'>"+labelCubicaje+"<input type='text' name='cubicaje' id='cubicaje' class='form-control' placeholder='Favor ingresar el cubicaje'></div>";
		var peso ="<div class='form-group col-sm-4'>"+labelPeso+"<input type='text'  name='peso' id='peso'  class='form-control' placeholder='Favor ingresar el peso'></div>";
		var boton ="<br><div class='form-group col-sm-4'>" + '<button type="button" class="btn btn-primary " id="load" onclick="autocompletecontenedor(this);">Agregar</button></div>';
		$('#formTipocarga').html('<div class="row">'+TipoContenedor+Cantidad+numeroImportacion+"</div><div class='row'>"+cubicaje+peso+boton+"</div>");
		if($('#guardartablahtml').val != ""){
			$('#agregar').html($('#guardartablahtml').val());
		}
	}
	if(this.value == ''){
		$('#tablaContenedorGuardar').val("");
		$('#formTipocarga').html("");
		$('#agregar').html("");	
		$('#formTipocarga').hide();	
		$('#ocultar1').hide();
	}
});



/**************************************
 * Funciones para realizar autocomplete embarcador
 **************************************
 */
 //Oculta la caja de texto que contiene el nombre del proveedor
 if($("#razonsocialembarcador").val() == ""){
 	$("#razonsocialembarcador").hide();
 }

 $( function() {
 	function split( val ) {
 		return val.split( /,\s*/ );
 	}
 	function extractLast( term ) {
 		return split( term ).pop();
 	}

 	$( "#emim_embarcador" )
  // don't navigate away from the field on tab when selecting an item
  .on( "keydown", function( event ) {
  	if ( event.keyCode === $.ui.keyCode.TAB &&
  		$( this ).autocomplete( "instance" ).menu.active ) {
  		event.preventDefault();
  }
})
  .autocomplete({
  	source: function( request, response ) {
  		$.getJSON(  $( "#route1" ).val(), {
  			term: extractLast( request.term )
  		}, response );
  	},
  	search: function() {
        // custom minLength
        var term = extractLast( this.value );
        if ( term.length < 2 ) {
        	return false;
        }
    },
    focus: function() {
        // prevent value inserted on focus
        return false;
    },
    select: function( event, ui ) {
    	var terms = split( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( ", " );

        return false;
    }
});
} );

 //Acomoda la informacion en dos cajas de texto para que se visualize correctamente
 $("#emim_embarcador").blur(function(){
 	$("#razonsocialembarcador").show();
 	var info = $("#emim_embarcador").val();
 	var fields = info.split(' -> ');
 	$("#emim_embarcador").val(fields[0]);
 	$("#razonsocialembarcador").val(fields[1]);

 	setTimeout(function(){
 		if($("#razonsocialembarcador").val() == ""){
 			$("#emim_embarcador").val("");
 			$("#razonsocialembarcador").hide();
 		}
 	}, 500)


 });

/**************************************
 * End autocomplete embarcador
 **************************************
 */



/**************************************
 * Funciones para realizar autocomplete linea maritima
 **************************************
 */
 //Oculta la caja de texto que contiene el nombre del proveedor
 if($("#razonsociallinea").val() == ""){
 	$("#razonsociallinea").hide();
 }

 $( function() {
 	function split( val ) {
 		return val.split( /,\s*/ );
 	}
 	function extractLast( term ) {
 		return split( term ).pop();
 	}

 	$( "#emim_linea_maritima" )
  // don't navigate away from the field on tab when selecting an item
  .on( "keydown", function( event ) {
  	if ( event.keyCode === $.ui.keyCode.TAB &&
  		$( this ).autocomplete( "instance" ).menu.active ) {
  		event.preventDefault();
  }
})
  .autocomplete({
  	source: function( request, response ) {
  		$.getJSON(  $( "#route1" ).val(), {
  			term: extractLast( request.term )
  		}, response );
  	},
  	search: function() {
        // custom minLength
        var term = extractLast( this.value );
        if ( term.length < 2 ) {
        	return false;
        }
    },
    focus: function() {
        // prevent value inserted on focus
        return false;
    },
    select: function( event, ui ) {
    	var terms = split( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( ", " );

        return false;
    }
});
} );

 //Acomoda la informacion en dos cajas de texto para que se visualize  correctamente
 $("#emim_linea_maritima").blur(function(){
 	$("#razonsociallinea").show();
 	var info = $("#emim_linea_maritima").val();
 	var fields = info.split(' -> ');
 	$("#emim_linea_maritima").val(fields[0]);
 	$("#razonsociallinea").val(fields[1]);

 	setTimeout(function(){
 		if($("#razonsociallinea").val() == ""){
 			$("#emim_linea_maritima").val("");
 			$("#razonsociallinea").hide();
 		}
 	}, 500)


 });

/**************************************
 * End autocomplete linea maritima
 **************************************
 */


/**************************************
 * Funciones para realizar autocomplete agencia de aduanas
 **************************************
 */
 //Oculta la caja de texto que contiene el nombre del proveedor
 if($("#razonsocialaduana").val() == ""){
 	$("#razonsocialaduana").hide();
 }

 $( function() {
 	function split( val ) {
 		return val.split( /,\s*/ );
 	}
 	function extractLast( term ) {
 		return split( term ).pop();
 	}

 	$( "#emim_aduana" )
  // don't navigate away from the field on tab when selecting an item
  .on( "keydown", function( event ) {
  	if ( event.keyCode === $.ui.keyCode.TAB &&
  		$( this ).autocomplete( "instance" ).menu.active ) {
  		event.preventDefault();
  }
})
  .autocomplete({
  	source: function( request, response ) {
  		$.getJSON(  $( "#route1" ).val(), {
  			term: extractLast( request.term )
  		}, response );
  	},
  	search: function() {
        // custom minLength
        var term = extractLast( this.value );
        if ( term.length < 2 ) {
        	return false;
        }
    },
    focus: function() {
        // prevent value inserted on focus
        return false;
    },
    select: function( event, ui ) {
    	var terms = split( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( ", " );

        return false;
    }
});
} );

 //Acomoda la informacion en dos cajas de texto para que se visualize correctamente
 $("#emim_aduana").blur(function(){
 	$("#razonsocialaduana").show();
 	var info = $("#emim_aduana").val();
 	var fields = info.split(' -> ');
 	$("#emim_aduana").val(fields[0]);
 	$("#razonsocialaduana").val(fields[1]);

 	setTimeout(function(){
 		if($("#razonsocialaduana").val() == ""){
 			$("#emim_aduana").val("");
 			$("#razonsocialaduana").hide();
 		}
 	}, 500)


 });

/**************************************
 * End autocomplete linea maritima
 **************************************
 */

 /**************************************
 * Funciones para realizar autocomplete agencia de aduanas
 **************************************
 */
 //Oculta la caja de texto que contiene el nombre del proveedor+
 if($("#razonsocialtransportador").val() == ""){
 	$("#razonsocialtransportador").hide();
 }

 $( function() {
 	function split( val ) {
 		return val.split( /,\s*/ );
 	}
 	function extractLast( term ) {
 		return split( term ).pop();
 	}

 	$( "#emim_transportador" )
  // don't navigate away from the field on tab when selecting an item
  .on( "keydown", function( event ) {
  	if ( event.keyCode === $.ui.keyCode.TAB &&
  		$( this ).autocomplete( "instance" ).menu.active ) {
  		event.preventDefault();
  }
})
  .autocomplete({
  	source: function( request, response ) {
  		$.getJSON(  $( "#route1" ).val(), {
  			term: extractLast( request.term )
  		}, response );
  	},
  	search: function() {
        // custom minLength
        var term = extractLast( this.value );
        if ( term.length < 2 ) {
        	return false;
        }
    },
    focus: function() {
        // prevent value inserted on focus
        return false;
    },
    select: function( event, ui ) {
    	var terms = split( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( ", " );

        return false;
    }
});
} );

 //Acomoda la informacion en dos cajas de texto para que se visualize  correctamente
 $("#emim_transportador").blur(function(){
 	$("#razonsocialtransportador").show();
 	var info = $("#emim_transportador").val();
 	var fields = info.split(' -> ');
 	$("#emim_transportador").val(fields[0]);
 	$("#razonsocialtransportador").val(fields[1]);

 	setTimeout(function(){
 		if($("#razonsocialtransportador").val() == ""){
 			$("#emim_transportador").val("");
 			$("#razonsocialtransportador").hide();
 		}
 	}, 500)


 });

/**************************************
 * End autocomplete linea maritima
 **************************************
 */
});



//Agrega una proforma a la tabla
function autocompletecontenedor(obj){
	if($('#tipoContenedor').val() == "" || $('#cantidad').val() == "" || $('#numeroImportacion').val() == "" || $('#cubicaje').val() == "" || $('#peso').val() == ""){
		alert('Favor diligenciar toda la informacion del contenedor');
	}else{
  //Agrega la proforma a la tabla
  var $this = $(obj);
  var tabla = $('#tablaContenedorGuardar').val();
  if(tabla == ""){
  	var id1 = document.getElementById('tablaContenedor').rows.length;
  }else{
  	var id1 = ++tabla;
  }
  var json = $('#infoTipoContenedor').val();
  var jsonParce = JSON.parse(json);
  var borrar = '<td><span class="borrar glyphicon glyphicon-remove"><input type="hidden" name="'+ id1 +'-idproforma" value=""></span></td>';
  var tipoContenedor = '<td class="campos" id="'+ id1 +'-tipocont">'+jsonParce[$('#tipoContenedor').val()]+'<input type="hidden" name="'+ id1 +'-tipocont" value='+$('#tipoContenedor').val()+'></td>';
  var cantidad = '<td class="campos" id="'+ id1 +'-cantidad">'+$('#cantidad').val()+'<input type="hidden" name="'+ id1 +'-cantidad" value='+$('#cantidad').val()+'></td>';
  var numeroImportacion = '<td class="campos" id="'+ id1 +'-numeroImportacion">'+$('#numeroImportacion').val()+'<input type="hidden" name="'+ id1 +'-numeroImportacion" value='+$('#numeroImportacion').val()+'></td>';
  var cubicaje = '<td class="campos" id="'+ id1 +'-cubicaje">'+$('#cubicaje').val()+'<input type="hidden" name="'+ id1 +'-cubicaje" value='+$('#cubicaje').val()+'></td>';
  var peso = '<td class="campos" id="'+ id1 +'-peso">'+$('#peso').val()+'<input type="hidden" name="'+ id1 +'-peso" value='+$('#peso').val()+'></td>';
  
  $('#agregar').append('<tr>'+tipoContenedor+cantidad+numeroImportacion+cubicaje+peso+borrar+'</tr>');
  $('#tablaContenedorGuardar').val(id1);
  $('#ocultar1').show();
  $('#tipoContenedor').val("");
  $('#cantidad').val("");
  $('#numeroImportacion').val("");
  $('#cubicaje').val("");
  $('#peso').val("");
  $('#tipoContenedor').focus();

}


}

function cubiValida(obj){
	if ($(obj).val() == ""){
		$('#error_cubicaje').html('Favor ingresar el cubicaje');
		$('#cubicaje_div').addClass('has-error');
	}else if ($(obj).val() != ""){
		$('#error_cubicaje').html('');
		$('#cubicaje_div').removeClass('has-error');
		$('#cubicaje_div').addClass('has-success');
	}
}

function pesoValida(obj){	
	if ($(obj).val() == ""){
		$('#error_peso').html('Favor ingresar el peso');
		$('#peso_div').addClass('has-error');
	}else if ($(obj).val() != ""){
		$('#error_peso').html('');
		$('#peso_div').removeClass('has-error');
		$('#peso_div').addClass('has-success');
	}
}

function cajaValida(obj){	
	if ($(obj).val() == ""){
		$('#error_cajas').html('Favor ingresar el numero de cajas');
		$('#cajas_div').addClass('has-error');
	}else if ($(obj).val() != ""){
		$('#error_cajas').html('');
		$('#cajas_div').removeClass('has-error');
		$('#cajas_div').addClass('has-success');
	}
}

function fcl(){
	if($('#emim_tipo_carga').val() == 3){
		$('#formTipocarga').html("");
		$('#formTipocarga').show();	
		$('#ocultar1').hide();	
		comboTipoContenedor = "";
		var json = $('#infoTipoContenedor').val();
		var jsonParce = JSON.parse(json);
		comboTipoContenedor += "<select id='tipoContenedor' class='form-control'>";
		comboTipoContenedor += "<option value=''>Seleccione un tipo de contenedor</option>";


		for(var key in jsonParce){
			comboTipoContenedor += "<option value=" + key  + ">" +jsonParce[key] + "</option>";
		}
		comboTipoContenedor += "</select>";
		var labelTipoContenedor = "<label  class='control-label'>Tipo Contenedor: (*)</label>";
		var labelCantidad = "<label  class='control-label'>Cantidad de cajas: (*)</label>";
		var labelNumeroImportacion = "<label  class='control-label'>No. Contenedor: (*)</label>";
		var labelCubicaje = "<label  class='control-label'>Cubicaje: (*)</label>";
		var labelPeso = "<label  class='control-label'>Peso: (*)</label>";
		var TipoContenedor ="<div class='form-group col-sm-4'>"+labelTipoContenedor+comboTipoContenedor+"</div>";
		var Cantidad ="<div class='form-group col-sm-4'>"+labelCantidad+"<input type='text'  name='cantidad' id='cantidad'  class='form-control' placeholder='Favor ingresar la cantidad'></div>";
		var numeroImportacion = "<div class='form-group col-sm-4'>"+labelNumeroImportacion+"<input type='text'  name='numeroImportacion' id='numeroImportacion'  class='form-control' placeholder='Favor ingresar el numero de importacion'></div>";
		var cubicaje = "<div class='form-group col-sm-4'>"+labelCubicaje+"<input type='text' name='cubicaje' id='cubicaje' class='form-control' placeholder='Favor ingresar el cubicaje'></div>";
		var peso ="<div class='form-group col-sm-4'>"+labelPeso+"<input type='text'  name='peso' id='peso'  class='form-control' placeholder='Favor ingresar el peso'></div>";
		var boton ="<br><div class='form-group col-sm-4'>" + '<button type="button" class="btn btn-primary " id="load" onclick="autocompletecontenedor(this);">Agregar</button></div>';
		$('#formTipocarga').html('<div class="row">'+TipoContenedor+Cantidad+numeroImportacion+"</div><div class='row'>"+cubicaje+peso+boton+"</div>");
	}
}