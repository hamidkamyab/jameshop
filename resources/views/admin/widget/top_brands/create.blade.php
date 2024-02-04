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
            <form class="row m-0 g-4" action="{{ route('top_brands.store') }}" method="post" id="formTarget">
                @csrf
                <div id="ImgBox" class="best_menu_img col-12 mb-3">
                    <div class="row">
                        <h6 class="text-muted">محل آپلود کاور</h6>
                    </div>
                    @include('admin.partials.Upload')

                    <input type="hidden" id="photos" name="photosId" value="">
                </div>

                <div class="col-3">
                    <label for="inputParent" class="form-label">برند</label>
                    <select class="form-select searchSelect select-cl mb-4" id="inputParent" name="brand_id"
                        data-id="brandsList" onchange="productsBrandSearch(event)">
                        <option selected disabled value="choose">انتخاب کنید...</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" >{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-9">
                    <label for="" class="form-label">محصولات</label>
                    <select class="form-select searchSelect select-cl mb-4" id="selectProduct" onchange="addToTB(event)" disabled>
                        <option selected disabled value="choose">انتخاب کنید...</option>

                    </select>
                </div>

                <div class="col-12 apTblBox">
                    <label class="my-2">لیست محصولات نمونه:</label>
                    <input type="hidden" id="topBrandList" name="list" class="clearLoad w-100" value="">
                    <table class="table" id="tbList">
                        <thead class="table-light fs-14">
                            <th>تصویر محصول</th>
                            <th>عنوان محصول</th>
                            <th>دسته بندی</th>
                            <th>عملیات</th>
                        </thead>
                        <tbody>

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
                <a href="{{ route('top_brands.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('head')
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
    </script>
@endsection
