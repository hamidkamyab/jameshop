<?php

namespace App\Repositories\Slider;

use App\Models\Media;
use App\Models\Slider;
use App\Repositories\File\FileRepository;

class SliderRepository implements SliderRepositoryInterface
{

    protected $file;
    protected $slider;
    protected $media;

    public function __construct(FileRepository $FileRepository, Slider $slider,Media $media)
    {
        $this->file = $FileRepository;
        $this->slider = $slider;
        $this->media = $media;
    }

    public function getAll($page = false)
    {
        return $this->slider::with('media.file')->get();
    }

    public function getById($id)
    {
        return $this->slider::with('media.file')->findOrFail($id);
    }

    public function store($data){
        $Ids = explode(',', $data->photosId);
        $this->slider::truncate();
        $this->media::where('mediable_type', $this->slider::class)->delete();
        foreach ($Ids as $key => $id) {
            $sl = 'link-' . $id;
            $sort = 'num-' . $id;

            $slider = new $this->slider();
            $slider->link = $data[$sl];
            $slider->sort = $data[$sort];
            $slider->status = 1;
            $slider->save();
            $slider->media()->create([
                'file_id' => intval($id)
            ]);
        }

        return $Ids;
    }


    public function destroy($id){
        $isSlide = $this->getById($id);
        $photo = $isSlide->media[0]->file;
        $this->file->destroy($photo->id);
        $isSlide->delete();
    }
}
