<?php

namespace App\Repositories\Amazing;

use App\Models\Amazing;
use App\Models\Product;
use App\Repositories\File\FileRepository;

class AmazingRepository implements AmazingRepositoryInterface
{
    protected $file;
    protected $product;
    protected $amazing;

    public function __construct(FileRepository $FileRepository, Amazing $amazing, Product $product)
    {
        $this->file = $FileRepository;
        $this->product = $product;
        $this->amazing = $amazing;
    }

    public function getAll($page = false)
    {
        return $this->amazing->paginate(30);
    }

    public function getById($id)
    {
        return  $this->amazing::with('media.file','products')->findOrFail($id);
    }

    public function store($data)
    {
        $newAMZ = new $this->amazing();
        $newAMZ->start = convertJtoM($data->start);//تبدیل تاریخ جلالی به میلادی
        $newAMZ->end = convertJtoM($data->end);//تبدیل تاریخ جلالی به میلادی
        $newAMZ->save();
        if($data->photosId != null){
            $newAMZ->media()->create([
                'file_id' => $data->photosId
            ]);
        }

        $list = explode(',', $data->list);
        $newAMZ->products()->attach($list);
    }

    public function update($data, $id)
    {
        // $isAMZ = $this->getById($id);
        // $isAMZ->start = convertJtoM($data->start);//تبدیل تاریخ جلالی به میلادی
        // $isAMZ->end = convertJtoM($data->end);//تبدیل تاریخ جلالی به میلادی
        // $isAMZ->save();
        // if($data->photosId != null){
        //     $isAMZ->media()->create([
        //         'file_id' => $data->photosId
        //     ]);
        // }

        // $list = explode(',', $data->list);
        // $isAMZ->products()->attach($list);
    }

    public function destroy($id)
    {
        $isAMZ = $this->getById($id);
        if(@$isAMZ->media[0] && count($isAMZ->media) > 0 ){
            $photo = $isAMZ->media[0]->file_id;
            $this->file->destroy($photo);
        }
        $isAMZ->delete();
    }

    public function search($data)
    {
        return $this->product::with('media.file')->where('sku', 'like', "%$data->val%")
            ->where('status', 1)
            ->orWhere('title', 'like', "%$data->val%")
            ->where('status', 1)
            ->get();
    }
}
