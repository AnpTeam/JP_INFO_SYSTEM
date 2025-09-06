<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttractionController;
use App\Http\Controllers\RegionController;

/* HOME PAGE */
Route::get('/', [UserController::class, 'index']);
/* HOME PAGE END */

/** USER ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/adding',  [UserController::class, 'adding']);
Route::post('/user',  [UserController::class, 'create']);
Route::get('/user/{id}',  [UserController::class, 'edit']);
Route::put('/user/{id}',  [UserController::class, 'update']);
Route::delete('/user/remove/{id}',  [UserController::class, 'remove']);
Route::get('/user/reset/{id}',  [UserController::class, 'reset']);
Route::put('/user/reset/{id}',  [UserController::class, 'resetPassword']);
/* USER ROUTE END */

/** ATTRACTION ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/attraction', [AttractionController::class, 'index']);
Route::get('/attraction/adding',  [AttractionController::class, 'adding']);
Route::post('/attraction',  [AttractionController::class, 'create']);
Route::get('/attraction/{id}',  [AttractionController::class, 'edit']);
Route::put('/attraction/{id}', [AttractionController::class, 'update']);
Route::delete('/attraction/remove/{id}',  [AttractionController::class, 'remove']);
/* ATTRACTION ROUTE END */

//Region crud
Route::get('/region', [RegionController::class, 'index']);
Route::get('/region/adding',  [RegionController::class, 'adding']);
Route::post('/region',  [RegionController::class, 'create']);
Route::get('/region/{id}',  [RegionController::class, 'edit']);
Route::put('/region/{id}',  [RegionController::class, 'update']);
Route::delete('/region/remove/{id}',  [RegionController::class, 'remove']);

