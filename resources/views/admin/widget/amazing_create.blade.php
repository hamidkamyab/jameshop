@extends('admin.layouts.master')


@section('navigation')
    شگفت آویز
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box" style="height: 1000px">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('amazings.store') }}" method="post" id="formTarget">
                @csrf
                <div id="ImgBox" class="best_menu_img col-12 mb-3">
                    <div class="row">
                        <h6 class="text-muted">محل آپلود کاور شگفت آویز</h6>
                    </div>
                    @include('admin.partials.Upload')

                    <input type="hidden" id="photos" name="photosId" value="">
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="" class="form-label">شروع شگفت آویز</label>
                    <input type="text" class="datePicker form-control text-end BYekan" />
                </div>
                <div class="form-group col-6">
                    <label for="" class="form-label">اتمام شگفت آویز</label>
                    <input type="text" class="datePicker form-control text-end BYekan" />
                </div>

                <div class="row my-4">
                    <label for="">انتخاب محصول</label>

                    <div class="form-group col-12">
                        <div class="input-group position-relative">
                            <input type="text" id="searchInputAMZ" class="form-control form-control-sm BYekan"
                                placeholder="کد یا عنوان محصول را وارد کنید..." onkeyup="isCheckSearch(this)" />
                            <div class="input-group-prepend">
                                <button class="btn border border-2 px-1" type="button"><i
                                        class="icon-search-1 text-muted" onclick="searchProduct()"></i></button>
                            </div>

                            <div id="loadingAMZ" class="w-100 loading position-absolute bg-white border border-1">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <div class="spinner-grow text-primary position-relative" role="status">
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            <div id="searchContent" class="position-absolute bg-white border border-1 w-100">
                                <ul id="searchResult" class="w-100 list-unstyled">
                                    {{-- <li class="resultItem p-3 d-flex align-items-center gap-5 justify-content-between" role="button">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="imgBox border border-1 p-1"><img
                                                    src="{{ asset('imgs/admin/product-icon.png') }}"
                                                    style="width:100%;height: 100%;"></div>
                                            <div class="d-flex flex-column">
                                                <span>تیشرت آستین بلند مردانه مجید</span>
                                                <small class="text-muted">کد محصول</small>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column">
                                            <span class="text-end">50,000</span>
                                            <div>
                                                <small class="text-muted">20%</small>
                                                <small class="text-muted"> :تخفیف</small>
                                            </div>
                                        </div>
                                    </li> --}}



                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <input type="hidden" id="products" name="productsId" value="">
            </form>
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/persian-datepicker.min.css') }}" />

    <script>
        var token = "{{ csrf_token() }}";
        var type = "image";
        var folder = "amazing";
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
        let url ="{{route('amazings.search')}}";
        let _token = "{{csrf_token()}}";
    </script>

    <script>
        $(document).ready(function() {
            window.persianDatepickerDebug = true;
            $(".datePicker").persianDatepicker({
                initialValue: true,
                initialValueType: 'gregorian',
                altFormat: 'LLLL',
                observer: true,
                format: "H:mm:ss - DD MMMM YYYY",
                timePicker: {
                    enabled: true
                }
            });
        });
    </script>
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
@endsection
