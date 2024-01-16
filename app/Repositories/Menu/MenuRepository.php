<?php

namespace App\Repositories\Menu;

use App\Events\MenuDeleting;
use App\Models\Menu;
use App\Repositories\BestMenu\BestMenuRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\File\FileRepository;

class MenuRepository implements MenuRepositoryInterface
{

    protected $file;
    protected $menu;
    protected $category;
    protected $bestMenu;

    public function __construct(FileRepository $FileRepository, Menu $menu, CategoryRepository $categoryRepository, BestMenuRepository $bestMenuRepository)
    {
        $this->file = $FileRepository;
        $this->category = $categoryRepository;
        $this->bestMenu = $bestMenuRepository;

        $this->menu = $menu;
    }

    public function getAll($page = false)
    {
        if($page){
            return $this->menu::with('parent','children')->where('parent_id', 0)->paginate(10);
        }else{
            return $this->menu::with('parent','children')->where('parent_id', 0)->get();
        }
    }

    public function getById($id)
    {
        return $this->menu::with('parent','children')->findOrFail($id);
    }

    public function store($data){
        $newMenu = new $this->menu();
        if ($data->is_cat && @$data->is_cat == '1') {
            $category = $this->category->getById($data->link_cat);
            $link = $category->slug;
            $newMenu->is_cat = 1;
        } else if (@$data->is_cat == '2') {
            $link = $data->link;
            $newMenu->is_cat = 2;
        } else {
            $newMenu->is_cat = 0;
        }
        $newMenu->title = $data->title;
        $newMenu->position = $data->position;
        $newMenu->link = @$link;
        $newMenu->color = @$data->color;
        if ($data->parent_id) {
            $newMenu->parent_id = $data->parent_id;
        } else {
            $newMenu->parent_id = 0;
        }
        if (@$data->best_status && $data->bests != null) {
            $newMenu->best = 1;
            $newMenu->best_title = $data->best_title;
            $newMenu->best_link = $data->best_link;
        }else if(@$data->best_status && $data->bests == null) {
            $status = 'error';
            return ['status' => $status , 'isMenu' => $newMenu];
        }
        $newMenu->save();
        if (@$data->best_status) {
            $this->bestMenu->store($data,$newMenu->id);
        }
        return $newMenu;
    }

    public function update($data,$id){

        $isMenu = $this->getById($id);
        $link = null;
        $color = null;
        if ($data->is_cat && $data->is_cat == '1') {
            $category = $this->category->getById($data->link_cat);
            $link = $category->slug;
            $isMenu->is_cat = 1;
        } else if ($data->is_cat == '2') {
            $link = $data->link;
            $isMenu->is_cat = 2;
        } else {
            $isMenu->is_cat = 0;
        }
        if (@$data->color) {
            $color = $data->color;
        }
        $isMenu->title = $data->title;
        $isMenu->position = $data->position;
        $isMenu->link = $link;
        $isMenu->color = $color;
        $isMenu->parent_id = $data->parent_id;
        $status = 'success';
        if (@$data->best_status && $data->bests != null) {
            $isMenu->best = 1;
            $isMenu->best_title = $data->best_title;
            $isMenu->best_link = $data->best_link;
        } else if(@$data->best_status && $data->bests == null) {
            $status = 'error';
            return ['status' => $status , 'isMenu' => $isMenu];
        }else{
            $isMenu->best = 0;
            $isMenu->best_title = null;
            $isMenu->best_link = null;
        }
        $isMenu->save();
        if (@$data->best_status) {
            $this->bestMenu->store($data,$isMenu->id);
        } else {
            $this->bestMenu->destroy($isMenu->id);
        }
        return ['status' => $status , 'isMenu' => $isMenu];
    }

    public function destroy($id){
        $isMenu = $this->getById($id);
        // اعلام رویداد حذف برای این منو
        event(new MenuDeleting($isMenu));
        // حذف رکورد از جدول menus
        $isMenu->delete();
        return $isMenu->title;
    }

}
