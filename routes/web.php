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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('worker')->group(function() {

    Route::get('/', 'WorkerController@ViewListAction');
    Route::get('/{id}', 'WorkerController@ViewWorkerAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','WorkerController@ViewListAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}','WorkerController@ViewListAction');
    Route::post('/', 'WorkerController@CreateAction');
    Route::put('{id}', 'WorkerController@UpdateAction');
    Route::delete('{id}', 'WorkerController@DeleteAction');
});

Route::prefix('times')->group(function() {

    Route::get('/', 'ControlTimeController@ViewListAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','ControlTimeController@ViewListAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}','ControlTimeController@ViewListAction');
    Route::get(
        '/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}/workerId-{workerId}',
        'ControlTimeController@ViewListAction'
    );
    Route::post('/','ControlTimeController@CreateAction');
});
