<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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

            //

        } else {
            return response()->json([
                'errors' => 'پسوند فایل غیر مجاز است!',
            ], 422);
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $dir = 'public/' . $request->folder;

        Storage::disk('local')->putFileAs($dir, $file, $fileName);
        $mediafile = new MediaFile();

        if (@$request->thumbnail == 'true') {
            $path = str_replace("public/", "app/public/",$dir);
            $thumbnailPath = storage_path($path.'/thumbnail/');
            File::makeDirectory($thumbnailPath, $mode = 0775, true, true);
            // ایجاد تصویر از تصویر اصلی
            $image = Image::make($file);
            // ایجاد تصویر thumbnail
            $image->fit(200, 200)->save($thumbnailPath.$fileName);
            $thumbnail = $request->folder.'/thumbnail/'.$fileName;
            $mediafile->thumbnail = $thumbnail;
        }

        $mediafile->name = $fileName;
        $mediafile->path = $request->folder . '/' . $fileName;
        $mediafile->type = $parts[0];
        // $photo->user_id = Auth::user()->id; //////////////////////////////////// Auth
        $mediafile->user_id = 1;
        $mediafile->save();
        return response()->json([
            'mediafile_id' => $mediafile->id,
            'path' => $mediafile->path,
            'thumbnail' => $mediafile->thumbnail,
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
        if($File->thumbnail != null){
            $thumbnailPath = str_replace("/storage/", "", $File->thumbnail);
            Storage::disk($disk)->delete($thumbnailPath);
        }
        $dir = $disk . '/' . str_replace($File->name, "", $path);
        if (Storage::exists($dir)) {
            $files = Storage::allFiles($dir);
            if (count($files) == 0) {
                Storage::deleteDirectory($dir);
            }
        }
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
