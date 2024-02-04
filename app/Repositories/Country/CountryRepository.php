<?php

namespace App\Repositories\Country;

use App\Models\Country;

class CountryRepository implements CountryRepositoryInterface
{

    protected $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function getAll($page = false)
    {
        if($page){
            return  $this->country::paginate(30);
        }else{
            return  $this->country::get();
        }
    }

    public function getById($id)
    {
    }

    public function store($data){

    }

    public function update($data,$id){

    }

    public function destroy($id){

    }
}
