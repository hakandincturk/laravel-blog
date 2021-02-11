<?php


use Illuminate\Support\Facades\Route;

//Back Controller
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\ConfigController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\PageController;

//Front Controller
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

Route::get('/aktif-degil', function(){
    return view('front.offline');
});

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
    
    //Articles Routes
    Route::get('/makaleler/silinenler',  [ArticleController::class, 'trashed'])->name('makaleler.trashed');
    Route::resource('/makaleler', ArticleController::class);
    Route::get('/switch',  [ArticleController::class, 'switch'])->name('switch');
    Route::get('/deletearticle/{id}',  [ArticleController::class, 'delete'])->name('delete.article');
    Route::get('/harddeletearticle/{id}',  [ArticleController::class, 'hardDelete'])->name('hard.delete.article');
    Route::get('/recoverarticle/{id}',  [ArticleController::class, 'recover'])->name('recover.article');

    //Categories Routes
    Route::get('/kategoriler', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/kategoriler/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/kategoriler/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/kategoriler/delete', [CategoryController::class, 'delete'])->name('categories.delete');
    Route::get('/cs',  [CategoryController::class, 'statusSwitch'])->name('category.switch');
    Route::get('/kategori/getData',  [CategoryController::class, 'getData'])->name('category.getData');

    //Pages Routes
    Route::get('/sayfalar', [PageController::class, 'index'])->name('pages.index');
    Route::get('/sayfalar/olustur', [PageController::class, 'create'])->name('pages.create');
    Route::post('/sayfalar/olustur', [PageController::class, 'store'])->name('pages.store');
    Route::get('/sayfalar/guncelle/{id}', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/sayfalar/guncelle/{id}', [PageController::class, 'update'])->name('pages.update');
    Route::get('/sayfalar/sil/{id}', [PageController::class, 'delete'])->name('pages.delete');
    Route::get('/sayfalar/orders', [PageController::class, 'orders'])->name('pages.orders');
    Route::get('/page/switch',  [PageController::class, 'statusSwitch'])->name('pages.switch');

    //Configs Routes
    Route::get('/ayarlar', [ConfigController::class, 'index'])->name('config.index');
    Route::post('/ayarlar/guncelle', [ConfigController::class, 'update'])->name('config.update');

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

