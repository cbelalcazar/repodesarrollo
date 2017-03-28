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

Route::group(['middleware' => ['auth']], function () {
  Route::get('/', function () {
    return redirect('login');
  });

  Route::get('home', function () {
    return redirect(env('APPV1_URL'));
  });


/*
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * Rutas para el aplicativo importacionesv2
 * 22/02/2017
*/
Route::group(array('prefix' => 'importacionesv2', 'middleware' => []), function () {

Route::resource('OrigenMercancia', 'Importacionesv2\TOrigenMercanciaController');
Route::resource('PuertoEmbarque', 'Importacionesv2\TPuertoEmbarqueController');
Route::resource('TipoImportacion', 'Importacionesv2\TTipoImportacionController');
Route::resource('TipoLevante', 'Importacionesv2\TTipoLevanteController');
Route::resource('Metrica', 'Importacionesv2\TMetricaController');
Route::resource('CausalesDemora', 'Importacionesv2\TCausalesDemoraController');
Route::resource('Inconterm', 'Importacionesv2\TIcontermController');
Route::resource('TipoCarga', 'Importacionesv2\TTipoCargaController');
Route::resource('TipoContenedor', 'Importacionesv2\TTipoContenedorController');
Route::resource('Producto', 'Importacionesv2\TProductoController');
Route::resource('TiemposTransito', 'Importacionesv2\TTiemposTransitoController');
Route::resource('ProductoImportacion', 'Importacionesv2\TProductoImportacionController');
Route::resource('LineaMaritima', 'Importacionesv2\TLineaMaritimaController');
  //Rutas para proceso de importacion 
Route::resource('Importacion', 'Importacionesv2\TImportacionController');
Route::get('search', 'Importacionesv2\TImportacionController@autocomplete')->name('search');
Route::post('cerrarOrden', 'Importacionesv2\TImportacionController@cerrarOrden')->name('cerrarImportacion');
Route::get('searchProducto', 'Importacionesv2\TImportacionController@autocompleteProducto')->name('searchProducto');
Route::get('Puertoajax', 'Importacionesv2\TPuertoEmbarqueController@Puertoajax')->name('createpuertoajax');
Route::post('StoreAjaxPuerto', 'Importacionesv2\TPuertoEmbarqueController@storeAjax')->name('storeajaxpuerto');
Route::get('Incontermajax', 'Importacionesv2\TIcontermController@Incontermajax')->name('createincontermajax');
Route::post('StoreAjaxInconterm', 'Importacionesv2\TIcontermController@storeAjax')->name('storeajaxinconterm');
Route::get('ProductoAjax', 'Importacionesv2\TProductoController@Productoajax')->name('createproductoajax');
Route::post('StoreAjaxProducto', 'Importacionesv2\TProductoController@storeAjax')->name('storeajaxproducto');
Route::get('ConsultaFiltros', 'Importacionesv2\TImportacionController@consultaFiltrada')->name('consultaFiltros');
Route::get('BorrarProductoImportacion', 'Importacionesv2\TImportacionController@borrar')->name('borrarProductoImportacion');
Route::get('BorrarProformaImportacion', 'Importacionesv2\TImportacionController@borrarProforma')->name('borrarProformaImportacion');
Route::get('AlertasImportacion', 'Importacionesv2\TImportacionController@alertasImportacion')->name('consultaAlertas');
  //Rutas para proceso de embarque de importacion 
Route::resource('Embarque', 'Importacionesv2\TEmbarqueImportacionController');
Route::get('CreateEmbarque1/{id}', 'Importacionesv2\TEmbarqueImportacionController@create')->name('createEmbarque1');
   //Rutas para proceso de pagos de importacion 
Route::resource('Pagos', 'Importacionesv2\TPagoImportacionController');  
Route::get('PagosCreate/{id}', 'Importacionesv2\TPagoImportacionController@create')->name('createPagos');
   //Rutas para proceso de nacionalizacion y costeo de importacion 
Route::resource('NacionalizacionCosteo', 'Importacionesv2\TNacionalizacionImportacionController');  
Route::get('NCCreate/{id}', 'Importacionesv2\TNacionalizacionImportacionController@create')->name('createNC');
//End importacionesv2
//Rutas para reportes importacionesv2
Route::post('ExcelOrdenesGeneral', 'Importacionesv2\ReportesImportacionesController@ExcelOrdenesGeneral')->name('ExcelOrdenesGeneral');
Route::get('ConsultaImportacionesExportar', 'Importacionesv2\ReportesImportacionesController@ConsultaImportacionesExportar')->name('ConsultaImportacionesExportar');
});

});
