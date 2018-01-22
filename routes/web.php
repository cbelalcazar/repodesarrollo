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

  	// Rutas de negociaciones 
	Route::group(['prefix' => 'negociaciones'], function () {
  		Route::resource('solicitud', 'negociaciones\solicitudController');
  		Route::get('solicitudGetInfo', 'negociaciones\solicitudController@solicitudGetInfo');      
      Route::post('calcularObjetivos', 'negociaciones\solicitudController@calcularObjetivos');
      
      //Rutas de Catalogos
      Route::resource('clasenegociacion', 'negociaciones\claseNegociacionController', ['except' => ['create', 'show', 'edit']]);
      Route::get('clasenegociacionInfo', 'negociaciones\claseNegociacionController@getInfo');
      Route::resource('negoanoanterior', 'negociaciones\negociacionAnteriorController', ['except' => ['create', 'show', 'edit']]);
      Route::get('negoanoanteriorInfo', 'negociaciones\negociacionAnteriorController@getInfo');
      Route::resource('tiponegociacion', 'negociaciones\tipoNegociacionController', ['except' => ['create', 'show', 'edit']]);
      Route::get('tiponegociacionInfo', 'negociaciones\tipoNegociacionController@getInfo');

      //Rutas de mis Solicitudes
      Route::resource('misSolicitudes', 'negociaciones\misSolicitudesController');
      Route::get('misSolicitudesInfo', 'negociaciones\misSolicitudesController@getInfo');
      Route::post('misSolicitudesPeriEje', 'negociaciones\misSolicitudesController@updatePeriEje');
      Route::post('misSolicitudesConfirBono', 'negociaciones\misSolicitudesController@confirmarBono');
	});


});
