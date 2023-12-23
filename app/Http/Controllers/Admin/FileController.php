<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File as M_File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class FileController extends Controller
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
        $m_file = new M_File();

        if (@$request->thumbnail == 'true') {
            $path = str_replace("public/", "app/public/",$dir);
            $thumbnailPath = storage_path($path.'/thumbnail/');
            File::makeDirectory($thumbnailPath, $mode = 0775, true, true);
            // ایجاد تصویر از تصویر اصلی
            $image = Image::make($file);
            // ایجاد تصویر thumbnail
            $image->fit(200, 200)->save($thumbnailPath.$fileName);
            $thumbnail = $request->folder.'/thumbnail/'.$fileName;
            $m_file->thumbnail = $thumbnail;
        }

        $m_file->name = $fileName;
        $m_file->path = $request->folder . '/' . $fileName;
        $m_file->type = $parts[0];
        $m_file->size = $file->getSize();
        if($request->is_dir){
            $m_file->is_dir = $request->is_dir;
        }
        // $photo->user_id = Auth::user()->id; //////////////////////////////////// Auth
        $m_file->user_id = 1;
        $m_file->save();
        return response()->json([
            'file_id' => $m_file->id,
            'path' => $m_file->path,
            'thumbnail' => $m_file->thumbnail,
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
        $File = M_File::findOrFail($request->id);
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
