<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'Auth\LoginController@showLoginForm');
//login con el metodo POST es para el formulario de logeo de usuario
Route::post('login', 'Auth\LoginController@login');
//login con el metodo GET es para cuando caduca el tiempo de session de usuario y redirige a esta ruta
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/main', function () {
    return view('layouts.admin');
})->name('main'); //Alias de la ruta


Route::get('resultadosTotales', 'GraficasController@resultadosTotales');
Route::resource('partido','PartidoController');
Route::resource('candidato','CandidatoController');
Route::resource('encargado','EncargadoController');
Route::resource('departamento','DepartamentoController');
Route::resource('provincia','ProvinciaController');
Route::resource('actavotos','ActaVotosController');
Route::resource('mesa','MesaController');
Route::resource('recinto','RecintoController');

Route::get('exportResultadosExcel', 'GraficasController@exportResultadosExcel');
Route::get('exportResultadosPDF', 'GraficasController@exportResultadosPDF');



//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
