
/**************************************
 * Funciones para realizar autocomplete embarcador
 **************************************
 */
 //Oculta la caja de texto que contiene el nombre del proveedor
 if ($("#razonsocialtran_embarcador").val() == "") {$("#razonsocialtran_embarcador").hide();}
 

 $( function() {
 	function split( val ) {
 		return val.split( /,\s*/ );
 	}
 	function extractLast( term ) {
 		return split( term ).pop();
 	}

 	$( "#tran_embarcador" )
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
 $("#tran_embarcador").blur(function(){
 	$("#razonsocialtran_embarcador").show();
 	var info = $("#tran_embarcador").val();
 	var fields = info.split(' -> ');
 	$("#tran_embarcador").val(fields[0]);
 	$("#razonsocialtran_embarcador").val(fields[1]);

 	setTimeout(function(){
 		if($("#razonsocialtran_embarcador").val() == ""){
 			$("#tran_embarcador").val("");
 			$("#razonsocialtran_embarcador").hide();
 		}
 	}, 500)


 });

/**************************************
 * End autocomplete embarcador
 **************************************
 */



/**************************************
 * Funciones para realizar autocomplete embarcador
 **************************************
 */
 //Oculta la caja de texto que contiene el nombre del proveedor
 $("#razonsocialtran_linea_maritima").hide();

 $( function() {
  function split( val ) {
    return val.split( /,\s*/ );
  }
  function extractLast( term ) {
    return split( term ).pop();
  }

  $( "#tran_linea_maritima" )
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
 $("#tran_linea_maritima").blur(function(){
  $("#razonsocialtran_linea_maritima").show();
  var info = $("#tran_linea_maritima").val();
  var fields = info.split(' -> ');
  $("#tran_linea_maritima").val(fields[0]);
  $("#razonsocialtran_linea_maritima").val(fields[1]);

  setTimeout(function(){
    if($("#razonsocialtran_linea_maritima").val() == ""){
      $("#tran_linea_maritima").val("");
      $("#razonsocialtran_linea_maritima").hide();
    }
  }, 500)


 });

/**************************************
 * End autocomplete embarcador
 **************************************
 */

