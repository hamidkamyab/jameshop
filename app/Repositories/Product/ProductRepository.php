<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\File\FileRepository;


class ProductRepository implements ProductRepositoryInterface{

    protected $product;
    protected $file;

    public function __construct(Product $product, FileRepository $fileRepository)
    {
        $this->product = $product;
        $this->file = $fileRepository;
    }

    public function getAll($page = false)
    {
        if($page){
            return $this->product::with('sizes', 'colors','category', 'brand', 'media.file', 'attributes_values:id')->paginate(30);
        }else{
            return $this->product::with('sizes', 'colors','category', 'brand', 'media.file', 'attributes_values:id')->get();
        }
    }

    public function getById($id){
        return $this->product::with('sizes', 'colors', 'media.file', 'attributes_values:id')->where('id', $id)->first();
    }

    public function store($data){
        $newProduct = new $this->product();
        $meta_description = '';

        $newProduct->title = $data->title;
        $newProduct->sku =  $data->sku;
        $newProduct->slug = $data->slug;
        $newProduct->price = $data->price;
        $newProduct->discount_price = $data->discount_price;
        $newProduct->description = $data->description;
        $newProduct->status = $data->status;
        if ($data->meta_description) {
            $meta_description = $data->meta_description;
        } else if (!$data->meta_description && $data->description) {
            $meta_description = $data->description;
        }
        $newProduct->meta_description = $meta_description;
        $newProduct->meta_keywords = $data->meta_keywords;
        $newProduct->brand_id = $data->brand_id;
        $newProduct->category_id = $data->category_id;
        $newProduct->user_id = 1;
        $newProduct->first_pic = $data->first_pic;
        $newProduct->save();
        $newProduct->sizes()->sync($data->size_id);
        $newProduct->colors()->sync($data->colors);

        $photos = explode(',', $data->photos);
        foreach ($photos as $key => $id) {
            $newProduct->media()->create([
                'file_id' => $id
            ]);
        }
        $attrValues = explode(',', $data->attribute_value);
        $newProduct->attributes_values()->sync($attrValues);
    }

    public function update($data,$id){
        $isProduct = $this->getById($id);
        $meta_description = '';
        $isProduct->title = $data->title;
        $isProduct->slug = $data->slug;
        $isProduct->price = $data->price;
        $isProduct->discount_price = $data->discount_price;
        $isProduct->description = $data->description;
        $isProduct->status = $data->status;
        if ($data->meta_description) {
            $meta_description = $data->meta_description;
        } else if (!$data->meta_description && $data->description) {
            $meta_description = $data->description;
        }
        $isProduct->meta_description = $meta_description;
        $isProduct->meta_keywords = $data->meta_keywords;
        $isProduct->brand_id  = $data->brand_id;
        $isProduct->category_id  = $data->category_id;
        $isProduct->first_pic = $data->first_pic;
        $isProduct->sizes()->sync($data->size_id);

        $isProduct->colors()->sync($data->colors);


        $photos = explode(',', $data->photos);
        foreach ($isProduct->media as $key => $val) {
            $isProduct->media()->delete($val->id);
        }
        foreach ($photos as $key => $val) {
            $isProduct->media()->create([
                'file_id' => $val
            ]);
        }

        $attrValues = explode(',', $data->attribute_value);
        $isProduct->attributes_values()->sync($attrValues);
        $isProduct->save();
    }

    public function destroy($data,$id){
        $product = $this->getById($id);

        if($data->trash == 'true'){
            $product->delete();
        }else{
            foreach ($product->media as $key => $value) {
                $this->file->destroy($value->file_id);
                $product->media()->delete($value->id);
            }
            $product->forceDelete();
        }
    }


}
