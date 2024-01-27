@extends('admin.layouts.master')


@section('navigation')
    ویرایش استایل هفته
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('styles.update', $style->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')

                <div id="ImgBox" class="col-12 mb-3 @if(count($style->media) > 0) hidden @endif">
                    <div class="row">
                        <h6 class="text-muted">محل آپلود کاور استایل هفته</h6>
                    </div>
                    @include('admin.partials.Upload')
                </div>

                @if(count($style->media) > 0)
                    <div id="amzCover" class="col-12 mb-3">
                        <div class="row mb-2">
                            <h6 class="text-muted">کاور استایل هفته</h6>
                        </div>
                        <div class="d-flex align-items-end gap-2">
                            <img src="{{$style->media[0]->file->path}}" >
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="amzCoverDel()" >
                                <i class="icon-trash" ></i>
                                <span>حذف کاور</span>
                            </button>
                        </div>

                    </div>
                @endif
                <input type="hidden" id="photos" name="photosId" value="{{@$style->media[0]->file_id}}">

                <div class="form-group col-6 mb-3">
                    <label for="inputTitle" class="form-label">عنوان استایل هفته</label>
                    <input type="text" id="inputTitle" name="title" class="form-control BYekan" placeholder="عنوان استایل هفته..."
                    value="{{ $style->title }}" />
                </div>
                <div class="form-group col-6">
                    <label for="" class="form-label">تاریخ اتمام</label>
                    <input type="text" id="date" class="datePicker form-control text-end BYekan"
                        value="{{ $style->date }}" />
                    <input type="hidden" id="dateMain" name="date"
                        class="datePicker form-control text-end vazir  d-ltr" />
                </div>

                <div class="row my-4">
                    <label for="">انتخاب محصول</label>

                    <div class="form-group col-12">
                        <div class="input-group position-relative">
                            <input type="text" id="searchInputAMZ" class="form-control form-control-sm BYekan"
                                placeholder="کد یا عنوان محصول را وارد کنید..." onkeyup="isCheckSearch(this)" />
                            <div class="input-group-prepend">
                                <button id="searchBtnAMZ" class="btn border border-2 px-1 bg-white"
                                    onclick="searchProduct()" type="button">
                                    <i class="icon-search-1 text-muted"></i>
                                </button>
                            </div>

                            <div id="loadingAMZ" class="w-100 loading position-absolute bg-white border border-1">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="spinner-grow text-primary position-relative" role="status">
                                    </div>
                                </div>
                            </div>

                            <div id="searchContent" class="position-absolute bg-white border border-1 w-100">
                                <ul id="searchResult" class="w-100 list-unstyled">

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 apTblBox">
                    <label class="my-2">لیست محصولات استایل هفته:</label>
                    <?php $list = [] ?>
                    @foreach ($style->products as $key=>$product)
                        <?php array_push($list,$product->id) ?>
                    @endforeach
                    <input type="hidden" id="amzList" name="list" class="w-100" value="{{implode(',', $list)}}">
                    <table class="table" id="amzTbl">
                        <thead class="table-light fs-14">
                            <th>#</th>
                            <th>عنوان محصول</th>
                            <th>کد محصول</th>
                            <th class="text-center">عملیات</th>
                        </thead>
                        <tbody>
                            @foreach ($style->products as $key=>$product)
                                <tr id="p_{{$product->id}}">
                                    <td>{{$key+1}}</td>
                                    <td>{{$product->title}}</td>
                                    <td class="fs-12 vazir fw-bold">{{$product->sku}}</td>
                                    <td class="text-center">
                                        <i class="icon-trash text-danger" onClick="removeOfAMZ({{$product->id}})" role="button"
                                            title="حذف از لیست شگفت آویز"></i>
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
                <a href="{{ route('styles.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}" />

    <script>
        let amzList = [];

        var deafultProductImg = "{{ asset('imgs/admin/product-icon.png') }}"

        var token = "{{ csrf_token() }}";
        var type = "image";
        var folder = "week_style";
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

    <style>
        .datepicker-plot-area {
            font-family: BYekan !important;
        }

        .datepicker-navigator .pwt-btn-switch {
            font-size: 14px !important;
        }
    </style>
@endsection

@section('footer')
    <script>
        let url = "{{ route('products.search') }}";
        let _token = "{{ csrf_token() }}";
    </script>

    <script>
        $(document).ready(function() {
            window.persianDatepickerDebug = true;
            $("#date").persianDatepicker({
                autoClose: true,
                initialValue: true,
                observer: true,
                viewMode: 'jalali',
                altField: '#dateMain',
                altFormat: "YYYY-MM-DD HH:mm:ss",
                format: "HH:mm:ss - YYYY/MM/DD",
                calendar: {
                    persian: {
                        locale: 'en', // زبان نمایش
                    }
                },
                timePicker: {
                    enabled: true
                }
            });

        });
    </script>
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
@endsection
