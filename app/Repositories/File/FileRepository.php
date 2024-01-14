<?php

namespace App\Repositories\File;

use App\Models\File as M_File;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface
{
    protected $file;

    public function __construct(M_File $file)
    {
        $this->file = $file;
    }

    public function getById($id)
    {
        return  $this->file::findOrFail($id);
    }

    public function destroy($id)
    {
        $File = $this->getById($id);
        // $Media = Media::where('file_id', $id)->get();
        $disk = 'public';
        $path = str_replace("/storage/", "", $File->path);
        Storage::disk($disk)->delete($path);
        if ($File->thumbnail != null) {
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
            'status' => 'success',
            // 'media' => $Media
        ]);
    }
}
