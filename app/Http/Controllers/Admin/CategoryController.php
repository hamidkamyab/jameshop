<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Models\AttributeGroup;
use App\Models\AttributeGroupCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('children')->where('parent_id', null)->paginate(2);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id', null)->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = new Category();
        $meta_description = null;
        if ($request->meta_description) {
            $meta_description = $request->meta_description;
        } else if (!$request->meta_description && $request->description) {
            $meta_description = $request->description;
        }
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->meta_description = $meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->parent_id = $request->parent_id;
        $category->save();
        Session::flash('opration_category', 'دسته بندی ' . $request->title . ' با موفقیت اضافه شد');
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
        $category = Category::findOrFail($id);
        $categories = Category::with('children')->where('parent_id', null)->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $meta_description = null;
        if ($request->meta_description) {
            $meta_description = $request->meta_description;
        } else if (!$request->meta_description && $request->description) {
            $meta_description = $request->description;
        }
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->meta_description = $meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->parent_id = $request->parent_id;
        $category->save();
        Session::flash('opration_category', 'دسته بندی ' . $request->title . ' با موفقیت ویرایش شد');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::with('children')->where('id', $id)->first();
        if (count($category->children) > 0) {
            Session::flash('error_category', 'دسته بندی ' . $category->title . ' دارای دسته های زیر مجموعه است و امکان حذف آن وجود ندارد');
            return redirect(route('categories.index'));
        } else {
            $category->delete();
            Session::flash('opration_category', 'دسته بندی ' . $category->title . ' با موفقیت حذف شد');
        }
        return redirect(route('categories.index'));
    }


    public function attributesList(Request $request)
    {
        $category = Category::with('attributesGroup')->where('id',$request->id)->first();
        if($category){
            $result = response()->json(['status' => 'success','attrGroupCategory'=>$category],Response::HTTP_OK);
        }else{
            $result = response()->json(['status' => 'error','attrGroupCategory'=>''],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }

    public function attributesCreate(string $id)
    {
        $attributes_group = AttributeGroup::all();
        $category = Category::findOrFail($id);
        return view('admin.categories.attribute', compact(['attributes_group','category']));
    }

    public function attributesStore(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        foreach ($request->attributes_id as $key => $value) {
            $attributesValuesProduct = new AttributeGroupCategory();
            $attributesValuesProduct->attribute_group_id = $value;
            $attributesValuesProduct->category_id = $id;
            $attributesValuesProduct->save();
        }
        Session::flash('opration_category', 'ویژگی های مدنظر با موفقیت به دسته بندی ' . $category->title . ' الحاق شد.');
        return redirect(route('categories.index'));
    }

    public function attributesDestroy(string $attrId,string $catId)
    {
        $AttributeGroupCategory = AttributeGroupCategory::where('attribute_group_id',$attrId)->where('category_id',$catId)->first();
        $res = $AttributeGroupCategory->delete();
        if($res && $res == 1){
            $result = response()->json(['status' => 'success'],Response::HTTP_OK);
        }else{
            $result = response()->json(['status' => 'error'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }
}
