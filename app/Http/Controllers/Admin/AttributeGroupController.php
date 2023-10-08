<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeGroupRequest;
use App\Models\AttributeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttributeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributesGroup = AttributeGroup::paginate(20);
        return view('admin.attribute_group.index',compact('attributesGroup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attribute_group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeGroupRequest $request)
    {
        $attributeGroup = new AttributeGroup();

        $attributeGroup->title = $request->title;
        $attributeGroup->type = $request->type;
        $attributeGroup->save();
        Session::flash('store_attr','ویژگی '.$request->title.' با موفقیت ثبت شد.');
        return redirect(route('attributes_group.index'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
