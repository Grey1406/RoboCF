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

use App\Customer;
use App\CashFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Route::get('welcome', function () {
    return view('welcome');
});

/**
 * Вывести панель с клиентами и форму для перевода
 */
Route::get('/', 'MainController@show');

/**
 * Добавить новые перевод
 */
Route::post('/cash','MainController@cash');


Route::get('/{variable}', 'MainController@show');