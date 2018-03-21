<?php
use Illuminate\Support\Facades\Auth;
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
Route::get('loginProv', ['uses' => 'Auth\LoginController@showLoginFormProv', 'as' => 'login']);
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
		dd(Auth::user());
		return redirect(env('APPV1_URL'));
	});

	Route::get('autocomplete', ['uses' => 'GenericasController@autocomplete', 'as' => 'autocomplete']);


	// Aplicativo Programacion, Recepcion y Evaluacion de proveedores
	// 08-09-2017
	// Carlos Andres Belalcazar Mendez
	// Analista Desarrollador de software 

	Route::group(['prefix' => 'recepcionProveedores'], function () {
		// Programacion ordenes 
		Route::resource('programacion', 'recepcionProveedores\ProgramacionController', ['only' => ['index', 'destroy', 'update', 'store']]);
		Route::get('programacionGetInfo', 'recepcionProveedores\ProgramacionController@programacionGetInfo');
		Route::post('referenciasPorOc', 'recepcionProveedores\ProgramacionController@referenciasPorOc');

		// Solicitud cita
		Route::resource('cita', 'recepcionProveedores\CitaController', ['only' => ['index', 'update', 'store']]);
		Route::get('citaGetInfo', 'recepcionProveedores\CitaController@citaGetInfo');		
		Route::get('indexVisualCitas', 'recepcionProveedores\CitaController@indexVisualCitas');	
		Route::post('consultaProg', 'recepcionProveedores\CitaController@consultaProg');

		// Tarea generar citas proveedores 
		Route::resource('tareaCitas', 'recepcionProveedores\tareaCitasController', ['only' => ['index']]);

		// Portal de proveedores para confirmar cita
		Route::resource('confirmarProveedor', 'recepcionProveedores\confirmarProveedorController');
		Route::get('confirmarProveedorGetInfo', 'recepcionProveedores\confirmarProveedorController@confirmarProveedorGetInfo');
		Route::post('rechazo', 'recepcionProveedores\confirmarProveedorController@rechazo');
		// Entrada WMS
		Route::resource('docEntradaAlmacen', 'recepcionProveedores\docEntradaAlmacenController');
		Route::get('docEntradaAlmacenGetInfo', 'recepcionProveedores\docEntradaAlmacenController@docEntradaAlmacenGetInfo');
		Route::post('formValidacionCiegoGetInfo', 'recepcionProveedores\docEntradaAlmacenController@formValidacionCiegoGetInfo');
		Route::post('guardarEntrada', 'recepcionProveedores\docEntradaAlmacenController@guardarEntrada');
		Route::post('generarProgramacion', 'recepcionProveedores\docEntradaAlmacenController@generarProgramacion');

		Route::resource('refProgramablesRecep', 'recepcionProveedores\RefProgramablesRecepController');		
		Route::get('getInfoRefeProgramRecep', 'recepcionProveedores\RefProgramablesRecepController@getInfo');
	});


});
