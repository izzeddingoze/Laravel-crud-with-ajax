<?php


use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => '\App\Http\Controllers'],function () {


        Route::get('/', function () {
            return redirect()->route('task.list');
        })->name("home");

        Route::get('/tasks', 'TaskController@index')->name("task.list");
        Route::post('/tasks/done', 'TaskController@done')->name("task.done");
        Route::post('/tasks/store', 'TaskController@store')->name("task.store");
        Route::post('/tasks/update', 'TaskController@update')->name("task.update");
        Route::post('/tasks/remove', 'TaskController@remove')->name("task.remove");
        Route::post('/tasks/update-order', 'TaskController@updateOrder')->name("task.update-order");
    }
);
