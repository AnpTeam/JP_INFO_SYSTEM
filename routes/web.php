<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttractionController;

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

//product crud
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/adding',  [ProductController::class, 'adding']);
Route::post('/product',  [ProductController::class, 'create']);
Route::get('/product/{id}',  [ProductController::class, 'edit']);
Route::put('/product/{id}',  [ProductController::class, 'update']);
Route::delete('/product/remove/{id}',  [ProductController::class, 'remove']);

