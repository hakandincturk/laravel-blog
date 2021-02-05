<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\AuthController;
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

Route::get('/admin/panel',  [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/giris',  [AuthController::class, 'login'])->name('admin.login');



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

