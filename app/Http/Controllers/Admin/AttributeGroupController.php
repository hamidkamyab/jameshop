<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeGroupRequest;
use App\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;
use Illuminate\Support\Facades\Session;

class AttributeGroupController extends Controller
{

    private $attributeGroup;

    public function __construct(AttributeGroupRepositoryInterface $IAttrGRepository)
    {
        $this->attributeGroup = $IAttrGRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributesGroup = $this->attributeGroup->getAll(20);
        return view('admin.attributes_group.index',compact('attributesGroup'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attributes_group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeGroupRequest $request)
    {
        $this->attributeGroup->store($request);
        Session::flash('opration_attribute','ویژگی '.$request->title.' با موفقیت ثبت شد.');
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
        $attributeGroup = $this->attributeGroup->getById($id);
        return view('admin.attributes_group.edit',compact('attributeGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeGroupRequest $request, string $id)
    {
        $this->attributeGroup->update($request,$id);
        Session::flash('opration_attribute','ویژگی '.$request->title.' با موفقیت ویرایش شد.');
        return redirect(route('attributes_group.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->attributeGroup->destroy($id);
        Session::flash('opration_attribute','ویژگی '.$result.' با موفقیت حذف شد.');
        return redirect(route('attributes_group.index'));
    }
}
