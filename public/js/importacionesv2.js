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


  $(document).ready(function()
  {
    $('#imp_fecha_entrega_total').datepicker();
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
    

  });
