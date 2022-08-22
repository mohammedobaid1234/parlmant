<?php

use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\ArticlesController;
use App\Http\Controllers\Admin\CouncilsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\VideosController;
use App\Http\Controllers\Admin\NewspaperController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SectionsController;
use App\Models\Ads;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::prefix('admin')
    ->middleware(['auth', 'check:3'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::resource('/reports', ReportsController::class);
        Route::resource('/videos', VideosController::class);
        Route::resource('/articles', ArticlesController::class);
        Route::resource('/newspapers', NewspaperController::class);

        Route::get('/users/new-create', [UsersController::class, 'newCreate'])->name('users.newCreate');
        Route::post('users/new-store', [UsersController::class, 'newStore'])->name('users.newStore');
        Route::get('/users/before-create', [UsersController::class, 'beforeCreate'])->name('users.beforeCreate');
        Route::resource('/users', UsersController::class);
        Route::get('/users/create/{id}', [UsersController::class, 'create'])->name('users.create');
        Route::get('/users/children/{id}', [UsersController::class, 'children'])->name('users.children');

        // Route::get('/users/new-create/{id}', [UsersController::class, 'sepesficCreate'])->name('users.create');

        Route::resource('/councils', CouncilsController::class);

        Route::get('section/new-create', [SectionsController::class, 'newCreate'])->name('sections.new-create');
        Route::get('/sections/before-create', [SectionsController::class, 'beforeCreate'])->name('sections.before');
        Route::resource('/sections', SectionsController::class);
        Route::post('/sections/create/{id}', [SectionsController::class, 'sectionStore'])->name('sections.store');
        Route::get('/sections/create/{id}', [SectionsController::class, 'createSection'])->name('sections.create');

        Route::get('/councils/show/{id}', [CouncilsController::class, 'checkChildren'])->name('council.checkChildren');

        Route::resource('/ads', AdsController::class);
    });

require __DIR__ . '/auth.php';
