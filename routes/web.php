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
  Route::resource('importacionesv2/OrigenMercancia', 'Importacionesv2\TOrigenMercanciaController');
  Route::resource('importacionesv2/PuertoEmbarque', 'Importacionesv2\TPuertoEmbarqueController');
  Route::resource('importacionesv2/TipoImportacion', 'Importacionesv2\TTipoImportacionController');
  Route::resource('importacionesv2/TipoLevante', 'Importacionesv2\TTipoLevanteController');
  Route::resource('importacionesv2/Metrica', 'Importacionesv2\TMetricaController');
  Route::resource('importacionesv2/CausalesDemora', 'Importacionesv2\TCausalesDemoraController');
  Route::resource('importacionesv2/Inconterm', 'Importacionesv2\TIcontermController');
  Route::resource('importacionesv2/TipoCarga', 'Importacionesv2\TTipoCargaController');
  Route::resource('importacionesv2/TipoContenedor', 'Importacionesv2\TTipoContenedorController');
  Route::resource('importacionesv2/Producto', 'Importacionesv2\TProductoController');
  //Rutas para proceso de importacion 
  Route::resource('importacionesv2/Importacion', 'Importacionesv2\TImportacionController');
  Route::get('importacionesv2/search', 'Importacionesv2\TImportacionController@autocomplete')->name('search');
  Route::get('importacionesv2/searchProducto', 'Importacionesv2\TImportacionController@autocompleteProducto')->name('searchProducto');
  Route::get('importacionesv2/Puertoajax', 'Importacionesv2\TPuertoEmbarqueController@Puertoajax')->name('createpuertoajax');
  Route::post('importacionesv2/StoreAjaxPuerto', 'Importacionesv2\TPuertoEmbarqueController@storeAjax')->name('storeajaxpuerto');
  Route::get('importacionesv2/Incontermajax', 'Importacionesv2\TIcontermController@Incontermajax')->name('createincontermajax');
  Route::post('importacionesv2/StoreAjaxInconterm', 'Importacionesv2\TIcontermController@storeAjax')->name('storeajaxinconterm');
  Route::get('importacionesv2/ProductoAjax', 'Importacionesv2\TProductoController@Productoajax')->name('createproductoajax');
    Route::post('importacionesv2/StoreAjaxProducto', 'Importacionesv2\TProductoController@storeAjax')->name('storeajaxproducto');
  Route::get('importacionesv2/ConsultaFiltros', 'Importacionesv2\TImportacionController@consultaFiltrada')->name('consultaFiltros');
  Route::get('importacionesv2/BorrarProductoImportacion', 'Importacionesv2\TImportacionController@borrar')->name('borrarProductoImportacion');
  Route::get('importacionesv2/BorrarProformaImportacion', 'Importacionesv2\TImportacionController@borrarProforma')->name('borrarProformaImportacion');
  Route::get('importacionesv2/AlertasImportacion', 'Importacionesv2\TImportacionController@alertasImportacion')->name('consultaAlertas');
  //Rutas para proceso de embarque de importacion 
  Route::resource('importacionesv2/Embarque', 'Importacionesv2\TEmbarqueImportacionController');
  Route::get('importacionesv2/CreateEmbarque1/{id}', 'Importacionesv2\TEmbarqueImportacionController@create')->name('createEmbarque1');
   //Rutas para proceso de pagos de importacion 
  Route::resource('importacionesv2/Pagos', 'Importacionesv2\TPagoImportacionController');  
  Route::get('importacionesv2/PagosCreate/{id}', 'Importacionesv2\TPagoImportacionController@create')->name('createPagos');
   //Rutas para proceso de nacionalizacion y costeo de importacion 
  Route::resource('importacionesv2/NacionalizacionCosteo', 'Importacionesv2\TNacionalizacionImportacionController');  
  Route::get('importacionesv2/NCCreate/{id}', 'Importacionesv2\TNacionalizacionImportacionController@create')->name('createNC');
  //End importacionesv2

});
