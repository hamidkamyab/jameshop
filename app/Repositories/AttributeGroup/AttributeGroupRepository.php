<?php

namespace App\Repositories\AttributeGroup;

use App\Models\AttributeGroup;
use App\Repositories\File\FileRepository;

class AttributeGroupRepository implements AttributeGroupRepositoryInterface
{

    protected $file;
    protected $attributeGroup;

    public function __construct(FileRepository $FileRepository, AttributeGroup $attributeGroup)
    {
        $this->file = $FileRepository;
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
        return  $this->attributeGroup::findorFail($id);
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
