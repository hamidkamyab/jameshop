<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeGroup;
use App\Models\AttributeGroupCategory;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id',null)->get();
        $brands = Brand::all();
        return view('admin.products.create',compact(['categories','brands']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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


    /**
     * Show the form for editing the specified resource.
     */
    public function attributes(string $id)
    {
        $categories = Category::with('parent')->where('id',$id)->first();
        $catParentId = getParentID($categories);
        $catParentId[] = intval($id);
        $attributes_group_category = AttributeGroupCategory::select('attribute_group_id')->whereIn('category_id',$catParentId)->get();
        $attributes = AttributeGroup::with('attributes_value')->whereIn('id',$attributes_group_category)->get();
        return  response()->json(['status' => 'success','attributes' => $attributes],Response::HTTP_OK);
    }
}
