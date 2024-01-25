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
    }

    public function getById($id)
    {
    }

    public function store($data)
    {
        $newAMZ = new $this->amazing();
        $newAMZ->start = $data->start;
        $newAMZ->end = $data->end;
        $newAMZ->save();
        $newAMZ->media()->create([
            'file_id' => $data->photosId
        ]);

        $list = explode(',', $data->list);
        $newAMZ->products()->attach($list);

    }

    public function update($data, $id)
    {
    }

    public function destroy($id)
    {
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
