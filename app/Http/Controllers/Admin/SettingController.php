<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Setting\SettingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    private $category;
    private $setting;
    public function __construct(CategoryRepositoryInterface $ICategoryRepository, SettingRepositoryInterface $ISettingRepository)
    {
        $this->category = $ICategoryRepository;
        $this->setting = $ISettingRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->category->getAll();
        $data = $this->setting->getAll();
        $setting = [];
        foreach ($data as $value) {
            $setting[$value->title] = $value->value;
        }
        return view('admin.settings.index', compact('categories','setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $giftCat = $request->Setting_GiftCat;
        if(!$request->giftCheck){
            $giftCat = null;
        }

        $settings = [
            'Setting_SiteTitle' => $request->Setting_SiteTitle,
            'Setting_Keywords' => make_slug($request->Setting_Keywords),
            'Setting_MetaDescription' => $request->Setting_MetaDescription,
            'Setting_GiftCat' => $giftCat,
        ];
        $this->setting->store($settings);
        Session::flash('opration_setting','تنظیمات با موفقیت ذخیره شد!');
        return redirect()->back();
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
