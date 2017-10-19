<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('login', ['uses' => 'Auth\LoginController@showLoginForm', 'as' => 'login']);
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);
Route::get('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'logout']);

Route::get('loginredirect', function () {
  return view('loginredirect');
});

Route::group(['middleware' => ['auth']], function () {
<<<<<<< HEAD
    Route::get('/', function () {
      return redirect('login');
    });
=======
  Route::get('/', function () {
    return view('loginredirect');
  });
>>>>>>> 92c4f77c2dd93b787a101365f680ed40d5185b76

    Route::get('home', function () {
      return redirect(env('APPV1_URL'));
    });
    Route::get('autocomplete', ['uses' => 'GenericasController@autocomplete', 'as' => 'autocomplete']);

<<<<<<< HEAD

    /**
     * Creado por Carlos Belalcazar
     * Analista desarrollador de software Belleza Express
     * Rutas para importacionesv2
     * 22/02/2017
    */
    Route::group(array('prefix' => 'importacionesv2', 'middleware' => []), function () {
        Route::resource('OrigenMercancia',          'Importacionesv2\TOrigenMercanciaController');
        Route::resource('PuertoEmbarque',           'Importacionesv2\TPuertoEmbarqueController');
        Route::resource('TipoImportacion',          'Importacionesv2\TTipoImportacionController');
        Route::resource('TipoLevante',              'Importacionesv2\TTipoLevanteController');
        Route::resource('Metrica',                  'Importacionesv2\TMetricaController');
        Route::resource('CausalesDemora',           'Importacionesv2\TCausalesDemoraController');
        Route::resource('Inconterm',                'Importacionesv2\TIcontermController');
        Route::resource('TipoCarga',                'Importacionesv2\TTipoCargaController');
        Route::resource('TipoContenedor',           'Importacionesv2\TTipoContenedorController');
        Route::resource('Producto',                 'Importacionesv2\TProductoController');
        Route::resource('TiemposTransito',          'Importacionesv2\TTiemposTransitoController');
        Route::resource('ProductoImportacion',      'Importacionesv2\TProductoImportacionController');
        Route::resource('LineaMaritima',            'Importacionesv2\TLineaMaritimaController');
        Route::resource('Importacion',              'Importacionesv2\TImportacionController');
        Route::resource('Embarque',                 'Importacionesv2\TEmbarqueImportacionController');
        Route::resource('Pagos',                    'Importacionesv2\TPagoImportacionController');  
        Route::resource('NacionalizacionCosteo',    'Importacionesv2\TNacionalizacionImportacionController'); 
        Route::get('search',                        'Importacionesv2\TImportacionController@autocomplete')->name('search');
        Route::post('cerrarOrden',                  'Importacionesv2\TImportacionController@cerrarOrden')->name('cerrarImportacion');
        Route::get('searchProducto',                'Importacionesv2\TImportacionController@autocompleteProducto')->name('searchProducto');
        Route::get('Puertoajax',                    'Importacionesv2\TPuertoEmbarqueController@Puertoajax')->name('createpuertoajax');
        Route::post('StoreAjaxPuerto',              'Importacionesv2\TPuertoEmbarqueController@storeAjax')->name('storeajaxpuerto');
        Route::get('Incontermajax',                 'Importacionesv2\TIcontermController@Incontermajax')->name('createincontermajax');
        Route::post('StoreAjaxInconterm',           'Importacionesv2\TIcontermController@storeAjax')->name('storeajaxinconterm');
        Route::get('ProductoAjax',                  'Importacionesv2\TProductoController@Productoajax')->name('createproductoajax');
        Route::post('StoreAjaxProducto',            'Importacionesv2\TProductoController@storeAjax')->name('storeajaxproducto');
        Route::get('ConsultaFiltros',               'Importacionesv2\TImportacionController@consultaFiltrada')->name('consultaFiltros');
        Route::post('BorrarProductoImportacion',    'Importacionesv2\TImportacionController@borrar')->name('borrarProductoImportacion');
        Route::get('BorrarProformaImportacion',     'Importacionesv2\TImportacionController@borrarProforma')->name('borrarProformaImportacion');
        Route::get('AlertasImportacion',            'Importacionesv2\TImportacionController@alertasImportacion')->name('consultaAlertas');
        Route::get('CreateEmbarque1/{id}',          'Importacionesv2\TEmbarqueImportacionController@create')->name('createEmbarque1');
        Route::get('PagosCreate/{id}',              'Importacionesv2\TPagoImportacionController@create')->name('createPagos'); 
        Route::get('NCCreate/{id}',                 'Importacionesv2\TNacionalizacionImportacionController@create')->name('createNC');
        Route::post('ExcelOrdenesGeneral',          'Importacionesv2\ReportesImportacionesController@ExcelOrdenesGeneral')->name('ExcelOrdenesGeneral');
        Route::get('GenerarExcelUAP',               'Importacionesv2\ReportesImportacionesController@GenerarExcelUAP')->name('GenerarExcelUAP');
        Route::post('ReporteUAP',                   'Importacionesv2\ReportesImportacionesController@ReporteUAP')->name('ReporteUAP');
        Route::get('GenerarReporteBimestral',               'Importacionesv2\ReportesImportacionesController@GenerarReporteBimestral')->name('GenerarReporteBimestral');
        Route::post('ReporteBimestral',                   'Importacionesv2\ReportesImportacionesController@ReporteBimestral')->name('ReporteBimestral');
        Route::get('ConsultaImportacionesExportar', 'Importacionesv2\ReportesImportacionesController@ConsultaImportacionesExportar')->name('ConsultaImportacionesExportar');
        Route::get('generarUml', 'Importacionesv2\ReportesImportacionesController@generarUml')->name('generarUml');
    });

=======
  Route::get('autocomplete', ['uses' => 'GenericasController@autocomplete', 'as' => 'autocomplete']);
  /**
   * Creado por Carlos Belalcazar
   * Analista desarrollador de software Belleza Express
   * Rutas para importacionesv2
   * 22/02/2017
  */
  Route::group(array('prefix' => 'importacionesv2', 'middleware' => []), function () {
    Route::resource('OrigenMercancia',          'Importacionesv2\TOrigenMercanciaController');
    Route::resource('PuertoEmbarque',           'Importacionesv2\TPuertoEmbarqueController');
    Route::resource('TipoImportacion',          'Importacionesv2\TTipoImportacionController');
    Route::resource('TipoLevante',              'Importacionesv2\TTipoLevanteController');
    Route::resource('Metrica',                  'Importacionesv2\TMetricaController');
    Route::resource('CausalesDemora',           'Importacionesv2\TCausalesDemoraController');
    Route::resource('Inconterm',                'Importacionesv2\TIcontermController');
    Route::resource('TipoCarga',                'Importacionesv2\TTipoCargaController');
    Route::resource('TipoContenedor',           'Importacionesv2\TTipoContenedorController');
    Route::resource('Producto',                 'Importacionesv2\TProductoController');
    Route::resource('TiemposTransito',          'Importacionesv2\TTiemposTransitoController');
    Route::resource('ProductoImportacion',      'Importacionesv2\TProductoImportacionController');
    Route::resource('LineaMaritima',            'Importacionesv2\TLineaMaritimaController');
    Route::resource('Importacion',              'Importacionesv2\TImportacionController');
    Route::resource('Embarque',                 'Importacionesv2\TEmbarqueImportacionController');
    Route::resource('Pagos',                    'Importacionesv2\TPagoImportacionController');
    Route::resource('NacionalizacionCosteo',    'Importacionesv2\TNacionalizacionImportacionController');
    Route::get('search',                        'Importacionesv2\TImportacionController@autocomplete')->name('search');
    Route::post('cerrarOrden',                  'Importacionesv2\TImportacionController@cerrarOrden')->name('cerrarImportacion');
    Route::get('searchProducto',                'Importacionesv2\TImportacionController@autocompleteProducto')->name('searchProducto');
    Route::get('Puertoajax',                    'Importacionesv2\TPuertoEmbarqueController@Puertoajax')->name('createpuertoajax');
    Route::post('StoreAjaxPuerto',              'Importacionesv2\TPuertoEmbarqueController@storeAjax')->name('storeajaxpuerto');
    Route::get('Incontermajax',                 'Importacionesv2\TIcontermController@Incontermajax')->name('createincontermajax');
    Route::post('StoreAjaxInconterm',           'Importacionesv2\TIcontermController@storeAjax')->name('storeajaxinconterm');
    Route::get('ProductoAjax',                  'Importacionesv2\TProductoController@Productoajax')->name('createproductoajax');
    Route::post('StoreAjaxProducto',            'Importacionesv2\TProductoController@storeAjax')->name('storeajaxproducto');
    Route::get('ConsultaFiltros',               'Importacionesv2\TImportacionController@consultaFiltrada')->name('consultaFiltros');
    Route::post('BorrarProductoImportacion',    'Importacionesv2\TImportacionController@borrar')->name('borrarProductoImportacion');
    Route::get('BorrarProformaImportacion',     'Importacionesv2\TImportacionController@borrarProforma')->name('borrarProformaImportacion');
    Route::get('AlertasImportacion',            'Importacionesv2\TImportacionController@alertasImportacion')->name('consultaAlertas');
    Route::get('CreateEmbarque1/{id}',          'Importacionesv2\TEmbarqueImportacionController@create')->name('createEmbarque1');
    Route::get('PagosCreate/{id}',              'Importacionesv2\TPagoImportacionController@create')->name('createPagos');
    Route::get('NCCreate/{id}',                 'Importacionesv2\TNacionalizacionImportacionController@create')->name('createNC');
    Route::post('ExcelOrdenesGeneral',          'Importacionesv2\ReportesImportacionesController@ExcelOrdenesGeneral')->name('ExcelOrdenesGeneral');
    Route::get('GenerarExcelUAP',               'Importacionesv2\ReportesImportacionesController@GenerarExcelUAP')->name('GenerarExcelUAP');
    Route::post('ReporteUAP',                   'Importacionesv2\ReportesImportacionesController@ReporteUAP')->name('ReporteUAP');
    Route::get('GenerarReporteBimestral',               'Importacionesv2\ReportesImportacionesController@GenerarReporteBimestral')->name('GenerarReporteBimestral');
    Route::post('ReporteBimestral',                   'Importacionesv2\ReportesImportacionesController@ReporteBimestral')->name('ReporteBimestral');
    Route::get('ConsultaImportacionesExportar', 'Importacionesv2\ReportesImportacionesController@ConsultaImportacionesExportar')->name('ConsultaImportacionesExportar');
  });
>>>>>>> 92c4f77c2dd93b787a101365f680ed40d5185b76
});
