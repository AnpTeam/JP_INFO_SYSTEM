<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttractionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;


/* HOME PAGE */
Route::get('/', [HomeController::class, 'index']);
Route::get('/search', [HomeController::class, 'searchAttraction']);
Route::get('/detail/{id}', [HomeController::class, 'detailAttraction']);
/* HOME PAGE END */

/** USER ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/adding', [UserController::class, 'adding']);
Route::post('/user', [UserController::class, 'create']);
Route::get('/user/{id}', [UserController::class, 'edit']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/remove/{id}', [UserController::class, 'remove']);
Route::get('/user/reset/{id}', [UserController::class, 'reset']);
Route::put('/user/reset/{id}', [UserController::class, 'resetPassword']);
/* USER ROUTE END */



/** ATTRACTION ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/attraction', [AttractionController::class, 'index']);
Route::get('/attraction/adding', [AttractionController::class, 'adding']);
Route::post('/attraction', [AttractionController::class, 'create']);
Route::get('/attraction/{id}', [AttractionController::class, 'edit']);
Route::put('/attraction/{id}', [AttractionController::class, 'update']);
Route::delete('/attraction/remove/{id}', [AttractionController::class, 'remove']);
/* ATTRACTION ROUTE END */

/** REGION ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/region', [RegionController::class, 'index']);
Route::get('/region/adding', [RegionController::class, 'adding']);
Route::post('/region', [RegionController::class, 'create']);
Route::get('/region/{id}', [RegionController::class, 'edit']);
Route::put('/region/{id}', [RegionController::class, 'update']);
Route::delete('/region/remove/{id}', [RegionController::class, 'remove']);
/* REGION PAGE END */

/** COMMENT ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/comment', [CommentController::class, 'index']);
Route::get('/comment/adding', [CommentController::class, 'adding']);
Route::post('/comment', [CommentController::class, 'create']);
Route::get('/comment/{id}', [CommentController::class, 'edit']);
Route::put('/comment/{id}', [CommentController::class, 'update']);
Route::delete('/comment/remove/{id}', [CommentController::class, 'remove']);
/* COMMENT PAGE END */

/** CITY ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/city', [CityController::class, 'index']);
Route::get('/city/adding', [CityController::class, 'adding']);
Route::post('/city', [CityController::class, 'create']);
Route::get('/city/{id}', [CityController::class, 'edit']);
Route::put('/city/{id}', [CityController::class, 'update']);
Route::delete('/city/remove/{id}', [CityController::class, 'remove']);
/* CITY PAGE END */

/** CATEGORY ROUTE
 *  @USAGE : BASIC CRUD (CREATE, READ, UPDATE, DELETE)
 */
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/adding', [CategoryController::class, 'adding']);
Route::post('/category', [CategoryController::class, 'create']);
Route::get('/category/{id}', [CategoryController::class, 'edit']);
Route::put('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/remove/{id}', [CategoryController::class, 'remove']);
/* CATEGORY PAGE END */

/** DASHBOARD ROUTE
 *  @USAGE : SHOW DASHBOARD FOR ANALYTICS
 */
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/dashboard/table', [DashboardController::class, 'searchTable']);
Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData']);
/* DASHBOARD PAGE END */

/** AUTHENTICATION ROUTE
 *  @USAGE : LOGIN, LOGOUT, REGISTER, FORGOT PASSWORD, RESET PASSWORD
 */
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// protected routes (ต้อง login ก่อนถึงจะเข้าได้)
Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
/* AUTHENTICATION PAGE END */