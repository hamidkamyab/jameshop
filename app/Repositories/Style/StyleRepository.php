<?php

namespace App\Repositories\Style;

use App\Models\Style;
use App\Models\Product;
use App\Repositories\File\FileRepository;

class StyleRepository implements StyleRepositoryInterface
{
    protected $file;
    protected $product;
    protected $style;

    public function __construct(FileRepository $FileRepository, Style $style, Product $product)
    {
        $this->file = $FileRepository;
        $this->product = $product;
        $this->style = $style;
    }

    public function getAll($page = false)
    {
        if ($page) {
            return $this->style->paginate($page);
        } else {
            return $this->style->paginate(30);
        }
    }

    public function getById($id)
    {
        return  $this->style::with('media.file', 'products')->findOrFail($id);
    }

    public function store($data)
    {
        $newStyle = new $this->style();
        $newStyle->title = $data->title;
        $newStyle->date = convertJtoM($data->date); //تبدیل تاریخ جلالی به میلادی
        $newStyle->save();
        if ($data->photosId != null) {
            $newStyle->media()->create([
                'file_id' => $data->photosId
            ]);
        }

        $list = explode(',', $data->list);
        $newStyle->products()->attach($list);
    }

    public function update($data, $id)
    {
        $isStyle = $this->getById($id);
        $isStyle->start = convertJtoM($data->start); //تبدیل تاریخ جلالی به میلادی
        $isStyle->end = convertJtoM($data->end); //تبدیل تاریخ جلالی به میلادی

        if (@$isStyle->media[0]) {
            if ($data->photosId != null) {
                $isStyle->media()->update([
                    'file_id' => $data->photosId
                ]);
            }
            if (intval($data->photosId) != $isStyle->media[0]->file_id || $data->photosId == null) {
                $photo = $isStyle->media[0]->file_id;
                $this->file->destroy($photo);
            }
        } else {
            $isStyle->media()->create([
                'file_id' => $data->photosId
            ]);
        }
        $isStyle->save();
        $list = explode(',', $data->list);
        $isStyle->products()->sync($list);
    }

    public function destroy($id)
    {
        $isStyle = $this->getById($id);
        if (@$isStyle->media[0] && count($isStyle->media) > 0) {
            $photo = $isStyle->media[0]->file_id;
            $this->file->destroy($photo);
        }
        $isStyle->delete();
    }
}
