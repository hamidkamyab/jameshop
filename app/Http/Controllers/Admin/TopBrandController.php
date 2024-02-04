<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\TopBrand\TopBrandRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class TopBrandController extends Controller
{

    private $brand;
    private $topBrand;
    public function __construct(BrandRepositoryInterface $IBrandRepository,TopBrandRepositoryInterface $ITopBrandRepository)
    {
        $this->brand = $IBrandRepository;
        $this->topBrand = $ITopBrandRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topBrands = $this->topBrand->getAll();
        return view('admin.widget.top_brands.index',compact('topBrands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = $this->brand->getAll();
        return view('admin.widget.top_brands.create',compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->topBrand->store($request);
        Session::flash('opration_top_brand','با موفقیت ثبت شد!');
        return redirect()->route('top_brands.index');
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
        $topBrand = $this->topBrand->getById($id);
        $brands = $this->brand->getAll();
        return view('admin.widget.top_brands.edit',compact('topBrand','brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->topBrand->update($request,$id);
        Session::flash('opration_top_brand','با موفقیت ویرایش شد!');
        return redirect()->route('top_brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->topBrand->destroy($id);
        Session::flash('opration_top_brand','با موفقیت حذف شد!');
        return redirect()->route('top_brands.index');
    }

    public function search($id){
        $result = $this->topBrand->search($id);
        return  response()->json(['status' => 'success', 'data' => $result], Response::HTTP_OK);
    }
}
