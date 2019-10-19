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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/', function () {
        return view('home');
    });

    Route::group(['prefix' => 'admin'], function () {
        Voyager::routes();
    });

    Route::get('/ugovori/pregled', 'ugovorController@index');
    Route::get('/ugovori/kreiraj', 'ugovorController@create');
    Route::get('/ugovori/pregled_ugovora/{id}', 'ugovorController@show');
    Route::get('/ugovori/izmijeni/{id}', 'ugovorController@edit');
    Route::post('/ugovori/izmijeni/{id}', 'ugovorController@update');
    Route::post('/ugovori/inaktivan/{id}', 'ugovorController@inaktivan');
    Route::delete('/ugovori/obrisi/{id}', 'ugovorController@destroy');

    Route::get('/odredjivanje_najma', function (){
        return view("odredjivanje_najma");
    });


    Route::resource('ugovori', 'ugovorController');

    Route::get('/odabir_ugovora', function (){
        return view("odabir_ugovora");
    });

    Route::get('/pregled_dugovanja', 'ugovorController@izracun');

    Route::get('/izvjestaj_biljeske', 'izvjestajiController@index');
    Route::post('/biljeske', 'izvjestajiController@izvjestaji');

    Route::get('/izvjestaj_bilans_uspjeha', function (){
        return view("/izvjestaji/izvjestaj_bilans_uspjeha");
    });

    Route::get('/izvjestaj_pracenje_imovine', function (){
        return view("/izvjestaji/izvjestaj_pracenje_imovine");
    });
});
