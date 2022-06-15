<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NurseryController;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class, 'authenticate'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('get_user', [AuthController::class, 'get_user']);
    Route::get('nurseries/{token}', [NurseryController::class,'index'])->name('user-panel');
   
  });
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

  Route::group([
    'middleware' => 'jwt.verify'
    , 'prefix'=>'auth'], function ($router) {
    
    
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [NurseryController::class, 'index'])->name("profile");  
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  

    Route::group(['middleware' => 'jwt.verify',
    'prefix' => 'user-profile'
    ], function ($router){
        Route::post('/import', [NurseryController::class, 'store'])->name('import');
        Route::get('/json/export', [NurseryController::class, 'exportToJSON'])->name('export_to_JSON');
        Route::get('/xml/export', [NurseryController::class, 'exportToXML'])->name('export_to_XML');
        Route::get('/xml/import', [NurseryController::class, 'importFromXML'])->name('import_from_XML');
        Route::get('/sort',[NurseryController::class, 'sort_by_price'])->name('sortowaniepocenie');
        Route::get('/search',[NurseryController::class,'search'])->name('search');
        Route::get('nursery/{id}', [NurseryController::class, 'showNursery'])->name('show');
        Route::put('nursery/update/{id}', [NurseryController::class, 'update'])->name('update');

    });
    
});
