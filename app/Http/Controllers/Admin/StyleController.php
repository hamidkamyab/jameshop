<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Style\StyleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StyleController extends Controller
{
    private $style;

    public function __construct(StyleRepositoryInterface $IStyleRepository)
    {
        $this->style = $IStyleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $styles = $this->style->getAll();
        return view('admin.widget.styles.index',compact('styles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.widget.styles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->style->store($request);
        Session::flash('opration_style', 'استایل هغته نظر با موفقیت اضافه شد!');
        return redirect()->route('styles.index');
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
