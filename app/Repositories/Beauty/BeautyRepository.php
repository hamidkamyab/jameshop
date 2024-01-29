<?php

namespace App\Repositories\Beauty;

use App\Models\Beauty;
use App\Repositories\File\FileRepository;

class BeautyRepository implements BeautyRepositoryInterface
{
    protected $file;
    protected $product;
    protected $beauty;

    public function __construct(FileRepository $FileRepository, Beauty $beauty)
    {
        $this->file = $FileRepository;
        $this->beauty = $beauty;
    }

    public function getAll($page = false)
    {
        if ($page) {
            return $this->beauty->paginate($page);
        } else {
            return $this->beauty->paginate(30);
        }
    }

    public function getById($id)
    {
        return  $this->beauty::with('media.file')->findOrFail($id);
    }

    public function store($data)
    {
        $newBeauty = new $this->beauty();
        $newBeauty->title = $data->title;
        $newBeauty->link = $data->link;
        $newBeauty->save();
        if ($data->photosId != null) {
            $newBeauty->media()->create([
                'file_id' => $data->photosId
            ]);
        }
    }

    public function update($data, $id)
    {
        $isBeauty = $this->getById($id);
        $isBeauty->title = $data->title;
        $isBeauty->link = $data->link;

        if (@$isBeauty->media[0]) {
            if ($data->photosId != null) {
                $isBeauty->media()->update([
                    'file_id' => $data->photosId
                ]);
            }
            if (intval($data->photosId) != $isBeauty->media[0]->file_id || $data->photosId == null) {
                $photo = $isBeauty->media[0]->file_id;
                $this->file->destroy($photo);
            }
        } else {
            $isBeauty->media()->create([
                'file_id' => $data->photosId
            ]);
        }
        $isBeauty->save();

    }

    public function destroy($id)
    {
        $isBeauty = $this->getById($id);
        if (@$isBeauty->media[0] && count($isBeauty->media) > 0) {
            $photo = $isBeauty->media[0]->file_id;
            $this->file->destroy($photo);
        }
        $isBeauty->delete();
        return $isBeauty->title;
    }
}
