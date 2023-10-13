<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $dir = 'public/brands';
        Storage::disk('local')->putFileAs($dir,$file,$fileName);
        $photo = new Photo();
        $photo->name = $fileName;
        $photo->path = '/storage/brands/'.$fileName;
        // $photo->user_id = Auth::user()->id; //////////////////////////////////// Auth
        $photo->user_id =1;
        $photo->save();
        return response()->json([
            'photo_id' => $photo->id,
            'path' => $photo->path,
        ]);
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
