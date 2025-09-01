<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

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


