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

  //Rutas para el proyecto de importacionesv2
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
});
