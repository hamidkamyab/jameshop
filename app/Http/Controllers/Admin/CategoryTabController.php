<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category_Tab\CategoryTabRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryTabController extends Controller
{

    private $category;
    private $catTab;

    public function __construct(CategoryRepositoryInterface $ICategoryRepository,CategoryTabRepositoryInterface $ICategoryTabRepository)
    {
        $this->category = $ICategoryRepository;
        $this->catTab = $ICategoryTabRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catTabs = $this->catTab->getAll();
        return view('admin.widget.category_tabs.index',compact('catTabs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->getAll();
        return view('admin.widget.category_tabs.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->catTab->store($request);
        Session::flash('opration_catTab','برگه '.$request->title.' ثبت شد!');
        return redirect()->route('category_tabs.index');
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
        $catTab = $this->catTab->getById($id);
        $categories = $this->category->getAll();
        return view('admin.widget.category_tabs.edit',compact('catTab','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->catTab->update($request,$id);
        Session::flash('opration_catTab','برگه '.$request->title.' ثبت شد!');
        return redirect()->route('category_tabs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->catTab->destroy($id);
        Session::flash('opration_catTab','برگه '.$result.' با موفقیت حذف شد!');
        return redirect()->route('category_tabs.index');
    }
}
