<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Amazing\AmazingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class AmazingController extends Controller
{

    private $amazing;

    public function __construct(AmazingRepositoryInterface $IAmazingRepository)
    {
        $this->amazing = $IAmazingRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amazings = $this->amazing->getAll();
        return view('admin.widget.amazings.index',compact('amazings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.widget.amazings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->amazing->store($request);
        return redirect()->route('amazings.index');
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
        $amazing = $this->amazing->getById($id);
        return view('admin.widget.amazings.edit',compact('amazing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->amazing->update($request,$id);
        Session::flash('opration_amazing', 'شگفت آویز مد نظر با موفقیت ویرایش شد!');
        return redirect()->route('amazings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->amazing->destroy($id);
        Session::flash('opration_amazing', 'شگفت آویز مد نظر با موفقیت حذف شد!');
        return redirect()->route('amazings.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {
        $data = null;
        if ($request->val != null || $request->val != '') {
            $data = $this->amazing->search($request);
            if (count($data) > 0) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }else{
            $status = 'error';
        }

        return response()->json(['status' => $status, 'products' => $data], Response::HTTP_OK);
    }
}
