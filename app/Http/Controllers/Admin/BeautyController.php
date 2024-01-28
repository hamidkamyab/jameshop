<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Beauty\BeautyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BeautyController extends Controller
{
    private $beauty;
    public function __construct(BeautyRepositoryInterface $IBeautyRepository)
    {
        $this->beauty = $IBeautyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beauties = $this->beauty->getAll();
        return view('admin.widget.beauties.index',compact('beauties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.widget.beauties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->beauty->store($request);
        Session::flash('opration_beauty','با موفقیت اضافه شد!');
        return redirect()->route('beauties.index');
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
