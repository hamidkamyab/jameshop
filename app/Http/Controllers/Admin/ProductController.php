<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Repositories\AttributeGroup\AttributeGroupRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    private $product;
    private $category;
    private $brand;
    private $size;
    private $color;
    private $attrGroup;

    public function __construct(ProductRepositoryInterface $IProductRepository, CategoryRepositoryInterface $ICategoryRepository, BrandRepositoryInterface $IBrandRepository, SizeRepositoryInterface $ISizeRepository, ColorRepositoryInterface $IColorRepository, AttributeGroupRepositoryInterface $IAttrGroupRepository)
    {
        $this->product = $IProductRepository;
        $this->category = $ICategoryRepository;
        $this->brand = $IBrandRepository;
        $this->size = $ISizeRepository;
        $this->color = $IColorRepository;
        $this->attrGroup = $IAttrGroupRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->getAll(30);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->getAll();
        $brands = $this->brand->getAll();
        $colors = $this->color->getAll();
        $sizes = $this->size->getAll();
        $sku = 'JS-' . time();
        return view('admin.products.create', compact(['categories', 'brands', 'colors', 'sizes','sku']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this->product->store($request);
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
        $product = $this->product->getById($id);
        $category = $this->category->getById($product->category_id);

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

        $attributes_group_category = $this->category->attrGroupCat($catsId);
        $attributes_group_category = getOneFieldOfArray($attributes_group_category, 'attribute_group_id');

        $attributesGroup = $this->attrGroup->getById($attributes_group_category);

        $sizesId = getOneFieldOfArray($product->sizes, 'id');
        unset($product->sizes);
        $product->sizes = $sizesId;

        $colorsId = getOneFieldOfArray($product->colors, 'id');
        unset($product->colors);
        $product->colors = $colorsId;

        $categories = $this->category->getAll();
        $brands = $this->brand->getAll();
        $colors = $this->color->getAll();
        $sizes = $this->size->getAll();

        return view('admin.products.edit', compact(['product', 'categories', 'brands', 'colors', 'sizes', 'attributesGroup', 'attributesValues']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $this->product->update($request,$id);
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
        $this->product->destroy($request,$id);
        return response()->json(['status' => 'success'], Response::HTTP_OK);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function attributes(string $id)
    {
        $categories = $this->category->getById($id);
        $catParentId = getParentID($categories);
        $catParentId[] = intval($id);

        $attributes_group_category = $this->category->attrGroupCat($catParentId);
        $attrGroupId = [];
        foreach ($attributes_group_category as $key => $value) {
            $attrGroupId[] = $value->attribute_group_id;
        }
        $attributes = $this->attrGroup->getById($attrGroupId);

        return  response()->json(['status' => 'success', 'attributes' => $attributes], Response::HTTP_OK);
    }

    public function photos(string $id)
    {
        $product = $this->product->getById($id);
        return  response()->json(['status' => 'success', 'photos' => $product->media], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {
        $data = null;
        if ($request->val != null || $request->val != '') {
            $data = $this->product->search($request);
            if (count($data) > 0) {
                $status = 'success';
            } else {
                $status = 'error';
            }
        }else{
            $status = 'error';
        }

        return response()->json(['status' => $status, 'products' => $data], Response::HTTP_OK);
    }
}
