<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandRepository implements BrandRepositoryInterface
{

    public function getAll()
    {
        return  Brand::with('media.file')->paginate(30);
    }

    public function getById($id)
    {
        return  Brand::with('media.file')->findOrFail($id);
    }

    public function store($data){
        $brand = new Brand();
        $brand->title = $data->title;
        $brand->description = $data->description;
        $brand->save();
        $brand->media()->create([
            'file_id' => $data->photo_id
        ]);
        return $brand;
    }

    public function update($data,$id){
        $brand = $this->getById($id);
        $brand->title = $data->title;
        $brand->description = $data->description;
        $brand->save();
        if(@$brand->media[0]){
            $brand->media()->update([
                'file_id' => $data->photo_id
            ]);
            if (intval($data->photo_id) != $brand->media[0]->file->id) {
                $photo = $brand->media[0]->file;
                $disk = 'public';
                $path = str_replace("/storage/", "", $photo->path);
                Storage::disk($disk)->delete($path);
                $photo->delete();
            }
        }else{
            $brand->media()->create([
                'file_id' => $data->photo_id
            ]);
        }
        return $brand;
    }

    public function destroy($id){
        $brand = $this->getById($id);
        $photo = $brand->media[0]->file;
        $disk = 'public';
        $path = str_replace("/storage/", "", $photo->path);
        Storage::disk($disk)->delete($path);
        $brand->delete();
        $photo->delete();

        return $brand->title;
    }
}
