<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\AttributeGroup;
use App\Models\AttributeGroupCategory;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\MediaFile;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'brand', 'media.file')->paginate(30);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id', null)->get();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();
        $sku = 'JS-' . time();
        return view('admin.products.create', compact(['categories', 'brands', 'colors', 'sizes','sku']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $meta_description = '';

        $product->title = $request->title;
        $product->sku =  $request->sku;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->description = $request->description;
        $product->status = $request->status;
        if ($request->meta_description) {
            $meta_description = $request->meta_description;
        } else if (!$request->meta_description && $request->description) {
            $meta_description = $request->description;
        }
        $product->meta_description = $meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->user_id = 1;
        $product->first_pic = $request->first_pic;
        $product->save();
        $product->sizes()->sync($request->size_id);
        $product->colors()->sync($request->colors);

        $photos = explode(',', $request->photos);
        foreach ($photos as $key => $id) {
            $product->media()->create([
                'file_id' => $id
            ]);
        }
        $attrValues = explode(',', $request->attribute_value);

        $product->attributes_values()->sync($attrValues);

        Session::flash('opration_product', 'محصول ' . $request->title . ' با موفقیت ایجاد شد');
        return redirect(route('products.index'));
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
        $product = Product::with('sizes', 'colors', 'media.file', 'attributes_values:id')->where('id', $id)->first();

        $category = Category::with('parent', 'children')->where('id', $product->category->id)->first();

        $catParentId = getParentID($category);
        $catChildrenId = getChildrenID($category);
        $catsId = [$product->category->id];
        foreach ($catParentId as $key => $value) {
            $catsId[] = $value;
        }
        foreach ($catChildrenId as $key => $value) {
            $catsId[] = $value;
        }

        $attributesValues = $product->attributes_values()->pluck('attributes_values.id')->toArray();

        $attributes_group_category = AttributeGroupCategory::select('attribute_group_id')->whereIn('category_id', $catsId)->get();
        $attributes_group_category = getOneFieldOfArray($attributes_group_category, 'attribute_group_id');
        $attributesGroup = AttributeGroup::with('attributes_value')->whereIn('id', $attributes_group_category)->get();

        $sizesId = getOneFieldOfArray($product->sizes, 'id');
        unset($product->sizes);
        $product->sizes = $sizesId;

        $colorsId = getOneFieldOfArray($product->colors, 'id');
        unset($product->colors);
        $product->colors = $colorsId;

        $categories = Category::with('children')->where('parent_id', null)->get();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.edit', compact(['product', 'categories', 'brands', 'colors', 'sizes', 'attributesGroup', 'attributesValues']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::with('sizes', 'colors', 'media.file', 'attributes_values:id')->where('id', $id)->first();
        $meta_description = '';
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->description = $request->description;
        $product->status = $request->status;
        if ($request->meta_description) {
            $meta_description = $request->meta_description;
        } else if (!$request->meta_description && $request->description) {
            $meta_description = $request->description;
        }
        $product->meta_description = $meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->brand_id  = $request->brand_id;
        $product->category_id  = $request->category_id;
        $product->first_pic = $request->first_pic;
        $product->sizes()->sync($request->size_id);

        $product->colors()->sync($request->colors);


        $photos = explode(',', $request->photos);
        foreach ($product->media as $key => $val) {
            $product->media()->delete($val->id);
        }
        foreach ($photos as $key => $val) {
            $product->media()->create([
                'file_id' => $val
            ]);
        }

        $attrValues = explode(',', $request->attribute_value);
        $product->attributes_values()->sync($attrValues);

        $product->save();
        Session::flash('opration_product', 'محصول ' . $request->title . ' با موفقیت ویرایش شد');
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function delete(Request $request, string $id)
    {
        $product = Product::with('photos')->findOrFail($id);
        $disk = 'public';
        $photosId = [];

        if($request->trash == 'true'){
            $product->delete();
        }else{
            foreach ($product->photos as $key => $value) {
                $path = str_replace("/storage/", "", $value->path);
                Storage::disk($disk)->delete($path);
                if ($value->thumbnail != null) {
                    $thumbnailPath = str_replace("/storage/", "", $value->thumbnail);
                    Storage::disk($disk)->delete($thumbnailPath);
                }
                array_push($photosId,$value->id);
                $dir = $disk . '/' . str_replace($value->name, "", $path);
                Storage::deleteDirectory($dir);
            }

            MediaFile::whereIn('id',$photosId)->delete();
            $product->forceDelete();
        }
        return response()->json(['status' => 'success'], Response::HTTP_OK);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function attributes(string $id)
    {
        $categories = Category::with('parent')->where('id', $id)->first();
        $catParentId = getParentID($categories);
        $catParentId[] = intval($id);
        $attributes_group_category = AttributeGroupCategory::select('attribute_group_id')->whereIn('category_id', $catParentId)->get();
        $attributes = AttributeGroup::with('attributes_value')->whereIn('id', $attributes_group_category)->get();
        return  response()->json(['status' => 'success', 'attributes' => $attributes], Response::HTTP_OK);
    }

    public function photos(string $id)
    {
        $product = Product::with('media.file')->findOrFail($id);
        return  response()->json(['status' => 'success', 'photos' => $product->media], Response::HTTP_OK);
    }
}
