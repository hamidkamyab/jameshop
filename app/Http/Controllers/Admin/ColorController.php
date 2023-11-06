<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::paginate(20);
        return view('admin.colors.index',compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request)
    {
        $color = new Color();
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();
        Session::flash('opration_color', 'رنگ ' . $color->name . ' با موفقیت ثبت شد.');
        return redirect(route('colors.index'));
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
        $color = Color::findOrFail($id);
        return view('admin.colors.edit',compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, string $id)
    {
        $color = Color::findOrFail($id);
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();
        Session::flash('opration_color', 'رنگ ' . $request->name . ' با موفقیت ویرایش شد.');
        return redirect(route('colors.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        Session::flash('opration_color', 'رنگ ' . $color->name . ' با موفقیت حذف شد.');
        return redirect(route('colors.index'));
    }
}
