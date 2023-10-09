<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeGroupRequest;
use App\Http\Requests\Admin\AttributesValueRequest;
use App\Models\AttributeGroup;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributesValue = AttributeValue::with('attributes_group')->paginate(20);
        return view('admin.attributes_value.index',compact('attributesValue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributesGroup = AttributeGroup::all();
        return view('admin.attributes_value.create',compact('attributesGroup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributesValueRequest $request)
    {
        $attributes = new AttributeValue();
        $attributes->title = $request->title;
        $attributes->attributes_group_id = $request->attributes_group_id;
        $attributes->save();
        Session::flash('operation_attribute_value','مقدار '.$request->title.' برای ویژگی مورد نظر با موفقیت ثبت شد.');
        return redirect(route('attributes_value.index'));
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
