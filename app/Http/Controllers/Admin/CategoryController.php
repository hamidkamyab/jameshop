<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('children')->where('parent_id',null)->paginate(2);
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id',null)->get();
        // dd($categories->all());
        return view('admin.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = new Category();

        if($request->slug){
            $slug = make_slug($request->slug);
        }else{
            $slug = make_slug($request->title);
        }

        if($request->meta_description){
            $meta_description = $request->meta_description;
        }else if(!$request->meta_description && $request->description){
            $meta_description = $request->description;
        }
        $category->title = $request->title;
        $category->slug = $slug;
        $category->description = $request->description;
        $category->meta_description = $meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->parent_id = $request->parent_id;
        $category->save();
        Session::flash('store_category','دسته بندی مورد نظر با موفقیت اضافه شد');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::with('children')->where('id',$id)->first();
        if(count($category->children) > 0){
            Session::flash('error_category','دسته بندی '.$category->title.' دارای دسته های زیر مجموعه است و امکان حذف آن وجود ندارد');
            return redirect(route('categories.index'));
        }else{
            $category->delete();
            Session::flash('destroy_category','دسته بندی '.$category->title.' با موفقیت حذف شد');
        }
        return redirect(route('categories.index'));
    }
}
