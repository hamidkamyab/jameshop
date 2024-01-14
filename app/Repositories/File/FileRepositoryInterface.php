<?php
namespace App\Repositories\File;

interface FileRepositoryInterface {
    public function getById($id);
    public function destroy($id);
}
