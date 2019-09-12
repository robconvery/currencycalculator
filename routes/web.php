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

Route::get('/', 'CurrencyController@index')
    ->name('home');

// Route::get('/currency-converter', 'CurrencyController@index');

Route::post('/calculate', 'CurrencyController@calculate')
    ->name('converter');

/*
Route::get('/', function () {
    return view('currency');
});
*/
