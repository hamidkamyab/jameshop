<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Color;
use App\Repositories\Color\ColorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{

    private $color;

    public function __construct(ColorRepositoryInterface $IColorRepository)
    {
        $this->color = $IColorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors =$this->color->getAll(20);
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
        $this->color->store($request);
        Session::flash('opration_color', 'رنگ ' . $request->name . ' با موفقیت ثبت شد.');
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
        $color = $this->color->getById($id);
        return view('admin.colors.edit',compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, string $id)
    {
        $this->color->update($request,$id);
        Session::flash('opration_color', 'رنگ ' . $request->name . ' با موفقیت ویرایش شد.');
        return redirect(route('colors.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = $this->color->destroy($id);
        Session::flash('opration_color', 'رنگ ' . $color->name . ' با موفقیت حذف شد.');
        return redirect(route('colors.index'));
    }
}
