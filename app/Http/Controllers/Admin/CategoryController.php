<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

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
        $this->category->update($request,$id);
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
        $category = $this->category->getById($request->id);
        if($category && count($category->attributesGroup) > 0){
            $result = response()->json(['status' => 'success','attrGroupCategory'=>$category],Response::HTTP_OK);
        }else{
            $result = response()->json(['status' => 'error','attrGroupCategory'=>'']);
        }
        return $result;
    }

    public function attributesCreate(string $id)
    {
        $data = $this->category->attrCreate($id);
        return view('admin.categories.attribute', compact('data'));
    }

    public function attributesStore(Request $request, string $id)
    {
        $result = $this->category->attrStore($request,$id);
        Session::flash('opration_category', 'ویژگی های مدنظر با موفقیت به دسته بندی ' . $result . ' الحاق شد.');
        return redirect(route('categories.index'));
    }

    public function attributesDestroy(string $attrId,string $catId)
    {
        $result = $this->category->attrDestroy($attrId,$catId);
        if($result && $result == 1){
            return response()->json(['status' => 'success'],Response::HTTP_OK);
        }else{
            return response()->json(['status' => 'error'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
