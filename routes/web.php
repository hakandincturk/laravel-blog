<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Front\HomepageController;

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

/*
|--------------------------------------------------------------------------
| Back Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('/admin')->name('admin.')->middleware('isLogin')->group(function(){
    Route::get('/giris',  [AuthController::class, 'login'])->name('login');
    Route::post('/giris',  [AuthController::class, 'loginPost'])->name('loginPost');
});


Route::prefix('/admin')->name('admin.')->middleware('isAdmin')->group(function(){    
    Route::get('/panel',  [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/makaleler/silinenler',  [ArticleController::class, 'trashed'])->name('makaleler.trashed');
    Route::resource('/makaleler', ArticleController::class);
    Route::get('/switch',  [ArticleController::class, 'switch'])->name('switch');
    Route::get('/deletearticle/{id}',  [ArticleController::class, 'delete'])->name('delete.article');
    Route::get('/harddeletearticle/{id}',  [ArticleController::class, 'hardDelete'])->name('hard.delete.article');
    Route::get('/recoverarticle/{id}',  [ArticleController::class, 'recover'])->name('recover.article');
    Route::get('/cikis',  [AuthController::class, 'logout'])->name('logout');
});



/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/sayfa', [HomepageController::class, 'index']);

Route::get('/iletisim', [HomepageController::class, 'contact'])->name('contact');
Route::post('/iletisim', [HomepageController::class, 'contactPost'])->name('contact.post');

Route::get('/kategori/{category}', [HomepageController::class, 'category'])->name('category');
Route::get('/{category}/{slug}', [HomepageController::class, 'single'])->name('single');
Route::get('/{sayfa}', [HomepageController::class, 'page'])->name('page');

