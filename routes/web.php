<?php

use App\Http\Controllers\Admin\AttributeGroupController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaFileController;
use App\Http\Controllers\Admin\ProductController;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function(){
    Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::post('attributes',[CategoryController::class,'attributesList'])->name('categories.attributes_list');
    Route::get('attributes/{id}',[CategoryController::class,'attributesCreate'])->name('categories.attributes_create');
    Route::post('attributes/{id}',[CategoryController::class,'attributesStore'])->name('categories.attributes_store');
    Route::post('attributes/destroy',[CategoryController::class,'attributesDestroy'])->name('categories.attributes_destroy');
    Route::resource('categories',CategoryController::class);
    Route::resource('attributes_group',AttributeGroupController::class);
    Route::resource('attributes_value',AttributeValueController::class);
    Route::resource('brands', BrandController::class);
    Route::post('mediafiles/upload',[MediaFileController::class,'upload'])
    ->name('mediafiles.upload');
    Route::post('mediafiles/remove',[MediaFileController::class,'remove'])
    ->name('mediafiles.remove');
    Route::resource('mediafiles',MediaFileController::class);
    Route::resource('products',ProductController::class);
});
