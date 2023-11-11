<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeRequest $request)
    {
        $size = new Size();
        $size->title = $request->title;
        $size->save();
        Session::flash('opration_size', 'سایز ' . $request->title . ' با موفقیت اضافه شد.');
        return redirect()->route('sizes.index');
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
        $size = Size::findOrFail($id);
        return view('admin.sizes.edit',compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeRequest $request, string $id)
    {
        $size = Size::findOrFail($id);
        $size->title = $request->title;
        $size->save();
        Session::flash('opration_size', 'سایز ' . $request->title . ' با موفقیت ویرایش شد.');
        return redirect()->route('sizes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        Session::flash('opration_size', 'سایز ' . $size->title . ' با موفقیت حذف شد.');
        return redirect()->route('sizes.index');
    }
}
