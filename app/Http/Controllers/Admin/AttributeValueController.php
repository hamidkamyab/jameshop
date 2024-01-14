<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeGroupRequest;
use App\Http\Requests\Admin\AttributesValueRequest;
use App\Models\AttributeGroup;
use App\Models\AttributeValue;
use App\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;
use App\Repositories\AttributeValue\AttributeValueRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttributeValueController extends Controller
{

    protected $attributeValue;
    protected $attributeGroup;

    public function __construct(AttributeValueRepositoryInterface $attributeValue, AttributeGroupRepositoryInterface $attributeGroup)
    {
        $this->attributeValue = $attributeValue;
        $this->attributeGroup = $attributeGroup;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributesValue = $this->attributeValue->getAll(20);
        return view('admin.attributes_value.index',compact('attributesValue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributesGroup = $this->attributeGroup->getAll();
        return view('admin.attributes_value.create',compact('attributesGroup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributesValueRequest $request)
    {
        $this->attributeValue->store($request);
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
        $attributeValue = $this->attributeValue->getById($id);
        $attributesGroup = $this->attributeGroup->getAll();
        return view('admin.attributes_value.edit',compact('attributeValue','attributesGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->attributeValue->update($request,$id);
        Session::flash('operation_attribute_value','مقدار '.$request->title.' برای ویژگی مورد نظر با موفقیت ویرایش شد.');
        return redirect(route('attributes_value.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->attributeValue->destroy($id);
        Session::flash('operation_attribute_value','مقدار '.$result.' با موفقیت حذف شد.');
        return redirect(route('attributes_value.index'));
    }
}
