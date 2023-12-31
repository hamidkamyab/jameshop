<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use App\Models\File;
use App\Models\MediaFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::with('media.file')->paginate(30);
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
        $brand->save();
        $brand->media()->create([
            'file_id' => $request->photo_id
        ]);
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
        $brand = Brand::with('media.file')->findOrFail($id);
        $brand['photo']=@$brand->media[0]->file;
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        $brand = Brand::with('media.file')->findOrFail($id);
        $brand->title = $request->title;
        $brand->description = $request->description;
        $brand->save();
        if(@$brand->media[0]){
            $brand->media()->update([
                'file_id' => $request->photo_id
            ]);
            if (intval($request->photo_id) != $brand->media[0]->file->id) {
                $photo = $brand->media[0]->file;
                $disk = 'public';
                $path = str_replace("/storage/", "", $photo->path);
                Storage::disk($disk)->delete($path);
                $photo->delete();
            }
        }else{
            $brand->media()->create([
                'file_id' => $request->photo_id
            ]);
        }

        Session::flash('opration_brand', 'برند ' . $request->title . ' با موفقیت ویرایش شد.');
        return redirect(route('brands.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::with('media.file')->findOrFail($id);
        $photo = $brand->media[0]->file;
        $disk = 'public';
        $path = str_replace("/storage/", "", $photo->path);
        Storage::disk($disk)->delete($path);
        $brand->delete();
        $photo->delete();
        Session::flash('opration_brand', 'برند ' . $brand->title . ' با موفقیت حذف شد.');
        return redirect(route('brands.index'));
    }
}
