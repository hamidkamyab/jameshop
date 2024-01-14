<?php

namespace App\Repositories\AttributeValue;

use App\Models\AttributeValue;
use App\Repositories\File\FileRepository;

class AttributeValueRepository implements AttributeValueRepositoryInterface
{

    protected $file;
    protected $attributeValue;

    public function __construct(FileRepository $FileRepository, AttributeValue $attributeValue)
    {
        $this->file = $FileRepository;
        $this->attributeValue = $attributeValue;
    }

    public function getAll($page = false)
    {
        if($page){
            return  $this->attributeValue::with('attributes_group')->paginate($page);
        }else{
            return  $this->attributeValue::with('attributes_group')->get();
        }
    }

    public function getById($id)
    {
        return  $this->attributeValue::findorFail($id);
    }

    public function store($data){
        $newAttrValue = new $this->attributeValue();
        $newAttrValue->title = $data->title;
        $newAttrValue->attributes_group_id = $data->attributes_group_id;
        $newAttrValue->save();
        return $newAttrValue;
    }

    public function update($data,$id){
        $isAttributeValue = $this->getById($id);
        $isAttributeValue->title = $data->title;
        $isAttributeValue->attributes_group_id = $data->attributes_group_id;
        $isAttributeValue->save();
        return $isAttributeValue;
    }

    public function destroy($id){
        $isAttributeValue = $this->getById($id);
        $isAttributeValue->delete();
        return $isAttributeValue->title;
    }
}
