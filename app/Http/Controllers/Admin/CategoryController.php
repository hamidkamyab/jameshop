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
use Illuminate\Support\Facades\Storage;

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
        if($request->photo_id){
            $category->media()->create([
                'file_id' => $request->photo_id
            ]);
        }
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
        $category = Category::with('media.file')->findOrFail($id);
        $categories = Category::with('children')->where('parent_id', null)->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateCategoryRequest $request, string $id)
    {
        $category = Category::with('media.file')->findOrFail($id);
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
        if(@$category->media[0]){
            $category->media()->update([
                'file_id' => $request->photo_id
            ]);
            if ($category->media[0]->file->id != intval($request->photo_id)) {
                $photo = $category->media[0]->file;
                $disk = 'public';
                $path = str_replace("/storage/", "", $photo->path);
                Storage::disk($disk)->delete($path);
                $photo->delete();
            }
        }else{
            $category->media()->create([
                'file_id' => $request->photo_id
            ]);
        }

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
        $catsId = [];
        $category = Category::with('parent','children')->where('id',$id)->first();
        $catParentId = getParentID($category);
        $catChildrenId = getChildrenID($category);

        foreach ($catParentId as $key => $value) {
            $catsId[] = $value;
        }
        foreach ($catChildrenId as $key => $value) {
            $catsId[] = $value;
        }

        $attributes_group_category = AttributeGroupCategory::select('attribute_group_id')->whereIn('category_id',$catsId)->get();
        $attributes_group_category = getOneFieldOfArray($attributes_group_category,'attribute_group_id');
        $attributes_group_filter = AttributeGroup::whereIn('id',$attributes_group_category)->get();

        $attributes_group_this_category = AttributeGroupCategory::select('attribute_group_id')->where('category_id',$id)->get();
        $attributes_group_this_category = getOneFieldOfArray($attributes_group_this_category,'attribute_group_id');
        $attributes_group_this_filter = AttributeGroup::whereIn('id',$attributes_group_this_category)->get();

        foreach ($attributes_group_this_category as $key => $value) {
            $attributes_group_category[] = $value;
        }

        $attributes_group = AttributeGroup::whereNotIn('id',$attributes_group_category)->get();

        return view('admin.categories.attribute', compact(['attributes_group','attributes_group_filter','attributes_group_this_filter','category']));
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
