<?php

namespace App\Listeners;

use App\Events\MenuDeleting;
use App\Models\BestMenu;
use App\Models\File as M_File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DeleteSubMenuItems implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MenuDeleting $event)
    {
        // حذف همه زیرمنوها
        $event->menu->children()->each(function ($subMenu) {
            event(new MenuDeleting($subMenu));
        });

        // اگر مقدار فیلد best برابر با 1 باشد
        if ($event->menu->best == 1) {
            $bestMenu = BestMenu::with('media')->where('menu_id', $event->menu->id)->get();

            $bestMenu->each(function ($bm) {

                $bm->media->each(function ($file) {
                    $file->file_id;

                    $File = M_File::findOrFail($file->file_id);

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

                });
            });
        }

        $event->menu->delete();
    }
}
