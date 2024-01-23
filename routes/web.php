<?php

use App\Http\Controllers\Admin\AmazingController;
use App\Http\Controllers\Admin\AttributeGroupController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
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
    Route::post('categories/attributes',[CategoryController::class,'attributesList'])->name('categories.attributes_list');
    Route::get('categories/attributes/{id}',[CategoryController::class,'attributesCreate'])->name('categories.attributes_create');
    Route::post('categories/attributes/{id}',[CategoryController::class,'attributesStore'])->name('categories.attributes_store');
    Route::get('categories/attributes/destroy/{attrId}/{catId}',[CategoryController::class,'attributesDestroy'])->name('categories.attributes_destroy');
    Route::resource('categories',CategoryController::class);
    Route::resource('attributes_group',AttributeGroupController::class);
    Route::resource('attributes_value',AttributeValueController::class);
    Route::get('menus/photos/{id}',[MenuController::class,'photos'])->name('menus.photos');
    Route::get('menus/best_menu/destroy/{id}/{status?}',[MenuController::class,'bestMenu_destroy'])->name('menus.bestMenu_destroy');
    Route::resource('menus', MenuController::class);
    Route::resource('brands', BrandController::class);
    Route::post('files/upload',[FileController::class,'upload'])
    ->name('files.upload');
    Route::post('files/remove',[FileController::class,'remove'])
    ->name('files.remove');
    Route::resource('files',FileController::class);
    Route::resource('colors',ColorController::class);
    Route::resource('sizes',SizeController::class);
    Route::get('attributes/{id}',[ProductController::class,'attributes'])->name('products.attributes');
    Route::get('photos/{id}',[ProductController::class,'photos'])->name('products.photos');
    Route::post('products/delete/{product}',[ProductController::class,'delete'])->name('products.delete');
    Route::resource('products',ProductController::class);
    Route::prefix('widget')->group(function(){
        Route::get('slider',[SliderController::class,'index'])->name('slider.index');
        Route::post('slider',[SliderController::class,'store'])->name('slider.store');
        Route::get('slider/{id}',[SliderController::class,'destroy'])->name('slider.destroy');

        Route::get('amazings',[AmazingController::class,'index'])->name('amazings.index');
        Route::get('amazings/create',[AmazingController::class,'create'])->name('amazings.create');
        Route::post('amazings',[AmazingController::class,'store'])->name('amazings.store');
        Route::get('amazings/{id}',[AmazingController::class,'destroy'])->name('amazings.destroy');
    });
});
