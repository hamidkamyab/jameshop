<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::paginate(30);

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
        $brand = new Brand();
        $brand->title = $request->title;
        $brand->description = $request->description;
        $brand->photo_id = $request->photo_id;
        $brand->save();
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
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->title = $request->title;
        $brand->description = $request->description;
        if ($request->photo_id != $brand->photo_id) {
            $photo = MediaFile::findOrFail($brand->photo_id);
            $disk = 'public';
            $path = str_replace("/storage/", "", $photo->path);
            Storage::disk($disk)->delete($path);
            $photo->delete();
            $brand->photo_id = $request->photo_id;
        }
        $brand->save();
        Session::flash('opration_brand', 'برند ' . $request->title . ' با موفقیت ویرایش شد.');
        return redirect(route('brands.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $photo = MediaFile::findOrFail($brand->photo_id);
        $disk = 'public';
        $path = str_replace("/storage/", "", $photo->path);
        Storage::disk($disk)->delete($path);
        $photo->delete();
        $brand->delete();
        Session::flash('opration_brand', 'برند ' . $brand->title . ' با موفقیت حذف شد.');
        return redirect(route('brands.index'));
    }
}
