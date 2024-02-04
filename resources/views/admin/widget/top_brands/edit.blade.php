@extends('admin.layouts.master')


@section('navigation')
    برترین طراحان
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('top_brands.update', $topBrand->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')

                <div id="ImgBox" class="col-12 mb-3 @if (count($topBrand->media) > 0) hidden @endif">
                    <div class="row">
                        <h6 class="text-muted">محل آپلود کاور </h6>
                    </div>
                    @include('admin.partials.Upload')
                </div>

                @if (count($topBrand->media) > 0)
                    <div id="amzCover" class="col-12 mb-3 coverBox">
                        <div class="row mb-2">
                            <h6 class="text-muted">کاور </h6>
                        </div>
                        <div class="d-flex align-items-end gap-2">
                            <img src="{{ $topBrand->media[0]->file->path }}">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="CoverDel()">
                                <i class="icon-trash"></i>
                                <span>حذف کاور</span>
                            </button>
                        </div>

                    </div>
                @endif
                <input type="hidden" id="photos" name="photosId" value="{{ @$topBrand->media[0]->file_id }}">

                <div class="col-3">
                    <label for="inputParent" class="form-label">برند</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="brand_id"
                        data-id="brandsList" onchange="productsBrandSearch(event)">
                        <option disabled value="choose">انتخاب کنید...</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @if ($brand->id == $topBrand->brand_id) selected @endif>
                                {{ $brand->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-9">
                    <label for="" class="form-label">محصولات</label>
                    <select class="form-select searchSelect mb-4" id="selectProduct" onchange="addToTB(event)" >
                        <option selected disabled value="choose">انتخاب کنید...</option>
                    </select>
                </div>

                <div class="col-12 apTblBox">
                    <label class="my-2">لیست محصولات نمونه:</label>
                    <?php $list = []; ?>
                    @foreach ($topBrand->products as $key => $product)
                        <?php array_push($list, $product->id); ?>
                    @endforeach
                    <input type="hidden" id="topBrandList" name="list" class="w-100" value="{{ implode(',', $list) }}">
                    <table class="table" id="tbList">
                        <thead class="table-light fs-14">
                            <th>تصویر محصول</th>
                            <th>عنوان محصول</th>
                            <th>دسته بندی</th>
                            <th>عملیات</th>
                        </thead>
                        <tbody>
                            @foreach ($topBrand->products as $key => $product)
                                <tr id="row-{{ $product->id }}">
                                    <td>
                                        <div class="productListImg p-1 border border-1">
                                            @if (count($product->media) > 0)
                                                <img src="{{ $product->media[0]->file->path }}" />
                                            @else
                                                <img src="{{ asset('imgs/admin/product-icon.png') }}" />
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $product->title }}</span><small
                                                class="text-info">{{ $product->sku }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $product->category->title }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm d-flex align-items-center"
                                        onclick="removeOfTB({{$product->id}})">
                                            <i class="icon-trash"></i><span>حذف</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت</button>
                <a href="{{ route('amazings.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}" />

    <script>
        let tbList = [];
        var deafultProductImg = "{{ asset('imgs/admin/product-icon.png') }}"

        var token = "{{ csrf_token() }}";
        var type = "image";
        var folder = "top_brand";
        var mim = "jpg,jpeg,png,gif";
        var thumbnail = "false";

        var max = 1; //maxFiles

        let photosId = [];

        let setOldVal = false;

        function up_success(file) {
            let resText = JSON.parse(file.xhr.responseText);
            photosId.push(resText.file_id);

            if (!setOldVal) {
                var elements = document.querySelectorAll('.dbSlide');
                elements.forEach(elem => {
                    photosId.push($(elem).attr('data-id'));
                })
                setOldVal = true
            }
            $('#photos').val(photosId);
        }

        function resultRemove(id) {
            photosId = photosId.filter(item => item !== id);
            $('#photos').val(photosId);
        }
    </script>

@endsection

@section('footer')
    <script>
        let TB_url = "{{ route('top_brands.search','+id+') }}";
        $(window).on('load',()=>{
            productsBrandSearch({target:{value:"{{$topBrand->brand_id}}"}},false)
        })
    </script>
@endsection
