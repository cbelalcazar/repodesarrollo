// Ajax para creacion de puertos de embarque sobre formulario crear importacion
function verModel(ruta){
  //Funcion que carga en un modal la un formulario de creacion
  $("#cargar").load(ruta);  
}



function storeajax(url, formulario){
  //Funcion para guardar la creacion realizada en el fomrulario modal
  

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
        $('#ocultar2').show();
        $('#añadir1').append('<tr><td class="campos" id="'+ id1 +'">'+res1+'<input type="hidden" name="'+ id1 +'" value='+res1+'></td><td id="'+ id1 +'-decl" >'+declaracion+'<input type="hidden" name="'+ id1 +'-decl"  value='+declaracion+'></td><td id="'+ id1 +'-reg">'+registro+'<input type="hidden" name="'+ id1 +'-reg"  value='+registro+'></td><td><span class="borrar glyphicon glyphicon-remove"></span></td></tr>');
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
 sessionStorage.setItem('tabla', '');
 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
 $('#ocultar2').hide();
 $('#ocultar3').hide();
 $('#imp_fecha_entrega_total').datepicker();
 $('#fech_crea_profor').datepicker();
 $('#fech_entreg_profor').datepicker();
 $("#razonSocialTercero").hide();
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


//javascript tabla

var $TABLE = $('#table');
var $BTN = $('#export-btn');
var $EXPORT = $('#export');

$('.table-add').click(function () {
  var idanterior = document.getElementsByName('imp_producto')[1].id;
  var idnuevo = parseInt(idanterior)+1;
  document.getElementById(idanterior).id = idnuevo;
  var $clone = $TABLE.find('tr.hide').clone(true).removeClass('hide table-line');
  $TABLE.find('table').append($clone);
});

$('.table-remove').click(function () {
  $(this).parents('tr').detach();
});

});

//end

function autocompleteprod(obj){
 var tablaconteo = $('#tablaGuardar').val();
 if(tablaconteo == ""){
  var conteo = document.getElementById('tablaProducto').rows.length;
}else{
  var conteo = tablaconteo+1;
}
var encontrar = 0;
for (var i = 1; i < conteo; i++)
{
  var string = "#"+ i;
  var dato = $(string).html();
  if(typeof(dato) !== 'undefined'){
    var arreglo3 = dato.split(" -- ");
    if(arreglo3[0] == $('#imp_producto').val()){
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
  var $this = $(obj);
  $this.button('loading');
  var url = document.getElementById('route2').value;
  var datos = $('#importacionform').serialize();
  var envio = $('#imp_producto').val();
  envio1 = envio.replace('+', '¬¬¬°°°');
  var info = datos+'&obj='+envio1;
  var posteo =  $.get(url,info,function(res){
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
        $('#añadir1').append('<tr><td class="campos" id="'+ id1 +'">'+res[0]+'<input type="hidden" name="'+ id1 +'" value='+res[0]+'></td><td id="'+ id1 +'-decl" >'+declaracion+'<input type="hidden" name="'+ id1 +'-decl"  value='+declaracion+'></td><td id="'+ id1 +'-reg">'+registro+'<input type="hidden" name="'+ id1 +'-reg"  value='+registro+'></td><td><span class="borrar glyphicon glyphicon-remove"></span></td></tr>');
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






function tablaproforma(obj){

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
    if(dato1[0] == $('#imp_proforma').val()){
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
  var $this = $(obj);
  $this.button('loading');
  var tabla = $('#tablaproformaguardar').val();
  if(tabla == ""){
    var id1 = document.getElementById('tablaproforma').rows.length;
  }else{
    var id1 = ++tabla;
  }
  var borrar = '<td><span class="borrar glyphicon glyphicon-remove"></span></td>';
  var noproforma = '<td class="campos" id="'+ id1 +'-prof">'+$('#imp_proforma').val()+'<input type="hidden" name="'+ id1 +'-noprof" value='+$('#imp_proforma').val()+'></td>';
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


