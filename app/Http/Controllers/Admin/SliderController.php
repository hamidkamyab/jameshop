<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Slider\SliderRepositoryInterface;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    private $slider;

    public function __construct(SliderRepositoryInterface $ISliderRepository)
    {
        $this->slider = $ISliderRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider = $this->slider->getAll();
        return view('admin.widget.slider',compact('slider'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->slider->store($request);
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->slider->destroy($id);
        return redirect()->back();
    }
}
