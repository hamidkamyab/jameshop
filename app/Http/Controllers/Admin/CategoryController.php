<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Models\AttributeGroup;
use App\Models\AttributeGroupCategory;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private $category;
    public function __construct(CategoryRepositoryInterface $ICategoryRepository)
    {
        $this->category = $ICategoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->category->getPage(2);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->getAll();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->store($request);
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
        $category =  $this->category->getById($id);
        $categories = $this->category->getAll();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateCategoryRequest $request, string $id)
    {
        $this->category->store($request,$id);
        Session::flash('opration_category', 'دسته بندی ' . $request->title . ' با موفقیت ویرایش شد');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->category->destroy($id);
        if($result['status'] == 0){
            Session::flash('error_category', 'دسته بندی ' . $result['title'] . ' دارای دسته های زیر مجموعه است و امکان حذف آن وجود ندارد');
        }else{
            Session::flash('opration_category', 'دسته بندی ' . $result['title'] . ' با موفقیت حذف شد');
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
