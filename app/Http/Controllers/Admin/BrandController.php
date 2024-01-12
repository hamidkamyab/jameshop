<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{

    private $brand;

    public function __construct(BrandRepositoryInterface $IBrandRepository)
    {
        $this->brand = $IBrandRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = $this->brand->getAll();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $this->brand->store($request);
        Session::flash('opration_brand', 'برند ' . $request->title . ' با موفقیت ثبت شد.');
        return redirect(route('brands.index'));
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
        $brand = $this->brand->getById($id);
        $brand['photo']=@$brand->media[0]->file;
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        $this->brand->update($request,$id);
        Session::flash('opration_brand', 'برند ' . $request->title . ' با موفقیت ویرایش شد.');
        return redirect(route('brands.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = $this->brand->destroy($id);
        Session::flash('opration_brand', 'برند ' . $brand . ' با موفقیت حذف شد.');
        return redirect(route('brands.index'));
    }
}
