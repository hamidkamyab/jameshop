<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BestMenu;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('parent')->where('parent_id', 0)->paginate(10);
        return view('admin.menus.index',compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id', null)->get();
        $menus = Menu::with('children')->where('parent_id', 0)->get();
        return view('admin.menus.create',compact('categories','menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $menu = new Menu();

        if($request->link_option && @$request->link_option == 'categoryLink'){
            $category = Category::findOrFail($request->link_cat);
            $link = $category->slug;
            $menu->is_cat = 1;
        }else{
            $link = $request->link;
            $menu->is_cat = 0;
        }
        $menu->title = $request->title;
        $menu->position = $request->position;
        $menu->link = $link;
        $menu->color = @$request->color;
        $menu->parent_id = @$request->parent_id;
        if(@$request->best_status){
            $menu->best = 1;
            $menu->best_title = $request->best_title;
            $menu->best_link = $request->best_link;
        }
        $menu->save();
        if(@$request->best_status){
            $bests = explode(',',$request->bests);
            foreach($bests as $best){
                $bl = 'link-'.$best;
                $bestMenu = new BestMenu();
                $bestMenu->menu_id = $menu->id;
                $bestMenu->link = $request->$bl;
                $bestMenu->save();
                $bestMenu->media()->create([
                    'file_id' => intval($best)
                ]);
            }
        }
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
