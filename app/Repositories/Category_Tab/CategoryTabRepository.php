<?php

namespace App\Repositories\Category_Tab;

use App\Models\CategoryTab;
use App\Repositories\File\FileRepository;

class CategoryTabRepository implements CategoryTabRepositoryInterface
{
    protected $file;
    protected $catTab;

    public function __construct(FileRepository $FileRepository, CategoryTab $categoryTab)
    {
        $this->file = $FileRepository;
        $this->catTab = $categoryTab;
    }

    public function getAll($page = false)
    {
        if ($page) {
            return $this->catTab->paginate($page);
        } else {
            return $this->catTab->paginate(30);
        }
    }

    public function getById($id)
    {
        return  $this->catTab::with('media.file')->findOrFail($id);
    }

    public function store($data, $parent = 0)
    {
        $newCatTab = new $this->catTab();
        $newCatTab->title = $data->title;
        $newCatTab->category_id = $data->category_id;
        $newCatTab->parent_id = $parent;
        $newCatTab->save();

        if ($parent != 0) {
            if ($data->photosId != null) {
                $newCatTab->media()->create([
                    'file_id' => $data->photosId
                ]);
            }
        }

    }

    public function update($data, $id)
    {
        $isCatTab = $this->getById($id);
        $isCatTab->title = $data->title;
        $isCatTab->category_id = $data->category_id;
        if (@$isCatTab->media[0]) {
            if ($data->photosId != null) {
                $isCatTab->media()->update([
                    'file_id' => $data->photosId
                ]);
            }
            if (intval($data->photosId) != $isCatTab->media[0]->file_id || $data->photosId == null) {
                $photo = $isCatTab->media[0]->file_id;
                $this->file->destroy($photo);
            }
        } else {
            if (@$data->photosId != null) {
                $isCatTab->media()->create([
                    'file_id' => $data->photosId
                ]);
            }
        }
        $isCatTab->save();
    }


    public function destroy($id)
    {
        $isCatTab = $this->getById($id);
        if (@$isCatTab->media[0] && count($isCatTab->media) > 0) {
            $photo = $isCatTab->media[0]->file_id;
            $this->file->destroy($photo);
        }
        $isCatTab->delete();
        return $isCatTab->title;
    }
}
