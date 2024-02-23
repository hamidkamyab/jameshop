<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Amazing\AmazingRepositoryInterface;
use App\Repositories\Category_Tab\CategoryTabRepositoryInterface;
use App\Repositories\Slider\SliderRepositoryInterface;
use App\Repositories\Style\StyleRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $slider;
    private $catTab;
    private $amazing;
    private $style;

    public function __construct(SliderRepositoryInterface $ISlider, CategoryTabRepositoryInterface $ICatTab, AmazingRepositoryInterface $IAmazing,StyleRepositoryInterface $IStyle)
    {
        $this->slider = $ISlider;
        $this->catTab = $ICatTab;
        $this->amazing = $IAmazing;
        $this->style = $IStyle;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = $this->slider->getAll();
        $catTabs = $this->catTab->getAll();
        $amazings = $this->amazing->getActive();
        $weekStyle = $this->style->getActive();

        return view('client.home.index',compact('sliders','catTabs','amazings','weekStyle'));
    }

}
