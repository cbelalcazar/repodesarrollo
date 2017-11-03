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
  Route::get('/', function () {
    return view('loginredirect');
  });

  Route::get('home', function () {
    return redirect(env('APPV1_URL'));
  });

  Route::get('autocomplete', ['uses' => 'GenericasController@autocomplete', 'as' => 'autocomplete']);

  // Aplicativo Control Inversion, Creado Oscar O
  Route::group(['prefix' => 'controlinversion'], function () {

    //solicitud de creacion de obsequios y muestras
  	Route::resource('solicitud','controlinversion\solicitudController');
  	Route::get('solicitudGetInfo','controlinversion\solicitudController@solicitudGetInfo');
    Route::get('solicitud/{id}/correcion','controlinversion\solicitudController@correciones')->name('solicitud.correcion');
    Route::get('consultarReferencia/{referencia}','controlinversion\solicitudController@consultarInformacionReferencia');
    Route::post('consultarReferencias','controlinversion\solicitudController@consultarInformacionReferencias');

    Route::get('misSolicitudes','controlinversion\solicitudController@misSolicitudes')->name('misSolicitudes');
    Route::get('getInfoMisolicitudes','controlinversion\solicitudController@getInfoMisolicitudes');

    //gestion catalogo de vendedores por zona
    Route::resource('vendedores','controlinversion\vendedorController');
    Route::get('vendedoresGetInfo','controlinversion\vendedorController@getInfo');

    // Rutas para niveles de aprobacion
    Route::resource('nivelesAutorizacion','controlinversion\nivelesAutorizacionController');
    Route::get('nivelesAutorizacionGetInfo','controlinversion\nivelesAutorizacionController@nivelesAutorizacionGetInfo');
 

  });


});
