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
use App\Models\MediaFileProduct;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category','brand','photo')->paginate(30);
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->where('parent_id',null)->get();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.create',compact(['categories','brands','colors','sizes']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $meta_description = '';
        $product->title = $request->title;
        $product->sku = 'JS-'.time();
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

        $colors = explode(',', $request->colors);
        foreach ($colors as $key => $id) {
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
            if($request->first_pic == $id ){
                $productPhoto->first = 1;
            }else{
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
        return redirect(route('product.index'));

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
        $product = Product::with('sizes','colors','photos')->findOrFail($id);

        $sizesId = get_Id($product->sizes);
        unset($product->sizes);
        $product->sizes = $sizesId;

        $colorsId = get_Id($product->colors);
        unset($product->colors);
        $product->colors = $colorsId;

        $categories = Category::with('children')->where('parent_id',null)->get();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.edit',compact(['product','categories','brands','colors','sizes']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function attributes(string $id)
    {
        $categories = Category::with('parent')->where('id',$id)->first();
        $catParentId = getParentID($categories);
        $catParentId[] = intval($id);
        $attributes_group_category = AttributeGroupCategory::select('attribute_group_id')->whereIn('category_id',$catParentId)->get();
        $attributes = AttributeGroup::with('attributes_value')->whereIn('id',$attributes_group_category)->get();
        return  response()->json(['status' => 'success','attributes' => $attributes],Response::HTTP_OK);
    }
}
