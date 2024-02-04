<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\File\FileRepository;

class BrandRepository implements BrandRepositoryInterface
{

    protected $file;
    protected $brand;

    public function __construct(FileRepository $FileRepository, Brand $brand)
    {
        $this->file = $FileRepository;
        $this->brand = $brand;
    }

    public function getAll($page = false)
    {
        if($page){
            return  $this->brand::with('media.file','country')->paginate(30);
        }else{
            return  $this->brand::with('media.file','country')->get();
        }
    }

    public function getById($id)
    {
        return  $this->brand::with('media.file')->findOrFail($id);
    }

    public function store($data){
        $newBrand = new $this->brand();
        $newBrand->title = $data->title;
        $newBrand->country_id = $data->country_id;
        $newBrand->description = $data->description;
        $newBrand->save();
        $newBrand->media()->create([
            'file_id' => $data->photo_id
        ]);
        return $newBrand;
    }

    public function update($data,$id){
        $isBrand = $this->getById($id);
        $isBrand->title = $data->title;
        $isBrand->country_id = $data->country_id;
        $isBrand->description = $data->description;
        $isBrand->save();
        if(@$isBrand->media[0]){
            $isBrand->media()->update([
                'file_id' => $data->photo_id
            ]);
            if (intval($data->photo_id) != $isBrand->media[0]->file->id) {
                $photo = $isBrand->media[0]->file;
                $this->file->destroy($photo->id);
            }
        }else{
            $isBrand->media()->create([
                'file_id' => $data->photo_id
            ]);
        }
        return $isBrand;
    }

    public function destroy($id){
        $isBrand = $this->getById($id);
        $photo = $isBrand->media[0]->file;
        $this->file->destroy($photo->id);
        $isBrand->delete();
        return $isBrand->title;
    }
}
