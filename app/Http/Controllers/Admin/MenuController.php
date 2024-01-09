<?php

namespace App\Http\Controllers\Admin;

use App\Events\MenuDeleting;
use App\Http\Controllers\Controller;
use App\Models\BestMenu;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('parent')->where('parent_id', 0)->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id', null)->get();
        $menus = Menu::with('children')->where('parent_id', 0)->get();
        return view('admin.menus.create', compact('categories', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $menu = new Menu();

        if ($request->is_cat && @$request->is_cat == '1') {
            $category = Category::findOrFail($request->link_cat);
            $link = $category->slug;
            $menu->is_cat = 1;
        } else if (@$request->is_cat == '2') {
            $link = $request->link;
            $menu->is_cat = 2;
        } else {
            $menu->is_cat = 0;
        }
        $menu->title = $request->title;
        $menu->position = $request->position;
        $menu->link = @$link;
        $menu->color = @$request->color;
        if ($request->parent_id) {
            $menu->parent_id = $request->parent_id;
        } else {
            $menu->parent_id = 0;
        }
        if (@$request->best_status) {
            $menu->best = 1;
            $menu->best_title = $request->best_title;
            $menu->best_link = $request->best_link;
        }
        $menu->save();
        if (@$request->best_status) {
            $bests = explode(',', $request->bests);
            foreach ($bests as $best) {
                $bl = 'link-' . $best;
                $bestMenu = new BestMenu();
                $bestMenu->menu_id = $menu->id;
                $bestMenu->link = $request->$bl;
                $bestMenu->save();
                $bestMenu->media()->create([
                    'file_id' => intval($best)
                ]);
            }
        }
        return redirect()->route('menus.index');
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
        $menu = Menu::with('parent')->findOrFail($id);
        $categories = Category::with('children')->where('parent_id', null)->get();
        $menus = Menu::with('children')->where('parent_id', 0)->get();
        return view('admin.menus.edit', compact('menu', 'categories', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);
        $link = null;
        $color = null;
        if ($request->is_cat && @$request->is_cat == '1') {
            $category = Category::findOrFail($request->link_cat);
            $link = $category->slug;
            $menu->is_cat = 1;
        } else if (@$request->is_cat == '2') {
            $link = $request->link;
            $menu->is_cat = 2;
        } else {
            $menu->is_cat = 0;
        }
        if (@$request->color) {
            $color = $request->color;
        }
        $menu->title = $request->title;
        $menu->position = $request->position;
        $menu->link = $link;
        $menu->color = $color;
        $menu->parent_id = $request->parent_id;
        if (@$request->best_status) {
            $menu->best = 1;
            $menu->best_title = $request->best_title;
            $menu->best_link = $request->best_link;
        } else {
            $menu->best = 0;
            $menu->best_title = null;
            $menu->best_link = null;
        }
        $menu->save();
        if (@$request->best_status) {
            $bests = explode(',', $request->bests);
            foreach ($bests as $best) {
                $bl = 'link-' . $best;
                $bestMenu = new BestMenu();
                $bestMenu->menu_id = $menu->id;
                $bestMenu->link = $request->$bl;
                $bestMenu->save();
                $bestMenu->media()->create([
                    'file_id' => intval($best)
                ]);
            }
        } else {
            BestMenu::where('menu_id', $id)->delete();
        }
        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::with('children')->find($id);

        // اعلام رویداد حذف برای این منو
        event(new MenuDeleting($menu));
        // حذف رکورد از جدول menus
        $menu->delete();

        return redirect()->route('menus.index');
    }

    public function bestMenu_destroy(string $id, $status = null)
    {
        if ($status == 'multi') {
            BestMenu::where('menu_id', $id)->delete();
        } else {
            BestMenu::findOrFail($id)->delete();
        }
    }
    public function photos(string $id)
    {
        $bestMenu = BestMenu::with('media.file')->where('menu_id', $id)->get();
        return  response()->json(['status' => 'success', 'data' => $bestMenu], Response::HTTP_OK);
    }
}
