<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getPage($page)
    {
        return  Category::with('children')->where('parent_id', 0)->paginate($page);
    }

    public function getAll()
    {
        return  Category::with('children')->where('parent_id', 0)->get();
    }

    public function getById($id)
    {
        return  Category::with('children','media.file')->findOrFail($id);
    }

    public function store($data){
        $category = new Category();
        $meta_description = null;
        if ($data->meta_description) {
            $meta_description = $data->meta_description;
        } else if (!$data->meta_description && $data->description) {
            $meta_description = $data->description;
        }
        $category->title = $data->title;
        $category->slug = $data->slug;
        $category->description = $data->description;
        $category->meta_description = $meta_description;
        $category->meta_keywords = $data->meta_keywords;
        $category->parent_id = $data->parent_id;
        $category->save();
        if($data->photo_id){
            $category->media()->create([
                'file_id' => $data->photo_id
            ]);
        }
        return $category;
    }

    public function update($data,$id){
        $category = $this->getById($id);
        $meta_description = null;
        if ($data->meta_description) {
            $meta_description = $data->meta_description;
        } else if (!$data->meta_description && $data->description) {
            $meta_description = $data->description;
        }
        $category->title = $data->title;
        $category->slug = $data->slug;
        $category->description = $data->description;
        $category->meta_description = $meta_description;
        $category->meta_keywords = $data->meta_keywords;
        $category->parent_id = $data->parent_id;
        $category->save();
        if(@$category->media[0]){
            $category->media()->update([
                'file_id' => $data->photo_id
            ]);
            if ($category->media[0]->file->id != intval($data->photo_id)) {
                $photo = $category->media[0]->file;
                $disk = 'public';
                $path = str_replace("/storage/", "", $photo->path);
                Storage::disk($disk)->delete($path);
                $photo->delete();
            }
        }else{
            $category->media()->create([
                'file_id' => $data->photo_id
            ]);
        }
        return $category;
    }

    public function destroy($id){
        $category = $this->getById($id);
        $status = 0;
        if (count($category->children) > 0) {
            $status = 0;
        } else {
            $category->delete();
            $status = 1;

        }

        return ['status'=>$status,'title'=>$category->title];
    }
}
