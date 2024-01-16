<?php

namespace App\Repositories\File;

use App\Models\File as M_File;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

    public function upload($data){
        $file = $data->file('file');
        $type = $file->getMimeType();
        $parts = explode('/', $type);



        $fileName = time() . '_' . $file->getClientOriginalName();
        $dir = 'public/' . $data->folder;

        $m_file = new $this->file();

        if (@$data->thumbnail == 'true') {
            $path = str_replace("public/", "app/public/",$dir);
            $thumbnailPath = storage_path($path.'/thumbnail/');

            $thumbnail = $data->folder.'/thumbnail/'.$fileName;
            $m_file->thumbnail = $thumbnail;
        }

        $m_file->name = $fileName;
        $m_file->path = $data->folder . '/' . $fileName;
        $m_file->type = $parts[0];
        $m_file->size = $file->getSize();
        if($data->is_dir){
            $m_file->is_dir = $data->is_dir;
        }
        // $photo->user_id = Auth::user()->id; //////////////////////////////////// Auth
        $m_file->user_id = 1;
        $result = $m_file->save();

        if($result){
            ///////ذخیره تصویر اصلی و بند انگشتی//////
            Storage::disk('local')->putFileAs($dir, $file, $fileName);
            if (@$data->thumbnail == 'true') {
                File::makeDirectory($thumbnailPath, $mode = 0775, true, true);
                // ایجاد تصویر از تصویر اصلی
                $image = Image::make($file);
                // ایجاد تصویر thumbnail
                $image->fit(200, 200)->save($thumbnailPath.$fileName);
            }
            ///////ذخیره تصویر اصلی و بند انگشتی//////
        }

        return ['id' => $m_file->id,'path' => $m_file->path,'thumbnail' => $m_file->thumbnail];

    }

    public function destroy($id)
    {

        $File = $this->getById($id);
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
        ]);
    }
}
