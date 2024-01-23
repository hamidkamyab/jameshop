@extends('admin.layouts.master')


@section('navigation')
    اسلایدر
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('slider.store') }}" method="post" id="formTarget">
                @csrf

                <div id="ImgBox" class="best_menu_img col-12">

                    <div class="row">
                        <h6 class="text-muted">محل آپلود تصویر اسلایدر</h6>
                    </div>
                    @include('admin.partials.Upload')
                    <label for="" class="ImgChooseLabel my-1 d-none">اسلایدرها</label>
                    <ul class="ImgChoose list-unstyled my-2 d-flex flex-column gap-1 p-1">
                        <?php $separator = '';
                        $photoIds = ''; ?>

                        @if (@$slider && count($slider) > 0)
                            @foreach ($slider as $key => $slide)
                                <?php $photoIds = $photoIds . $separator . $slide->media[0]->file_id;
                                $separator = ','; ?>

                                <li class="p-1 ImgItem d-flex flex-wrap align-items-center dbSlide"
                                    id="PI-{{ $slide->media[0]->file_id }}" data-id={{ $slide->media[0]->file_id }}>
                                    <img src="{{ $slide->media[0]->file->path }}">
                                    <div class="w-75 p-3 d-flex gap-1">
                                        <div class="col-8">
                                            <input type="text" class="form-control vazir fs-12 fw-bold reqCheck"
                                                name="link-{{ $slide->media[0]->file_id }}" placeholder="لینک مورد نظر ...."
                                                onfocus="rmvCls(this)" value="{{ $slide->link }}" />
                                        </div>
                                        <div class="col-2">
                                            <input type="number" class="sortSlider form-control py-1 BYekan fs-14 reqCheck"
                                                name="num-{{ $slide->media[0]->file_id }}" placeholder="شماره اسلاید"
                                                value="{{ $slide->sort }}" onfocus="rmvCls(this)" min="1" />
                                        </div>
                                        <div class="col-2">
                                            <a href="{{ route('slider.destroy', $slide->id) }}">
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1">
                                                    <i class="icon-trash"></i>
                                                    <span>حذف</span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                    <input type="hidden" id="photos" name="photosId" value="{{ $photoIds }}">
                </div>

            </form>
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="checkSliderForm()">ثبت</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('head')
    <script>
        var token = "{{ csrf_token() }}";
        var type = "image";
        var folder = "slider";
        var mim = "jpg,jpeg,png,gif";
        var thumbnail = "false";

        var max = null; //maxFiles

        let photosId = [];
        let slideNum = 1;
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

            const tag = '<li class="p-1 ImgItem d-flex flex-wrap align-items-center" id="PI-' + resText['file_id'] + '" >' +
                '<img src="' + resText['path'] + '">' +
                '<div class="w-75 p-3 d-flex gap-1">' +
                '<div class="col-9">' +
                '<input type="text" class="form-control vazir fs-12 fw-bold reqCheck" name="link-' + resText['file_id'] +
                '"' + 'placeholder="لینک مورد نظر ...."' +
                'onfocus="rmvCls(this)" />' +
                '</div>' +
                '<div class="col-3">' +
                '<input type="number" class="sortSlider form-control py-1 BYekan fs-14 reqCheck" name="num-' + resText[
                    'file_id'] +
                '" placeholder="شماره اسلاید" value="' + slideNum + '" onfocus="rmvCls(this)" min="1" />' +
                '</div></div></li>';
            $('.ImgChoose').append(tag);
            $('.ImgChooseLabel').removeClass('d-none');
            slideNum++;
        }

        function resultRemove(id) {
            photosId = photosId.filter(item => item !== id);

            $('#photos').val(photosId);
            $("#PI-" + id).fadeOut(250);
            setTimeout(() => {
                $("#PI-" + id).remove();
                if (document.getElementsByClassName("ImgItem")
                    .length == 0) {
                    $('.ImgChooseLabel').addClass('d-none');
                }
            }, 300);
        }
    </script>
@endsection
