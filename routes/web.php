<?php

use App\Http\Controllers\Admin\AmazingController;
use App\Http\Controllers\Admin\AttributeGroupController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BeautyController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryTabController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StyleController;
use App\Http\Controllers\Admin\TopBrandController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\SearchController;
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
    Route::post('products/search',[ProductController::class,'search'])->name('products.search');
    Route::resource('products',ProductController::class);

    Route::prefix('widget')->group(function(){
        Route::get('slider',[SliderController::class,'index'])->name('slider.index');
        Route::post('slider',[SliderController::class,'store'])->name('slider.store');
        Route::get('slider/{id}',[SliderController::class,'destroy'])->name('slider.destroy');

        Route::get('amazings',[AmazingController::class,'index'])->name('amazings.index');
        Route::get('amazings/create',[AmazingController::class,'create'])->name('amazings.create');
        Route::post('amazings',[AmazingController::class,'store'])->name('amazings.store');
        Route::get('amazings/edit/{id}',[AmazingController::class,'edit'])->name('amazings.edit');
        Route::patch('amazings/update/{id}',[AmazingController::class,'update'])->name('amazings.update');
        Route::delete('amazings/{id}',[AmazingController::class,'destroy'])->name('amazings.destroy');

        Route::get('styles',[StyleController::class,'index'])->name('styles.index');
        Route::get('styles/create',[StyleController::class,'create'])->name('styles.create');
        Route::post('styles',[StyleController::class,'store'])->name('styles.store');
        Route::get('styles/edit/{id}',[StyleController::class,'edit'])->name('styles.edit');
        Route::patch('styles/update/{id}',[StyleController::class,'update'])->name('styles.update');
        Route::delete('styles/{id}',[StyleController::class,'destroy'])->name('styles.destroy');

        Route::get('category_tabs',[CategoryTabController::class,'index'])
        ->name('category_tabs.index');
        Route::get('category_tabs/create',[CategoryTabController::class,'create'])
        ->name('category_tabs.create');
        Route::post('category_tabs',[CategoryTabController::class,'store'])
        ->name('category_tabs.store');
        Route::get('category_tabs/edit/{id}',[CategoryTabController::class,'edit'])
        ->name('category_tabs.edit');
        Route::patch('category_tabs/update/{id}',[CategoryTabController::class,'update'])
        ->name('category_tabs.update');
        Route::delete('category_tabs/{id}',[CategoryTabController::class,'destroy'])
        ->name('category_tabs.destroy');
        Route::get('category_tabs/children/create/{parent}',[CategoryTabController::class,'children_create'])
        ->name('category_tabs.children.create');
        Route::post('category_tabs/children/{parent}',[CategoryTabController::class,'children_store'])
        ->name('category_tabs.children.store');
        Route::get('category_tabs/children/edit/{id}',[CategoryTabController::class,'children_edit'])
        ->name('category_tabs.children.edit');
        Route::patch('category_tabs/children/update/{id}',[CategoryTabController::class,'children_update'])
        ->name('category_tabs.children.update');
        Route::delete('category_tabs/children/{id}',[CategoryTabController::class,'children_destroy'])
        ->name('category_tabs.children.destroy');



        Route::get('beauties',[BeautyController::class,'index'])->name('beauties.index');
        Route::get('beauties/create',[BeautyController::class,'create'])->name('beauties.create');
        Route::post('beauties',[BeautyController::class,'store'])->name('beauties.store');
        Route::get('beauties/edit/{id}',[BeautyController::class,'edit'])->name('beauties.edit');
        Route::patch('beauties/update/{id}',[BeautyController::class,'update'])->name('beauties.update');
        Route::delete('beauties/{id}',[BeautyController::class,'destroy'])->name('beauties.destroy');


        Route::get('top_brands',[TopBrandController::class,'index'])->name('top_brands.index');
        Route::get('top_brands/create',[TopBrandController::class,'create'])->name('top_brands.create');
        Route::post('top_brands',[TopBrandController::class,'store'])->name('top_brands.store');
        Route::get('top_brands/edit/{id}',[TopBrandController::class,'edit'])->name('top_brands.edit');
        Route::patch('top_brands/update/{id}',[TopBrandController::class,'update'])->name('top_brands.update');
        Route::delete('top_brands/{id}',[TopBrandController::class,'destroy'])->name('top_brands.destroy');
        Route::get('top_brands/search/{id}',[TopBrandController::class,'search'])->name('top_brands.search');

    });

    Route::get('settings',[SettingController::class,'index'])->name('settings.index');
    Route::post('settings',[SettingController::class,'store'])->name('settings.store');
});


Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/home',[HomeController::class,'index'])->name('home');
Route::get('/search',[SearchController::class,'index'])->name('search');
