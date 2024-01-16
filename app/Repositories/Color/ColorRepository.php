<?php

namespace App\Repositories\Color;

use App\Models\Color;

class ColorRepository implements ColorRepositoryInterface{

    protected $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    public function getAll($page = false)
    {
        if($page){
            return $this->color::paginate(20);
        }else{
            return $this->color::all();
        }
    }

    public function getById($id){
        return $this->color::findOrFail($id);
    }

    public function store($data){
        $color = new $this->color();
        $color->name = $data->name;
        $color->code = $data->code;
        $color->save();
    }

    public function update($data,$id){
        $color = $this->getById($id);
        $color->name = $data->name;
        $color->code = $data->code;
        $color->save();
    }

    public function destroy($id){
        $color = $this->getById($id);
        $color->delete();
        return $color;
    }

}
