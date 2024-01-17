<?php

namespace App\Repositories\Category;

use App\Models\AttributeGroup;
use App\Models\AttributeGroupCategory;
use App\Models\Category;
use App\Repositories\File\FileRepository;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $file;
    protected $category;
    protected $attributeGroup;
    protected $attributeGroupCategory;

    public function __construct(
        FileRepository $FileRepository,Category $category,AttributeGroup $attributeGroup,AttributeGroupCategory $attributeGroupCategory
    ){
        $this->file = $FileRepository;
        $this->category = $category;
        $this->attributeGroup = $attributeGroup;
        $this->attributeGroupCategory = $attributeGroupCategory;
    }

    public function getAll($page = false)
    {
        if($page){
            return  $this->category::with('children')->where('parent_id', 0)->paginate($page);
        }else{
            return  $this->category::with('children')->where('parent_id', 0)->get();
        }
    }

    public function getById($id)
    {
        return  $this->category::with('attributesGroup','parent','children','media.file')->findOrFail($id);
    }

    public function store($data){
        $newCategory = new $this->category();
        $meta_description = null;
        if ($data->meta_description) {
            $meta_description = $data->meta_description;
        } else if (!$data->meta_description && $data->description) {
            $meta_description = $data->description;
        }
        $newCategory->title = $data->title;
        $newCategory->slug = $data->slug;
        $newCategory->description = $data->description;
        $newCategory->meta_description = $meta_description;
        $newCategory->meta_keywords = $data->meta_keywords;
        $newCategory->parent_id = $data->parent_id;
        $newCategory->save();
        if($data->photo_id){
            $newCategory->media()->create([
                'file_id' => $data->photo_id
            ]);
        }
        return $newCategory;
    }

    public function update($data,$id){
        $isCategory = $this->getById($id);
        $meta_description = null;
        if ($data->meta_description) {
            $meta_description = $data->meta_description;
        } else if (!$data->meta_description && $data->description) {
            $meta_description = $data->description;
        }
        $isCategory->title = $data->title;
        $isCategory->slug = $data->slug;
        $isCategory->description = $data->description;
        $isCategory->meta_description = $meta_description;
        $isCategory->meta_keywords = $data->meta_keywords;
        $isCategory->parent_id = $data->parent_id;
        $isCategory->save();
        if(@$isCategory->media[0]){
            $isCategory->media()->update([
                'file_id' => $data->photo_id
            ]);
            if ($isCategory->media[0]->file->id != intval($data->photo_id)) {
                $photo = $isCategory->media[0]->file;
                $this->file->destroy($photo->id);
            }
        }else{
            $isCategory->media()->create([
                'file_id' => $data->photo_id
            ]);
        }
        return $isCategory;
    }

    public function destroy($id){
        $isCategory = $this->getById($id);
        $status = 0;
        if (count($isCategory->children) > 0) {
            $status = 0;
        } else {
            if (@$isCategory->media[0]) {
                $photo = $isCategory->media[0]->file;
                $this->file->destroy($photo->id);
            }
            $isCategory->delete();
            $status = 1;
        }

        return ['status'=>$status,'title'=>$isCategory->title];
    }

    public function attrCreate($id){
        $catsId = [];

        $isCategory = $this->getById($id);

        $catParentId = getParentID($isCategory);
        $catChildrenId = getChildrenID($isCategory);

        foreach ($catParentId as $key => $value) {
            $catsId[] = $value;
        }
        foreach ($catChildrenId as $key => $value) {
            $catsId[] = $value;
        }

        $attributes_group_category = $this->attributeGroupCategory::select('attribute_group_id')->whereIn('category_id',$catsId)->get();
        $attributes_group_category = getOneFieldOfArray($attributes_group_category,'attribute_group_id');
        $attributes_group_filter = $this->attributeGroup::whereIn('id',$attributes_group_category)->get();

        $attributes_group_this_category = $this->attributeGroupCategory::select('attribute_group_id')->where('category_id',$id)->get();
        $attributes_group_this_category = getOneFieldOfArray($attributes_group_this_category,'attribute_group_id');
        $attributes_group_this_filter = $this->attributeGroup::whereIn('id',$attributes_group_this_category)->get();

        foreach ($attributes_group_this_category as $key => $value) {
            $attributes_group_category[] = $value;
        }

        $attributes_group = $this->attributeGroup::whereNotIn('id',$attributes_group_category)->get();

        return ['attributes_group'=>$attributes_group,'attributes_group_filter'=>$attributes_group_filter,'attributes_group_this_filter'=>$attributes_group_this_filter,'category'=>$isCategory];
    }


    public function attrStore($data,$id){
        $isCategory = $this->getById($id);
        foreach ($data->attributes_id as $key => $value) {
            $attributesValuesProduct = new $this->attributeGroupCategory();
            $attributesValuesProduct->attribute_group_id = $value;
            $attributesValuesProduct->category_id = $id;
            $attributesValuesProduct->save();
        }
        return $isCategory->title;
    }
    public function attrDestroy($attrId,$catId){
        $AttributeGroupCategory = $this->attributeGroupCategory::where('attribute_group_id',$attrId)->where('category_id',$catId)->first();
        return $AttributeGroupCategory->delete();
    }

    public function attrGroupCat($catsId){
        return  $this->attributeGroupCategory::whereIn('category_id', $catsId)->get();
    }
}
