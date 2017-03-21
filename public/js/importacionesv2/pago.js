jQuery(document).ready(function($) {


  $('#naco_factor_arancel_porc').focusin(function(event) {
    if($('#naco_factor_dolar_tasa').val() == ""){
      alert("Debes ingresar el factor total para realizar el calculo del factor arancel");
      $('#naco_factor_dolar_tasa').focus();
    }else if($('#naco_factor_logist_tasa').val() == ""){
      alert("Debes ingresar el factor logistico para realizar el calculo del factor arancel");
      $('#naco_factor_logist_tasa').focus();
    }else if($('#naco_factor_logist_tasa').val() > $('#naco_factor_dolar_tasa').val()){
      $('#naco_factor_logist_tasa').val("");
      $('#naco_factor_logist_tasa').focus();
      alert('El factor logistico debe ser menor al factor total');

    }else if($('#naco_factor_logist_tasa').val() < $('#naco_factor_dolar_tasa').val()){
      $('#naco_factor_arancel_porc').val($('#naco_factor_dolar_tasa').val() - $('#naco_factor_logist_tasa').val());
    }
    else{
      $('#naco_factor_logist_tasa').focus();
    }


  });
	//Valida los campos cuando pierden el foco
	$('#ocultar3').hide();

	 $('#showRadios').click(function(event) {
    if($('#showRadios').prop('checked'))
    {
      $('.radios1').removeClass('hide');
    }else{
      $('.radios1').addClass('hide');
      $('#sobrante').prop('checked', false);
      $('#faltante').prop('checked', false);
      $('#naco_valorseleccion').val("");
      $('#naco_valorseleccion_euro').val("");
      $('.cajas1').addClass('hide');
    }
    
  });
  $('#sobrante').click(function(event) {
    $('.cajas1').removeClass('hide');
  });
  $('#faltante').click(function(event) {
    $('.cajas1').removeClass('hide');
  });

//Quitar filas de la tabla 
$(document).on('click', '.borrar', function (event) {
	event.preventDefault();
	$(this).closest('tr').remove();
	if(document.getElementById('tabladeclaracion').rows.length == 1){  	
		$('#ocultar3').hide();
		$('#tabladeclaracionguardar').val("");	

	}
});

$('.validemosText').blur(function(event) {
	if($(this).val() == ""){
		$(this).parent().addClass('has-error');
		$(this).siblings("#error").html('Este campo es obligatorio (*)');
	}else if($(this).val() != ""){
		$(this).parent().removeClass('has-error').addClass('has-success');
		$(this).siblings("#error").html('');
	}
});	
	//valida el campo cuando cambia, usado para fechas
	$('.validemosDate').change(function(event) {
		if($(this).val() == ""){
			$(this).parent().addClass('has-error');
			$(this).siblings("#error").html('Este campo es obligatorio (*)');
		}else if($(this).val() != ""){
			$(this).parent().removeClass('has-error').addClass('has-success');
			$(this).siblings("#error").html('');
		}
	});	
	$('.datepickerClass').datepicker();

	//Valida nuevamente todos los campos antes de hacer submit
	$('#importacionform').submit(function(event) {
		var objetos = $('.validemosText');
		var submit = 0;
		for (var i = objetos.length - 1; i >= 0; i--) {
			if($("#"+objetos[i].id).val() == ""){
				$("#"+objetos[i].id).parent().addClass('has-error');
				$("#"+objetos[i].id).siblings("#error").html('Este campo es obligatorio (*)');
				submit = 1;
			}else if($("#"+objetos[i].id).val() != ""){
				$("#"+objetos[i].id).parent().removeClass('has-error').addClass('has-success');
				$("#"+objetos[i].id).siblings("#error").html('');
			}
		}
		
		if(submit == 1){
			return false;
		}else if(submit == 0){
			return true;
		}

		
	});



});






//Agrega una proforma a la tabla
function tabladeclaracion(obj){
  //Valida que no exista una proforma con el mismo numero asociada a esta importacion
  var tablaconteo = $('#tabladeclaracionguardar').val();
  if(tablaconteo == ""){
  	var conteo = document.getElementById('tabladeclaracion').rows.length;
  }else{
  	var conteo = tablaconteo+1;
  }
  var encontrar = 0;
  for (var i = 1; i < conteo; i++)
  {
    var string = "#"+ i + "-decl_numero";
    var dato = $(string).html();
    if(typeof(dato) !== 'undefined'){
      var dato1 = dato.split('<input');
      if(dato1[0] == $('#decl_numero').val()){
        encontrar = 1;
      }
    }

  }

//Valido que los campos tengan informacion diligenciada
if($('#decl_numero').val() == "" || $('#decl_sticker').val() == "" || $('#decl_arancel').val() == "" || $('#decl_iva').val() == ""|| $('#decl_valor_otros').val() == ""|| $('#decl_trm').val() == ""|| $('#decl_tipo_levante').val() == ""|| $('#decl_admin_dian').val() == ""|| $('#decl_fecha_aceptacion').val() == ""|| $('#decl_fecha_levante').val() == ""|| $('#decl_fecha_legaliza_giro').val() == ""){
	alert('Favor diligenciar toda la informacion de la declaracion de importacion');
}else if(encontrar == 1){
	alert('la declaracion de importacion ingresada ya fue digitada');
	$('#decl_numero').val() = "";
	$('#decl_sticker').val() = "";
	$('#decl_arancel').val() = "";
	$('#decl_iva').val() = "";
	$('#decl_valor_otros').val() = "";
	$('#decl_trm').val() = "";
	$('#decl_tipo_levante').val() = "";
	$('#decl_admin_dian').val() = "";
	$('#decl_fecha_aceptacion').val() = "";
	$('#decl_fecha_levante').val() = "";
	$('#decl_fecha_legaliza_giro').val() = "";
}else{
  //Agrega la proforma a la tabla
  var $this = $(obj);
  $this.button('loading');
  var bandera = false;
  var tabla = $('#tabladeclaracionguardar').val();
  if(tabla == ""){
  	var id1 = document.getElementById('tabladeclaracion').rows.length;
  	bandera = true;
  }else{
  	var id1 = ++tabla;
  }
  var borrar = '<td><span class="borrar glyphicon glyphicon-remove"><input type="hidden" name="'+ id1 +'-iddeclaracion" value=""></span></td>';
  var decl_numero = '<td class="campos" id="'+ id1 +'-decl_numero">'+$('#decl_numero').val()+'<input type="hidden" name="'+ id1 +'-decl_numero" value='+$('#decl_numero').val()+'></td>';
  var decl_sticker = '<td>'+$('#decl_sticker').val()+'<input type="hidden" name="'+ id1 +'-decl_sticker" value='+$('#decl_sticker').val()+'></td>';
  var decl_arancel = '<td>'+$('#decl_arancel').val()+'<input type="hidden" name="'+ id1 +'-decl_arancel" value='+$('#decl_arancel').val()+'></td>';
  var decl_iva = '<td>'+$('#decl_iva').val()+'<input type="hidden" name="'+ id1 +'-decl_iva" value='+$('#decl_iva').val()+'></td>';
  var decl_valor_otros = '<td>'+$('#decl_valor_otros').val()+'<input type="hidden" name="'+ id1 +'-decl_valor_otros" value='+$('#decl_valor_otros').val()+'></td>';
  var decl_trm = '<td>'+$('#decl_trm').val()+'<input type="hidden" name="'+ id1 +'-decl_trm" value='+$('#decl_trm').val()+'></td>';
  var decl_tipo_levante = '<td>'+$('#decl_tipo_levante option:selected').html()+'<input type="hidden" name="'+ id1 +'-decl_tipo_levante" value='+$('#decl_tipo_levante').val()+'></td>';
  var decl_admin_dian = '<td>'+$('#decl_admin_dian option:selected').html()+'<input type="hidden" name="'+ id1 +'-decl_admin_dian" value='+$('#decl_admin_dian').val()+'></td>';
  var decl_fecha_aceptacion = '<td>'+$('#decl_fecha_aceptacion').val()+'<input type="hidden" name="'+ id1 +'-decl_fecha_aceptacion" value='+$('#decl_fecha_aceptacion').val()+'></td>';
  var decl_fecha_levante = '<td>'+$('#decl_fecha_levante').val()+'<input type="hidden" name="'+ id1 +'-decl_fecha_levante" value='+$('#decl_fecha_levante').val()+'></td>';
  var decl_fecha_legaliza_giro = '<td>'+$('#decl_fecha_legaliza_giro').val()+'<input type="hidden" name="'+ id1 +'-decl_fecha_legaliza_giro" value='+$('#decl_fecha_legaliza_giro').val()+'></td>';

  $('#añadir2').append('<tr>'+decl_numero+decl_sticker+decl_arancel+decl_iva+decl_valor_otros+decl_trm+decl_tipo_levante+decl_admin_dian+decl_fecha_aceptacion+decl_fecha_levante+decl_fecha_legaliza_giro+borrar+'</tr>');
   if (bandera) {
  }
  $('#tabladeclaracionguardar').val(id1);
  $this.button('reset');  
  $('#ocultar3').show();
  $('#decl_numero').val("");
  $('#decl_sticker').val("");
  $('#decl_arancel').val("") ;
  $('#decl_iva').val("");
  $('#decl_valor_otros').val("");
  $('#decl_trm').val("");
  $('#decl_tipo_levante').val("");
  $('#decl_admin_dian').val("");
  $('#decl_fecha_aceptacion').val("");
  $('#decl_fecha_levante').val("");
  $('#decl_fecha_legaliza_giro').val("");
  $('#decl_numero').focus();


}
}