<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('worker')->group(function() {

    Route::get('/', 'WorkerController@ViewListAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','WorkerController@ViewListAction');
    Route::post('/create', 'WorkerController@CreateAction');
    Route::put('/{id}', 'WorkerController@DeleteAction');
});
