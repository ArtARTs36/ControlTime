<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PROPFIND, PROPPATCH, COPY, MOVE, DELETE, MKCOL, LOCK, UNLOCK, PUT, GETLIB, VERSION-CONTROL, CHECKIN, CHECKOUT, UNCHECKOUT, REPORT, UPDATE, CANCELUPLOAD, HEAD, OPTIONS, GET, POST');
header('Access-Control-Allow-Headers: Overwrite, Destination, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('worker')->group(function() {

    Route::get('/', 'WorkerController@ViewListAction');
    Route::get('/page-{page}/sort/{sortKey}-{sortDirection}','WorkerController@ViewListAction');
    Route::post('/create', 'WorkerController@CreateAction');
    Route::delete('{id}', 'WorkerController@DeleteAction');
});
