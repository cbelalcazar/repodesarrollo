jQuery(document).ready(function($) {
	//Valida los campos cuando pierden el foco
	$('.validemosText').blur(function(event) {
		console.log($(this).val());
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