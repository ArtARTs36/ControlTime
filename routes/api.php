<?php

use Illuminate\Support\Facades\Route;

Route::get('/pushes/page-{page}','PushController@index');
Route::get('/pushes/info','PushController@info');
Route::apiResource('pushes', 'PushController');

Route::prefix('workers')->group(function() {
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','WorkerController@index');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}','WorkerController@index');
    Route::post('/{worker}/load/vacation-application','WorkerController@saveVacationApplication');
});

Route::apiResource('workers', 'WorkerController');

Route::prefix('times')->group(function() {
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','ControlTimeController@index');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}','ControlTimeController@index');
    Route::get(
        '/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}/workerId-{workerId}',
        'ControlTimeController@index'
    );
    Route::get('/report/worker/{worker}','ControlTimeController@report');
});

Route::apiResource('times', 'ControlTimeController');

Route::get('document-download/{timeWithFormat}', 'DocumentController@download');
