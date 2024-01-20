<?php

namespace App\Repositories\Slider;

use App\Models\Slider;
use App\Repositories\File\FileRepository;

class SliderRepository implements SliderRepositoryInterface
{

    protected $file;
    protected $slider;

    public function __construct(FileRepository $FileRepository, Slider $Slider)
    {
        $this->file = $FileRepository;
        $this->slider = $Slider;
    }

    public function getAll($page = false)
    {
        return $this->slider::with('media.file')->get();
    }

    public function getById($id)
    {

    }

    public function store($data){

        $Ids = explode(',', $data->photosId);
        foreach ($Ids as $key => $id) {
            $sl = 'link-' . $id;
            $sort = 'num-' . $id;
            $slider = new $this->slider();
            $slider->link = $data->$sl;
            $slider->sort = $data->$sort;
            $slider->status = 1;
            $slider->save();
            $slider->media()->create([
                'file_id' => intval($id)
            ]);
        }
        return $Ids;
    }

    public function update($data,$id){

    }

    public function destroy($id){

    }
}
