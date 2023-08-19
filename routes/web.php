<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('/');

Route::get('login',[CustomController::class,'index'])->name('login');
Route::post('custom-login', [CustomController::class, 'customLogin'])->name('loginCustom');
Route::get('register', [CustomController::class, 'registration'])->name('register');
Route::post('custom-registration', [CustomController::class, 'customRegistration'])->name('registrationCustom');
Route::get('logout', [CustomController::class, 'logout'])->name('logout');
Route::get('dashboard', [CustomController::class, 'dashboard'])->name('dashboard');
Route::get('approval',[CustomController::class,'approval'])->middleware(['auth','approved'])->name('approval');
// Route::get('admin', [CustomController::class, 'adminhome'])->middleware(['auth','admin'])->name('adminView');
Route::post('/user/{id}',[CustomController::class, 'approved'])->name('approved');

Route::get('/user-view',[AdminController::class,'userView'])->name('userView');
Route::get('/admin/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/update', [AdminController::class, 'update'])->name('admin.update');
Route::get('/change-password',[AdminController::class, 'showChangePassForm'])->name('change.password');
Route::post('/update-password',[AdminController::class, 'updatePassword'])->name('update.password');



// Route::get('/create-blog', [BlogController::class, 'create'])->name('create.blog');
Route::post('/store-blog', [BlogController::class, 'store'])->name('store.blog');
Route::get('/view-blog',[BlogController::class,'show'])->name('show.blog');
Route::get('/fetch_data',[BlogController::class,'fetchdata']);
Route::post('update-blog/{id}',[BlogController::class,'update'])->name('update.blog');
Route::delete('/delete-blog/{id}',[BlogController::class,'destroy'])->name('delete.blog');
Route::get('export-blog',[BlogController::class,'export'])->name('export');
