<?php
namespace App\Repositories\File;

interface FileRepositoryInterface {
    public function getById($id);
    public function upload($data);
    public function destroy($id);
}
