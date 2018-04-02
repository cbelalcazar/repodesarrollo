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


  Route::group(['prefix' => 'tcc'], function () {
    Route::resource('tccws', 'tccws\tccwsController');
    Route::get('agrupaPedidosGetInfo', 'tccws\tccwsController@agrupaPedidosGetInfo');
    Route::post('obtenerPlano', 'tccws\tccwsController@getPlano');
    Route::post('unidadesLogisticas', 'tccws\tccwsController@getUnidadesLogisticas');
    Route::post('excluirDocumentos', 'tccws\tccwsController@excluirDocumentos');

    Route::resource('parametros', 'tccws\parametrostccController');
    Route::get('parametrosinfo', 'tccws\parametrostccController@getInfo');

    Route::resource('clientes', 'tccws\cliboomerangController');
    Route::get('clientesinfo', 'tccws\cliboomerangController@getInfo');

    Route::get('consultas', 'tccws\tccwsController@getConsultaRemesas');
    Route::get('consultasinfo', 'tccws\tccwsController@consultaRemesasGetInfo');
    Route::post('consultasbusqueda', 'tccws\tccwsController@consultaBusquedasGetInfo');
    Route::post('consultasfecha', 'tccws\tccwsController@consultaFechasGetInfo');

    Route::resource('ciudades', 'tccws\ciudadesController', ['except' => ['create', 'show', 'edit', 'destroy']]);
    Route::get('ciudadesinfo', 'tccws\ciudadesController@getInfo');

    Route::get('descargarInforme/{fechaInicial}/{fechaFinal}/{placaVehiculo}', 'tccws\tccwsController@descargarInforme')->name('descargarInforme');
  });

  	// Rutas de negociaciones 
	Route::group(['prefix' => 'negociaciones'], function () {
  		Route::resource('solicitudNegociaciones', 'negociaciones\solicitudController');
  		Route::get('solicitudNegoGetInfo', 'negociaciones\solicitudController@solicitudGetInfo');      
      Route::post('calcularObjetivos', 'negociaciones\solicitudController@calcularObjetivos');
      
      //Rutas de Catalogos
      Route::resource('clasenegociacion', 'negociaciones\claseNegociacionController', ['except' => ['create', 'show', 'edit']]);
      Route::get('clasenegociacionInfo', 'negociaciones\claseNegociacionController@getInfo');
      Route::resource('negoanoanterior', 'negociaciones\negociacionAnteriorController', ['except' => ['create', 'show', 'edit']]);
      Route::get('negoanoanteriorInfo', 'negociaciones\negociacionAnteriorController@getInfo');
      Route::resource('tiponegociacion', 'negociaciones\tipoNegociacionController', ['except' => ['create', 'show', 'edit']]);
      Route::get('tiponegociacionInfo', 'negociaciones\tipoNegociacionController@getInfo');

      //Rutas de mis Solicitudes
      Route::resource('misSolicitudesNegociaciones', 'negociaciones\misSolicitudesController');
      Route::get('misSolicitudesNegoInfo', 'negociaciones\misSolicitudesController@getInfo');
      Route::post('misSolicitudesPeriEje', 'negociaciones\misSolicitudesController@updatePeriEje');
      Route::post('misSolicitudesConfirBono', 'negociaciones\misSolicitudesController@confirmarBono');
      Route::get('imprimirActa', 'negociaciones\misSolicitudesController@imprimirActa')->name('imprimirActa');
      Route::post('saveActas', 'negociaciones\misSolicitudesController@saveActas')->name('saveActas');
      Route::post('saveFotos', 'negociaciones\misSolicitudesController@saveFotos')->name('saveFotos');

      Route::resource('nivelesAutorizacionNegociacion', 'negociaciones\NivelesAutorizacionController', ['except' => ['create','edit', 'show']]);
      Route::get('infoAutorizacionNego', 'negociaciones\NivelesAutorizacionController@getInfo');

      // Bandeja de aprobacion 
      Route::resource('bandejaAprobacionNegociacion', 'negociaciones\bandejaAprobacionController', ['except' => ['create','edit', 'show']]);
      Route::get('bandejaNegoGetInfo', 'negociaciones\bandejaAprobacionController@getInfo');
      Route::post('bandejaAprobacionRechazarNego', 'negociaciones\bandejaAprobacionController@rechazar');
	});


});
