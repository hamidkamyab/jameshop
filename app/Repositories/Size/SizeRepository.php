<?php

namespace App\Repositories\Size;

use App\Models\Size;

class SizeRepository implements SizeRepositoryInterface{

    protected $size;

    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    public function getAll($page = false)
    {
        if($page){
            return $this->size::paginate(20);
        }else{
            return $this->size::all();
        }
    }

    public function getById($id){
        return $this->size::findOrFail($id);
    }

    public function store($data){
        $size = new $this->size();
        $size->title = $data->title;
        $size->save();
    }

    public function update($data,$id){
        $size = $this->getById($id);
        $size->title = $data->title;
        $size->save();
    }

    public function destroy($id){
        $size = $this->getById($id);
        $size->delete();
        return $size;
    }

}
