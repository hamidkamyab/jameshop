@extends('admin.layouts.master')


@section('navigation')
    ایجاد منو
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/monolith.min.css') }}">
@endsection
@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4 col-12" action="{{ route('menus.store') }}" method="post" id="formTarget">
                @csrf
                <div class="col-6">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control vazir fs-12 fw-bold" id="inputTitle" name="title" placeholder="عنوان منو..."
                        value="{{ old('title') }}" />
                </div>
                <div class="col-6">
                    <label class="form-label">رنگ</label><small class="mx-1 text-danger">(اختیاری می
                        باشد)</small>
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="form-check form-switch">
                            <label class="form-check-label text-muted" for="SwitchCheckColor">سفارشی سازی رنگ متن
                                منو</label>
                            <input class="form-check-input disabled" type="checkbox" id="SwitchCheckColor" role="button">
                        </div>

                        <input type="hidden" value="" name="color" disabled class="vazir fs-12 fw-bold ClearLoad"
                            id="inputColor">
                        <div id="color-picker"></div>
                    </div>
                </div>
                <div class="col-12 d-flex flex-wrap">
                    <div class="col-12"><label class="form-label">لینک</label></div>
                    <div class="form-group col-6 p-3">
                        <select id="selectLink" class="form-control def-select vazir fs-12 fw-bold form-select" role="button" name="is_cat">
                            <option class="defaultOption" disabled>انتخاب کنید</option>
                            <option value="0">بدون لینک</option>
                            <option value="1">از دسته بندی</option>
                            <option value="2">افزودن دستی</option>
                        </select>
                    </div>
                    <div class="form-group col-6 p-3">
                        <select id="selectCategories" class="form-control vazir fs-12 fw-bold def-select form-select" role="button" name="link_cat" disabled>
                            <option class="defaultOption" disabled>انتخاب دسته بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->title }}</option>
                                @if ($category->children)
                                    @include('admin.partials.CategoryChildren', [
                                        'categories' => $category->children,
                                        'level' => 1,
                                        'toltipTitle' => $category->title,
                                        'disableParent' => false,
                                    ])
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 p-3">
                        <input type="text" class="form-control vazir fs-12 fw-bold" id="inputLink" disabled name="link"
                            placeholder="لینک منو..." value="{{ old('link') }}" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="selectPosition" class="form-label">موقعیت</label>
                        <select id="selectPosition" class="form-control def-select form-select" role="button"
                            name="position">
                            <option class="defaultOption" disabled>انتخاب کنید</option>
                            <option value="Top">بالای صفحه (هدر)</option>
                            <option value="Bottom">پایین صفحه (فوتر)</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="selectParent" class="form-label">والد</label>
                        <select id="selectParent" class="create form-control vazir fs-12 fw-bold def-select form-select" role="button" name="parent_id" disabled>
                            <option class="defaultOption" disabled>انتخاب کنید</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}" class="text-primary parent"> {{ $menu->title }}</option>
                                @if ($menu->children)
                                    @include('admin.partials.MenuChildren', [
                                        'menus' => $menu->children,
                                        'level' => 1,
                                        'toltipTitle' => $menu->title,
                                    ])
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group py-2">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="SwitchCheckBest">بهترین برند ها یا طراحان</label>
                            <small class="mx-1 text-danger">(برای منو بالای صفحه [هدر] می باشد)</small>
                            <input class="form-check-input vazir fs-12 fw-bold disabled" disabled type="checkbox" id="SwitchCheckBest"
                              name="best_status"  role="button">
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-wrap">
                        <div class="col-6 px-2 my-2">
                            <label for="inputTitle" class="form-label">عنوان</label>
                            <input type="text" class="b-input-t vazir fs-12 fw-bold form-control" id="inputTitle" name="best_title"
                                placeholder="عنوان..." value="{{ old('best_title') }}" disabled />
                        </div>
                        <div class="col-6 px-2 my-2">
                            <label for="inputTitle" class="form-label">لینک عنوان</label>
                            <input type="text" class="b-input-t vazir fs-12 fw-bold form-control" id="inputTitle" name="best_link"
                                placeholder="لینک عنوان..." value="{{ old('best_link') }}" disabled />
                        </div>
                        <div class="imgBest col-12 px-2 my-2 d-flex flex-wrap align-items-center d-none">
                            <div class="col-12">
                                <label for="inputTitle" class="form-label">تصاویر برترین</label>
                                <small class="text-danger">(تعداد مجاز 4 تصویر می باشد)</small>
                            </div>

                            <div id="ImgBox" class="best_menu_img col-12">
                                <input type="hidden" id="photos" name="bests" class="ClearLoad" disabled>
                                <div class="border border-1 border-gray-500 dropzone" id="dropzoneTag">
                                    <div class="dz-message">
                                        <div class="d-flex flex-column">
                                            <i class="icon-upload m-1 fs-2"></i>
                                            <span class="fs-5">فایل‌های خود را کشیده و اینجا رها کنید</span>
                                            <span class="fs-5">یا اینجا کلیک کنید</span>
                                        </div>

                                    </div>
                                </div>

                                <label for="" class="ImgChooseLabel my-1 d-none">لینک صفحه محصولات برند</label>
                                <ul class="ImgChoose list-unstyled my-2 d-flex flex-column gap-1 p-1">

                                </ul>

                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت منو</button>
                <a href="{{ route('menus.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('js/dropzone.min.js') }}"></script>

    <script>
        const dateTime = new Date();
        let photosId = [];
        var c = 0;
        Dropzone.autoDiscover = false;

        $("div#dropzoneTag").dropzone({
            addRemoveLinks: true,
            uploadMultiple: false,
            maxFiles: 4,
            uploadActive: true,
            url: "{{ route('files.upload') }}",
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}")
                formData.append("type", 'image')
                formData.append("folder", "menus/")
                formData.append("mimesFile", "jpg,jpeg,png")
                formData.append("thumbnail", "false")
            },
            init: function() {
                this.on("success", (file, responseText) => {
                    photosId.push(responseText['file_id']);
                    $('#photos').attr('disabled',false)
                    $('#photos').val(photosId);
                    let active = '';
                    if (c == 0) {
                        active = 'active';
                        $('#inputFirstPicId').val(responseText['file_id']);
                    }
                    c++;
                    const tag =
                        '<li class="p-1 ImgItem d-flex flex-wrap align-items-center' + active +
                        '" onClick="selectFirstImage(this)" id="PI-' +
                        responseText['file_id'] + '">' +
                        '<img src="' + responseText['path'] + '">' +
                        '<div class="w-50 p-3">' +
                        '<input type="text" class="form-control vazir fs-12 fw-bold" name="link-' + responseText[
                            'file_id'] + '" placeholder="لینک برند یا طراح برتر...." />' +
                        '</div>' +
                        '</li>';
                    $('.ImgChoose').append(tag);
                    $('.ImgChooseLabel').removeClass('d-none');
                });
                this.on("error", function(file, errorText) {
                    $('.uploadError').fadeIn(1500);
                    if (errorText instanceof Object) {
                        $('.toast .toast-body').text(errorText.message);
                    } else {
                        $('.toast .toast-body').text(errorText);
                    }
                    $('.toast').toast('show')
                });
                this.on("removedfile", async (file, responseText) => {
                    if (file['xhr']) {
                        var response = JSON.parse(file['xhr']['responseText']);
                        const id = response['file_id'];
                        var formData = new FormData()
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("id", id);

                        if (id) {
                            const response = await fetch("{{ route('files.remove') }}", {
                                method: "POST",
                                body: formData
                            })
                            const result = await response.json();
                            if (result['status'] == 'success') {
                                photosId = photosId.filter(item => item !== id);
                                $('#photos').val(photosId);
                                $("#PI-" + id).fadeOut(250);

                                if ($("#PI-" + id).hasClass('active')) {
                                    $('#inputFirstPicId').val('');
                                }
                                setTimeout(() => {
                                    $("#PI-" + id).remove();
                                    if (document.getElementsByClassName("ImgItem")
                                        .length == 0) {
                                        $('.ImgChooseLabel').addClass('d-none');
                                        $('#inputFirstPicId').val('');
                                        c = 0;
                                        $('#photos').attr('disabled',false)
                                    }
                                }, 300);
                            }
                        }
                    }
                });
            }
        });
    </script>
    <script src="{{ asset('js/pickr.min.js') }}"></script>
    <script>
        let pickr;

        function showPickr() {
            pickr = Pickr.create({
                el: '#color-picker',
                theme: 'monolith', // or 'monolith', or 'nano'
                swatches: [
                    'rgba(244, 67, 54, 1)',
                    'rgba(233, 30, 99, 0.95)',
                    'rgba(156, 39, 176, 0.9)',
                    'rgba(103, 58, 183, 0.85)',
                    'rgba(63, 81, 181, 0.8)',
                    'rgba(33, 150, 243, 0.75)',
                    'rgba(3, 169, 244, 0.7)',
                    'rgba(0, 188, 212, 0.7)',
                    'rgba(0, 150, 136, 0.75)',
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(139, 195, 74, 0.85)',
                    'rgba(205, 220, 57, 0.9)',
                    'rgba(255, 235, 59, 0.95)',
                    'rgba(255, 193, 7, 1)'
                ],
                components: {

                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });
            pickr.on('save', (color) => {
                const hexColor = color.toHEXA().toString();
                document.getElementById('inputColor').value = hexColor;
            });
        }
        showPickr()
        pickr.disable();
        $('#SwitchCheckColor').on('change', (e) => {
            if (e.target.checked) {
                pickr.enable();
                $('#inputColor').attr('disabled', false)
            } else {
                pickr.disable();
                $('#inputColor').attr('disabled', true)
            }
        })
    </script>
    <script src="{{ asset('js/ajax.js') }}"></script>
@endsection
