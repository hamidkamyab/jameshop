<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaFileController extends Controller
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
        $type = $file->getMimeType();
        $parts = explode('/', $type);
        if ($request->type != "all") {
            $validator = Validator::make($request->file(), [
                'file' => [
                    'required',
                    'mimes:' . $request->mimesFile,
                ]
            ]);
            if ($validator->fails()) {
                dd($validator->errors());
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }
        } else if ($request->type == "all") {
        } else {
            return response()->json([
                'errors' => 'پسوند فایل غیر مجاز است!',
            ], 422);
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $dir = 'public/brands';
        Storage::disk('local')->putFileAs($dir, $file, $fileName);
        $mediafile = new MediaFile();
        $mediafile->name = $fileName;
        $mediafile->path = '/storage/brands/' . $fileName;
        $mediafile->type = $file->getMimeType();
        // $photo->user_id = Auth::user()->id; //////////////////////////////////// Auth
        $mediafile->user_id = 1;
        $mediafile->save();
        return response()->json([
            'mediafile_id' => $mediafile->id,
            'path' => $mediafile->path,
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
     * Update the specified resource in storage.
     */
    public function remove(Request $request)
    {
        $File = MediaFile::findOrFail($request->id);
        $disk = 'public';
        $path = str_replace("/storage/", "", $File->path);
        Storage::disk($disk)->delete($path);
        $File->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
