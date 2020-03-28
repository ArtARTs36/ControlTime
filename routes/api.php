<?php

use Illuminate\Support\Facades\Route;

Route::prefix('workers')->group(function() {
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','WorkerController@index');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}','WorkerController@index');
    Route::post('/{worker}/load/vacation-application','WorkerController@saveVacationApplication');
});

Route::apiResource('workers', 'WorkerController');

Route::prefix('times')->group(function() {

    Route::get('/', 'ControlTimeController@ViewListAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','ControlTimeController@ViewListAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}','ControlTimeController@ViewListAction');
    Route::get(
        '/page-{page}/sort/{sortKey}-{sortDirection}/count-{count}/workerId-{workerId}',
        'ControlTimeController@ViewListAction'
    );
    Route::post('/','ControlTimeController@CreateAction');
    Route::get('/report/worker/{worker}','ControlTimeController@report');
});

Route::get('document-download/{timeWithFormat}', 'DocumentController@download');
