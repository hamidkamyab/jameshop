<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AmazingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.widget.amazing_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {
        $data = null;
        if ($request->val != null || $request->val != '') {
            $data = Product::with('media.file')->where('sku', 'like', "%$request->val%")
                ->where('status', 1)
                ->orWhere('title', 'like', "%$request->val%")
                ->where('status', 1)
                ->get();
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
