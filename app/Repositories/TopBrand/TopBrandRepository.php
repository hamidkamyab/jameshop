<?php

namespace App\Repositories\TopBrand;

use App\Models\TopBrand;
use App\Models\Product;
use App\Repositories\File\FileRepository;

class TopBrandRepository implements TopBrandRepositoryInterface
{
    protected $file;
    protected $product;
    protected $topBrand;

    public function __construct(FileRepository $FileRepository, TopBrand $topBrand, Product $product)
    {
        $this->file = $FileRepository;
        $this->product = $product;
        $this->topBrand = $topBrand;
    }

    public function getAll($page = false)
    {
        if ($page) {
            return $this->topBrand->paginate($page);
        } else {
            return $this->topBrand->paginate(30);
        }
    }

    public function getById($id)
    {
        return  $this->topBrand::with('media.file','products')->findOrFail($id);
    }

    public function store($data)
    {
        $newTB = new $this->topBrand();
        $newTB->brand_id = $data->brand_id;
        $newTB->save();
        if($data->photosId != null){
            $newTB->media()->create([
                'file_id' => $data->photosId
            ]);
        }

        $list = explode(',', $data->list);
        $newTB->products()->attach($list);
    }

    public function update($data, $id)
    {
        $isTB = $this->getById($id);
        $isTB->brand_id = $data->brand_id;

        if(@$isTB->media[0]){
            if($data->photosId != null){
                $isTB->media()->update([
                    'file_id' => $data->photosId
                ]);
            }
            if (intval($data->photosId) != $isTB->media[0]->file_id || $data->photosId == null) {
                $photo = $isTB->media[0]->file_id;
                $this->file->destroy($photo);
            }
        }else{
            $isTB->media()->create([
                'file_id' => $data->photosId
            ]);
        }
        $isTB->save();
        $list = explode(',', $data->list);
        $isTB->products()->sync($list);
    }

    public function destroy($id)
    {
        $isTB = $this->getById($id);
        if(@$isTB->media[0] && count($isTB->media) > 0 ){
            $photo = $isTB->media[0]->file_id;
            $this->file->destroy($photo);
        }
        $isTB->delete();
    }

    public function search($id)
    {
        return $this->product::with('sizes', 'colors','category', 'brand', 'media.file')->where('brand_id',$id)->get();
    }
}
