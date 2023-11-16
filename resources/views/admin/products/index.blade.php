@extends('admin.layouts.master')

@section('navigation')
    دسته بندی ها
@endsection
@section('content')
    <div class="bg-white col-12 p-3 pb-5 border-start border-4 border-info right-box">
        <div class="col-12">
            @if(Session::has('opration_product'))
                @include('admin.partials.Alert',['msg'=>[session('opration_product')],'status'=>'success'])
            @endif
            {{-- @if(Session::has('error_category'))
                @include('admin.partials.Alert',['msg'=>[session('error_category')],'status'=>'danger'])
            @endif --}}
        </div>
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">تصویر محصول</th>
                    <th class="fw-normal fs-18">عنوان محصول</th>
                    <th class="fw-normal fs-18">برند محصول</th>
                    <th class="fw-normal fs-18">دسته بندی</th>
                    <th class="fw-normal fs-18">تاریخ ایجاد</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small class="fs-12">(ویرایش - حذف)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key=>$product)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            <div class="productListImg bg-white align-items-center">
                                @if(count($product->photo) == 1)
                                    <img src="{{asset($product->photo[0]->path)}}" class="w-100" >
                                @else
                                <img src="{{asset('imgs/admin/product-icon.png')}}" class="w-100" >
                                @endif
                            </div>
                        </td>
                        <td class="align-middle">{{short_str($product->title,30)}}</td>
                        <td class="align-middle">{{$product->brand->title}}</td>
                        <td class="align-middle">{{$product->category->title}}</td>
                        <td class="align-middle">{{verta($product->created_at)->format('Y/m/d')}}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('products.edit', $product->id) }}" title="ویرایش دسته {{ $product->title }}">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <form action="{{route('products.destroy',$product->id)}}" method="Post"  class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger border-0 p-0 bg-transparent" title="حذف دسته {{$product->title}}">
                                        <i class="icon-trash fs-6"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$products->links()}}</div>

    </div>
@endsection
