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

Route::get('/', function(){
    return view('welcome');
});

*/




Auth::routes();

Route::get('registro', 'PersonaController@selectcategoria');
Route::get('home', 'PersonaController@agregar');
Route::get('/home', 'ListadoController@index')->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('pdfPersonas', 'PersonaController@pdfGenerate');
Route::get('exportarPdf', 'PersonaController@exportar');
Route::post('inserta', 'PersonaController@agregar');
Route::resource('Listado', 'ListadoController');


