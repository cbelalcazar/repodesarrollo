/**
 * Javascript para proceso de importacionesv2
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */

//Ajax para creacion de puertos de embarque sobre formulario crear importacion
function verModel(ruta){
  //Funcion que carga en un modal la un formulario de creacion
  $("#cargar").load(ruta);  
}


//Funcion para guardar la creacion realizada en el fomrulario modal
function storeajax(url, formulario){
  //Ejecuta una funcion post hacia la url especificada para guardar el formulario
  //de creacion en el modal
  var posteo =  $.post(url,formulario,function(res){
    //success lo use para puertos de embarque y inconterm
    if(res[0]=="success"){
      alert('Operacion realizada exitosamente.');
      $(res[3]).append('<option selected value="' + res[1] +'">'+ res[2] +'</option>');
      $('#cerrarmodal').click();
    }
      //success1 lo use para los productos
      if(res[0]=="success1"){
        alert('Operacion realizada exitosamente.');
        var res1 =  $('#productoGuarda').val();
        var id1 =  $('#idguarda').val();
        if (res[3] == 1){
          var declaracion = "SI";
        }else if(res[3] == 0){
          var declaracion = "NO";
        } 
        if (res[4] == 1){
          var registro = "SI";
        }else if(res[4] == 0){
          var registro = "NO";
        } 
        //Una ves lo crea genera la fila de la tabla
        $('#ocultar2').show();
        $('#añadir1').append('<tr><td class="campos" id="'+ id1 +'">'+res1+'<input type="hidden" name="'+ id1 +'" value='+res1+'></td><td id="'+ id1 +'-decl" >'+declaracion+'<input type="hidden" name="'+ id1 +'-decl"  value='+declaracion+'></td><td id="'+ id1 +'-reg">'+registro+'<input type="hidden" name="'+ id1 +'-reg"  value='+registro+'></td><td><span class="borrar glyphicon glyphicon-remove"></span><input type="hidden" name="'+ id1 +'-idproducto" value=""></td></tr>');
        $('#tablaGuardar').val(id1);
        $('#cerrarmodal').click();
      }
    //Error compartido para todas las funciones
    if(res[0]=="error"){
      alert(res[1]);
    }
                }); 
}
//end

//Funciones para realizar autocomplete
$( function() {
  function split( val ) {
    return val.split( /,\s*/ );
  }
  function extractLast( term ) {
    return split( term ).pop();
  }

  $( "#proveedor" )
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

//end





//Javascript para hacer calendarios y otros eventos que se ejecutan al momento que carga la pagina
$(document).ready(function()
{
 //sessionStorage.setItem('tabla', '');
 //Funcion jquery para que una caja de texto no permita letras
 $('.solo-numero').keyup(function (){
  this.value = (this.value + '').replace(/[^0-9]/g, '');
});
 //Oculta la tabla productos y proformas
 $('#ocultar2').hide();
 $('#ocultar3').hide();
 //Pone el calendario a tres cajas de texto
 $('#imp_fecha_entrega_total').datepicker();
 $('#fech_crea_profor').datepicker();
 $('#fech_entreg_profor').datepicker();
 //Oculta la caja de texto que contiene el nombre del proveedor
 $("#razonSocialTercero").hide();
 //Funcion que se ejecuta cuando se pierde el foco del campo con id proveedor
 //Acomoda la informacion en dos cajas de texto para que se visualize mas correctamente
 $("#proveedor").blur(function(){
  $("#razonSocialTercero").show();
  var info = $("#proveedor").val();
  var fields = info.split(' -> ');
  $("#proveedor").val(fields[0]);
  $("#razonSocialTercero").val(fields[1]);

  setTimeout(function(){
    if($("#razonSocialTercero").val() == ""){
      $("#proveedor").val("");
      $("#razonSocialTercero").hide();
    }
  }, 500)


});

//Quitar filas de la tabla 
$(document).on('click', '.borrar', function (event) {
  event.preventDefault();
  $(this).closest('tr').remove();
});






  $('#my-select').multiSelect();
  $("#tabs").tabs ();
  $("#tabs").tabs ('disable', 1);
  $("#tabs").tabs ('disable', 2);
  $("#tabs").tabs ('disable', 3);
  $("#tabs").tabs ('disable', 4);


  //Validaciones al dar siguiente a la pagina 1 del menu
  $('#siguiente1').click(function() {
    var continuar = true;
    if ($('#imp_consecutivo').val() == ""){
      $('#error_imp_consecutivo').html('Favor ingresar consecutivo de importación');
      $('#imp_consecutivo-div').addClass('has-error');
      continuar = false;
    }
    if ($('#proveedor').val() == ""){
      $('#error_proveedor').html('Favor ingresar el proveedor');
      $('#proveedor-div').addClass('has-error');
      continuar = false;
    }
    if ($('#imp_puerto_embarque').val() == ""){
      $('#error_puerto').html('Favor ingresar el puerto de embarque');
      $('#puerto-div').addClass('has-error');
      continuar = false;
    }
    if ($('#imp_iconterm').val() == ""){
      $('#error_inconterm').html('Favor ingresar el inconterm');
      $('#inconterm-div').addClass('has-error');
      continuar = false;
    }
    if ($('#imp_moneda_negociacion').val() == ""){
      $('#error_moneda').html('Favor ingresar el inconterm');
      $('#moneda-div').addClass('has-error');
      continuar = false;
    }    
    if (continuar) {
      $("#tabs").tabs ();
      $("#tabs").tabs ('enable', 1);
      $('#menu2').click();
      $("#tabs").tabs ('disable', 0);
      $("#tabs").tabs ('disable', 2);
      $("#tabs").tabs ('disable', 3);
      $("#tabs").tabs ('disable', 4);
    }

  });
  //Validaciones basadas en eventos formulario pestaña 2

   //Validaciones al dar siguiente a la pagina 2 del menu
   $('#siguiente2').click(function() {
    var continuar = true;
    if ($('#my-select').val().length == 0){
      $('#error_origen').html('Favor ingresar el origen de la mercancia');
      $('#origen-div').addClass('has-error');
      continuar = false;
    }    
    if (continuar) {
      $("#tabs").tabs ('enable', 2);
      
      $("#tabs").tabs ('disable', 1);
      $('#menu3').click();
    }
  });
  //Validaciones basadas en eventos formulario pestaña 2

  //Boton atras tab 2
  $('#atras2').click(function() {
    $("#tabs").tabs ('enable', 0);
    $('#menu1').click();
    $("#tabs").tabs ('disable', 1);
  });
  //End Boton atras tab 2

   //Validaciones al dar siguiente a la pagina 3 del menu
   $('#siguiente3').click(function() {
    var continuar = true;
    if (document.getElementById('tablaProducto').rows.length == 1){
      $('#error_producto').html('Favor asociar minimo un producto a la importacion');
      $('#producto-div').addClass('has-error');
      continuar = false;
    }    
    if (continuar) {
      $("#tabs").tabs ();
      $("#tabs").tabs ('enable', 3);
      $('#menu4').click();
      $("#tabs").tabs ('disable', 2);
      $("#tabs").tabs ('disable', 1);
      $("#tabs").tabs ('disable', 0);
      $("#tabs").tabs ('disable', 4);


    }
  });

    //Boton atras tab 2
    $('#atras3').click(function() {
      $("#tabs").tabs ('enable', 1);
      $('#menu2').click();
      $("#tabs").tabs ('disable', 2);
    });
  //End Boton atras tab 2

    //Validaciones al dar siguiente a la pagina 3 del menu
    $('#siguiente4').click(function() {
      var continuar = true;
      if (document.getElementById('tablaproforma').rows.length == 1){
        $('#error_proforma').html('Favor asociar minimo una proforma a la importacion');
        $('#proforma-div').addClass('has-error');
        continuar = false;
      }    
      if (continuar) {
        $("#tabs").tabs ('enable', 4);
        $('#menu5').click();
        $("#tabs").tabs ('disable', 3);
      }
    });

   //Boton atras tab 2
   $('#atras4').click(function() {
    $("#tabs").tabs ('enable', 2);
    $('#menu3').click();
    $("#tabs").tabs ('disable', 4);
  });

     //Boton atras tab 2
     $('#atras5').click(function() {
      $("#tabs").tabs ('enable', 3);
      $('#menu4').click();
      $("#tabs").tabs ('disable', 4);
    });


  //Validaciones basadas en eventos formulario pestaña 3
  $('.validemos').blur(function() {

    if ($('#imp_consecutivo').val() == ""){
      $('#error_imp_consecutivo').html('Favor ingresar consecutivo de importación');
      $('#imp_consecutivo-div').addClass('has-error');
    }else if ($('#imp_consecutivo').val() != ""){
      $('#error_imp_consecutivo').html('');
      $('#imp_consecutivo-div').removeClass('has-error');
      $('#imp_consecutivo-div').addClass('has-success');
    }

    if ($('#proveedor').val() == ""){
      $('#error_proveedor').html('Favor ingresar el proveedor');
      $('#proveedor-div').addClass('has-error');
    }else if ($('#proveedor').val() != ""){
      $('#error_proveedor').html('');
      $('#proveedor-div').removeClass('has-error');
      $('#proveedor-div').addClass('has-success');
    }


    if ($('#imp_puerto_embarque').val() == ""){
      $('#error_puerto').html('Favor ingresar el puerto de embarque');
      $('#puerto-div').addClass('has-error');
    }else if ($('#imp_puerto_embarque').val() != ""){
      $('#error_puerto').html('');
      $('#puerto-div').removeClass('has-error');
      $('#puerto-div').addClass('has-success');
    }


    if ($('#imp_iconterm').val() == ""){
      $('#error_inconterm').html('Favor ingresar el inconterm');
      $('#inconterm-div').addClass('has-error');
    }else if ($('#imp_iconterm').val() != ""){
      $('#error_inconterm').html('');
      $('#inconterm-div').removeClass('has-error');
      $('#inconterm-div').addClass('has-success');
    }

    if ($('#imp_moneda_negociacion').val() == ""){
      $('#error_moneda').html('Favor ingresar el inconterm');
      $('#moneda-div').addClass('has-error');
    }else if ($('#imp_moneda_negociacion').val() != ""){
      $('#error_moneda').html('');
      $('#moneda-div').removeClass('has-error');
      $('#moneda-div').addClass('has-success');
    }

  });

  //End Validaciones basadas en eventos formulario pestaña 1





});

//end
//Funcion para el llenado de la tabla de productos
function autocompleteprod(obj){
 var tablaconteo = $('#tablaGuardar').val();
 //Validamos el tamaño de la lista
 if(tablaconteo == ""){
  var conteo = document.getElementById('tablaProducto').rows.length;
}else{
  var conteo = tablaconteo+1;
}
//Compara el registro que intenta agregar a la tabla con los ya existentes buscando uno igual
var encontrar = 0;
for (var i = 1; i < conteo; i++)
{
  var string = "#"+ i;
  var dato = $(string).html();
  if(typeof(dato) !== 'undefined'){
    var arreglo3 = dato.split(" -- ");
    if(arreglo3[0] == $('#imp_producto').val().toUpperCase()){
      encontrar = 1;
    }
  }
  
}
//Valido que los campos tengan informacion diligenciada
if($('#imp_producto').val() == ""){
  alert('Favor ingresar una referencia para realizar la consulta');
}else if(encontrar == 1){
  alert('El producto a importar ya fue ingresado anteriormente para esta importacion');
  $('#imp_producto').val("");
}else{
  //Realiza funcion post para consultar el producto en la base de datos
  var $this = $(obj);
  $this.button('loading');
  var url = document.getElementById('route2').value;
  var datos = $('#importacionform').serialize();
  var envio = $('#imp_producto').val();
  envio1 = envio.replace('+', '¬¬¬°°°');
  var info = datos+'&obj='+envio1;
  var posteo =  $.get(url,info,function(res){
    //Si no encuentra la referencia del producto en el erp genera este error
    if(res == 'error'){
      $('#imp_producto').val("");
      $('#imp_producto').focus();
      alert('La referencia ingresada no fue encontrada');
      $this.button('reset');
    }else{

      var tabla = $('#tablaGuardar').val();
      if(tabla == ""){
        var id1 = document.getElementById('tablaProducto').rows.length;
      }else{
        var id1 = ++tabla;
      }
      if (res[2] == '1') {
        //En caso de que el producto no exista en la bd local genera el modal para que 
        //el usuario especifique si requiere declaracion o registro de importacion
        $("#myModal").modal();
        $("#cargar").load($('#productoajax').val());  
        var str4 = res[0].split(" -- ");
        setTimeout(function(){
          $('#prod_referencia').val(str4[0]);
          $('#prod_referencia').attr("readonly","readonly");
          $('#imp_producto').val("");
          $this.button('reset');
          $('#productoGuarda').val("");
          $('#idguarda').val("");
          $('#productoGuarda').val(res[0]);
          $('#idguarda').val(id1);
        }, 1500)
      }else{
        //si lo encuentra genera la fila de la tabla
        if (res[1][0] == 1){
          var declaracion = "SI";
        }else if(res[1][0] == 0 ){
          var declaracion = "NO";
        } 
        if (res[1][1] == 1){
          var registro = "SI";
        }else if(res[1][1] == 0){
          var registro = "NO";
        } 
        $('#añadir1').append('<tr><td class="campos" id="'+ id1 +'">'+res[0]+'<input type="hidden" name="'+ id1 +'" value='+res[0]+'></td><td id="'+ id1 +'-decl" >'+declaracion+'<input type="hidden" name="'+ id1 +'-decl"  value='+declaracion+'></td><td id="'+ id1 +'-reg">'+registro+'<input type="hidden" name="'+ id1 +'-reg"  value='+registro+'></td><td><span class="borrar glyphicon glyphicon-remove"></span><input type="hidden" name="'+ id1 +'-idproducto" value=""></td></tr>');
        $('#tablaGuardar').val(id1);
        $this.button('reset');
        $('#ocultar2').show();
        $('#imp_producto').val("");
        $('#imp_producto').focus();
      }

      

    }

  }); 

}

}





//Agrega una proforma a la tabla
function tablaproforma(obj){
  //Valida que no exista una proforma con el mismo numero asociada a esta importacion
  var tablaconteo = $('#tablaproformaguardar').val();
  if(tablaconteo == ""){
    var conteo = document.getElementById('tablaproforma').rows.length;
  }else{
    var conteo = tablaconteo+1;
  }
  var encontrar = 0;
  for (var i = 1; i < conteo; i++)
  {
    var string = "#"+ i + "-prof";
    var dato = $(string).html();
    if(typeof(dato) !== 'undefined'){
      var dato1 = dato.split('<input');
      if(dato1[0] == $('#imp_proforma').val().toUpperCase()){
        encontrar = 1;
      }
    }

  }

//Valido que los campos tengan informacion diligenciada
if($('#imp_proforma').val() == "" || $('#fech_crea_profor').val() == "" || $('#fech_entreg_profor').val() == "" || $('#imp_proforma').val() == "" || $('#val_proforma').val() == ""){
  alert('Favor diligenciar toda la informacion de la proforma');
}else if(encontrar == 1){
  alert('la proforma ingresada ya fue digitada');
  $('#imp_proforma').val("");
  $('#fech_crea_profor').val("");
  $('#fech_entreg_profor').val("");
  $('#val_proforma').val("");
}else{
  //Agrega la proforma a la tabla
  var $this = $(obj);
  $this.button('loading');
  var tabla = $('#tablaproformaguardar').val();
  if(tabla == ""){
    var id1 = document.getElementById('tablaproforma').rows.length;
  }else{
    var id1 = ++tabla;
  }
  var borrar = '<td><span class="borrar glyphicon glyphicon-remove"><input type="hidden" name="'+ id1 +'-idproforma" value=""></span></td>';
  var noproforma = '<td class="campos" id="'+ id1 +'-prof">'+$('#imp_proforma').val().toUpperCase()+'<input type="hidden" name="'+ id1 +'-noprof" value='+$('#imp_proforma').val().toUpperCase()+'></td>';
  var fech_creacion = '<td>'+$('#fech_crea_profor').val()+'<input type="hidden" name="'+ id1 +'-creaprof" value='+$('#fech_crea_profor').val()+'></td>';
  var fech_entreg_profor = '<td>'+$('#fech_entreg_profor').val()+'<input type="hidden" name="'+ id1 +'-entregaprof" value='+$('#fech_entreg_profor').val()+'></td>';
  var val_proforma = '<td>'+$('#val_proforma').val()+'<input type="hidden" name="'+ id1 +'-valorprof" value='+$('#val_proforma').val()+'></td>';

  if($("#proforma_principal").is(':checked')) {  
    var principal_prof = '<td>SI<input type="hidden" name="'+ id1 +'-princprof" value=1></td>';

  } else {  
   var principal_prof = '<td>NO<input type="hidden" name="'+ id1 +'-princprof" value=0></td>';
 }  
 $('#añadir2').append('<tr>'+noproforma+fech_creacion+fech_entreg_profor+val_proforma+principal_prof+borrar+'</tr>');
 $('#tablaproformaguardar').val(id1);
 $this.button('reset');
 $('#ocultar3').show();
 $('#imp_proforma').val("");
 $('#fech_crea_profor').val("");
 $('#fech_entreg_profor').val("");
 $('#val_proforma').val("");
 $('#imp_proforma').focus();


}


}

//Funcion que ejecuta el ajax para borrar el producto de importacion cuando ya se encuentra creado
function borrarprodimp(obj){
  var urlBorrar = $('#urlborrar').val();
  var formulario =  $('#Formularioupdate1').serialize();
  var id = obj.id;
  var ordenimportacion = $('#identificador').val();
  var datos = formulario+'&obj='+id+'&identificador='+ordenimportacion;
  var posteo =  $.get(urlBorrar,datos,function(res){
    alert(res);
    if (res == "Producto borrado exitosamente") {

     event.preventDefault();
     $(obj).closest('tr').remove();
   }
 });



}

//Funcion que ejecuta el ajax para borrar la proforma importacion cuando ya se encuentra creado

function borrarproforma(obj){
  var urlBorrar = $('#urlborrarprof').val();
  var formulario =  $('#Formularioupdate1').serialize();
  var id = obj.id;
  var ordenimportacion = $('#identificador').val();
  var datos = formulario+'&obj='+id+'&identificador='+ordenimportacion;
  var posteo =  $.get(urlBorrar,datos,function(res){
    alert(res);
    if (res == "Proforma borrada exitosamente") {

     event.preventDefault();
     $(obj).closest('tr').remove();
   }
 });
}

