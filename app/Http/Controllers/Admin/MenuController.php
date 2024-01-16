<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BestMenu\BestMenuRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Menu\MenuRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{

    protected $menu;
    protected $bestMenu;
    protected $category;

    public function __construct(MenuRepositoryInterface $menu, CategoryRepositoryInterface $category, BestMenuRepositoryInterface $bestMenu)
    {
        $this->menu = $menu;
        $this->bestMenu = $bestMenu;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = $this->menu->getAll(20);
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->getAll();
        $menus = $this->menu->getAll();
        return view('admin.menus.create', compact('categories', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->menu->store($request);
        if($result['status'] == 'error'){
            $msg = ['وقتی گزینه برترین برندها را فعال کنید، شما باید 4 تصویر از برترین برند ها قرار دهید!'];
            Session::flash('errors', collect($msg));
            return redirect()->back();
        }else{
            Session::flash('opration_menu', 'منو ' . $request->title . ' با موفقیت ثبت شد.');
            return redirect()->route('menus.index');
        }
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
        $menu = $this->menu->getById($id);
        $categories =  $this->category->getAll();
        $menus = $this->menu->getAll();
        return view('admin.menus.edit', compact('menu', 'categories', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = $this->menu->update($request,$id);
        if($result['status'] == 'error'){
            $msg = ['وقتی گزینه برترین برندها را فعال کنید، شما باید 4 تصویر از برترین برند ها قرار دهید!'];
            Session::flash('errors', collect($msg));
            return redirect()->back();
        }else{
            Session::flash('opration_menu', 'منو ' . $request->title . ' با موفقیت ویرایش شد.');
            return redirect()->route('menus.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->menu->destroy($id);
        Session::flash('opration_menu', 'منو ' . $result . ' با موفقیت حذف شد.');
        return redirect()->route('menus.index');
    }

    public function bestMenu_destroy(string $id, $status = null)
    {
        $this->bestMenu->destroy($id,$status);
    }
    public function photos(string $id)
    {
        $bestMenu = $this->bestMenu->getByMenuId($id);
        return  response()->json(['status' => 'success', 'data' => $bestMenu], Response::HTTP_OK);
    }
}
