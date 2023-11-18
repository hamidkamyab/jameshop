<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\AttributeGroup;
use App\Models\AttributeGroupCategory;
use App\Models\AttributeValueProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorProduct;
use App\Models\MediaFile;
use App\Models\MediaFileProduct;
use App\Models\Product;
use App\Models\ProductSize;
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
        $products = Product::with('category', 'brand', 'photo')->paginate(30);
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
        return view('admin.products.create', compact(['categories', 'brands', 'colors', 'sizes']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $meta_description = '';
        $product->title = $request->title;
        $product->sku = 'JS-' . time();
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
        $product->save();
        $productId = $product->id;

        foreach ($request->size_id as $key => $id) {
            $productSize = new ProductSize();
            $productSize->product_id = $productId;
            $productSize->size_id = $id;
            $productSize->save();
        }

        foreach ($request->colors as $key => $id) {
            $productColor = new ColorProduct();
            $productColor->product_id = $productId;
            $productColor->color_id = $id;
            $productColor->save();
        }

        $photos = explode(',', $request->photos);
        foreach ($photos as $key => $id) {
            $productPhoto = new MediaFileProduct();
            $productPhoto->product_id = $productId;
            $productPhoto->media_file_id = $id;
            if ($request->first_pic == $id) {
                $productPhoto->first = 1;
            } else {
                $productPhoto->first = 0;
            }
            $productPhoto->save();
        }

        $attrValues = explode(',', $request->attribute_value);
        foreach ($attrValues as $key => $id) {
            $productAttrValues = new AttributeValueProduct();
            $productAttrValues->product_id = $productId;
            $productAttrValues->attribute_value_id = $id;
            $productAttrValues->save();
        }
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
        $product = Product::with('sizes', 'colors', 'photos', 'attributes_values:id')->where('id', $id)->first();

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
        $product = Product::with('sizes', 'colors', 'photos', 'attributes_values:id')->where('id', $id)->first();
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

        $sizesId = getOneFieldOfArray($product->sizes, 'id');
        if ($sizesId != $request->size_id) {
            $pSizesId = [];
            foreach ($product->sizes as $key => $pSize) {
                array_push($pSizesId, $pSize->pivot->id);
            }
            ProductSize::whereIn('id', $pSizesId)->delete();
            foreach ($request->size_id as $key => $sizeId) {
                $productSize = new ProductSize();
                $productSize->product_id = $id;
                $productSize->size_id = $sizeId;
                $productSize->save();
            }
        }

        $colorsId = getOneFieldOfArray($product->colors, 'id');
        if ($colorsId != $request->colors) {
            $pColorsId = [];
            foreach ($product->colors as $key => $pColor) {
                array_push($pColorsId, $pColor->pivot->id);
            }
            ColorProduct::whereIn('id', $pColorsId)->delete();
            foreach ($request->colors as $key => $colorId) {
                $productColor = new ColorProduct();
                $productColor->product_id = $id;
                $productColor->color_id = $colorId;
                $productColor->save();
            }
        }

        $photos = explode(',', $request->photos);
        $photosId = getOneFieldOfArray($product->photos, 'id');
        if ($photosId != $photos) {
            $pPhotosId = [];
            foreach ($product->photos as $key => $pPhoto) {
                array_push($pPhotosId, $pPhoto->pivot->id);
            }
            MediaFileProduct::whereIn('id', $pPhotosId)->delete();

            foreach ($photos as $key => $photoId) {
                $productPhoto = new MediaFileProduct();
                $productPhoto->product_id = $id;
                $productPhoto->media_file_id = $photoId;
                if ($request->first_pic == $photoId) {
                    $productPhoto->first = 1;
                } else {
                    $productPhoto->first = 0;
                }
                $productPhoto->save();
            }
        } else {
            $oldMFP = MediaFileProduct::where('product_id', $id)->where('first', 1)->first();
            if ($oldMFP && $oldMFP->media_file_id != $request->first_pic) {
                $oldMFP->first = 0;
                $oldMFP->save();
                $newMFP = MediaFileProduct::where('media_file_id', $request->first_pic)->first();
                $newMFP->first = 1;
                $newMFP->save();
            }
        }

        $attrValues = explode(',', $request->attribute_value);
        $attrValuesId = getOneFieldOfArray($product->attributes_values, 'id');

        if ($attrValues != $attrValuesId) {
            $pAttrValuesId = [];
            foreach ($product->attributes_values as $key => $pAttrValues) {
                array_push($pAttrValuesId, $pAttrValues->pivot->id);
            }
            AttributeValueProduct::whereIn('id', $pAttrValuesId)->delete();
            foreach ($attrValues as $key => $attrValueId) {
                $attrValueProduct = new AttributeValueProduct();
                $attrValueProduct->product_id = $id;
                $attrValueProduct->attribute_value_id = $attrValueId;
                $attrValueProduct->save();
            }
        }

        $product->save();
        Session::flash('opration_product', 'محصول ' . $request->title . ' با موفقیت ویرایش شد');
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::with('photos')->findOrFail($id);
        $disk = 'public';
        $photosId = [];
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
        $product->delete();

        Session::flash('opration_product', 'محصول ' . $product->title . ' با موفقیت حذف شد');
        return redirect(route('products.index'));
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
        $product = Product::with('photos')->findOrFail($id);
        return  response()->json(['status' => 'success', 'photos' => $product->photos], Response::HTTP_OK);
    }
}
