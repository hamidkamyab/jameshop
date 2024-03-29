﻿@extends('admin.layouts.master')

@section('navigation')
    دسته بندی ها
@endsection
@section('navBtnBox')
    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
        <i class="icon-plus"></i>
        <span>افزودن</span>
    </a>
@endsection

@section('content')
    <div class="bg-white col-12 p-3 pb-5 border-start border-4 border-info right-box">
        <div class="col-12">
            @if (Session::has('opration_product'))
                @include('admin.partials.Alert', [
                    'msg' => [session('opration_product')],
                    'status' => 'success',
                ])
            @endif

        </div>
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-16">تصویر محصول</th>
                    <th class="fw-normal fs-16 text-center">کد محصول</th>
                    <th class="fw-normal fs-16">عنوان محصول</th>
                    <th class="fw-normal fs-16">دسته بندی</th>
                    <th class="fw-normal fs-16">تاریخ ایجاد</th>
                    <th class="fw-normal fs-16 d-flex align-items-center gap-1 justify-content-center">عملیات<small
                            class="fs-12">(ویرایش - حذف)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    <tr id="row-{{ $product->id }}" class="fs-14">
                        <td class="align-middle">{{ $key + 1 }}</td>
                        <td class="align-middle">
                            <div class="productListImg bg-white align-items-center">
                                @if(count($product->media) > 0)
                                    @foreach ($product->media as $photo)
                                        @if ($photo->file->id == $product->first_pic)
                                            <img src="{{ asset($photo->file->path) }}" class="w-100">
                                        @endif
                                    @endforeach
                                @else
                                    <img src="{{ asset('imgs/admin/product-icon.png') }}" class="w-100">
                                @endif
                            </div>
                        </td>
                        <td class="align-middle vazir text-center">{{ $product->sku }}</td>
                        <td class="align-middle">{{ short_str($product->title, 30) }}</td>
                        <td class="align-middle">{{ $product->category->title }}</td>
                        <td class="align-middle">{{ verta($product->created_at)->format('Y/m/d') }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    title="ویرایش دسته {{ $product->title }}">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <button type="submit" class="text-danger border-0 p-0 bg-transparent"
                                    title="حذف دسته {{ $product->title }}"
                                    onclick="deleteAlert(event,{{ $product->id }})">
                                    <i class="icon-trash fs-6"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{ $products->links() }}</div>

    </div>
@endsection

@section('footer')
    <script>
        var url = "{{ route('products.delete', 'id') }}";

        function deleteAlert(event, id) {

            event.preventDefault();
            let newUrl = url.replace('id', id);
            var formData = new FormData()
            formData.append("_token", "{{ csrf_token() }}");

            Swal.fire({
                title: "آیا از حذف محصول اطمینان دارید؟",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "حذف",
                denyButtonText: `انتقال به سطل زباله`,
                cancelButtonText: 'لغو عملیات'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    formData.append("trash", false);
                    const response = await fetch(newUrl, {
                        method: "POST",
                        body: formData
                    })
                    let result = await response.json()

                    if (result['status'] == 'success') {
                        let tag = '#row-' + id;
                        $(tag).fadeOut();
                        Swal.fire("محصول با موفقیت حذف شد!", "", "success");
                    }

                } else if (result.isDenied) {
                    formData.append("trash", true);
                    const response = await fetch(newUrl, {
                        method: "POST",
                        body: formData
                    })
                    let result = await response.json()

                    if (result['status'] == 'success') {
                        let tag = '#row-' + id;
                        $(tag).fadeOut();
                        Swal.fire("محصول با موفقیت به سطل زباله منتقل شد", "", "success");
                    }
                }
            });
        }
    </script>
@endsection
