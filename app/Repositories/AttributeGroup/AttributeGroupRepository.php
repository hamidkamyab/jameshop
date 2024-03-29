<?php

namespace App\Repositories\AttributeGroup;

use App\Models\AttributeGroup;

class AttributeGroupRepository implements AttributeGroupRepositoryInterface
{
    protected $attributeGroup;

    public function __construct(AttributeGroup $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
    }

    public function getAll($page = false)
    {
        if($page){
            return  $this->attributeGroup::paginate($page);
        }else{
            return  $this->attributeGroup::all();
        }
    }

    public function getById($id)
    {
        return  $this->attributeGroup::with('attributes_value')->whereIn('id', $id)->get();
    }

    public function store($data){
        $newAttrGroup = new $this->attributeGroup();
        $newAttrGroup->title = $data->title;
        $newAttrGroup->type = $data->type;
        $newAttrGroup->save();
        return $newAttrGroup;
    }

    public function update($data,$id){
        $isAttributeGroup = $this->getById($id);
        $isAttributeGroup->title = $data->title;
        $isAttributeGroup->type = $data->type;
        $isAttributeGroup->save();
        return $isAttributeGroup;
    }

    public function destroy($id){
        $isAttributeGroup = $this->getById($id);
        $isAttributeGroup->delete();
        return $isAttributeGroup->title;
    }
}
