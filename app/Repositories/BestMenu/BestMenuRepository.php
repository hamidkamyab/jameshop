<?php

namespace App\Repositories\BestMenu;

use App\Models\BestMenu;

class BestMenuRepository implements BestMenuRepositoryInterface
{

    protected $bestMenu;

    public function __construct(BestMenu $bestMenu)
    {
        $this->bestMenu = $bestMenu;
    }

    public function getByMenuId($id)
    {
        $bestMenu = $this->bestMenu::with('media.file')->where('menu_id', $id)->get();
        return  $bestMenu;
    }

    public function destroy($id)
    {
        $bestMenu =  $this->getByMenuId($id);
        foreach ($bestMenu as $best) {
            $best->media()->delete();
            $best->delete();
        }
    }

    public function store($data,$menuId){
        $bests = explode(',', $data->bests);
        $this->destroy($menuId);
        foreach ($bests as $best) {
            $bl = 'link-' . $best;
            $bestMenu = new $this->bestMenu();
            $bestMenu->menu_id = $menuId;
            $bestMenu->link = $data->$bl;
            $bestMenu->save();
            $bestMenu->media()->create([
                'file_id' => intval($best)
            ]);
        }
    }

}
