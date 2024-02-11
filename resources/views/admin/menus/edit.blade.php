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
            <form class="row m-0 g-4 col-12" action="{{ route('menus.update', $menu->id) }}" method="post" id="formTarget">
                @csrf
                @method('PUT')
                <div class="col-6">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control vazir fs-12 fw-bold reqCheck" id="inputTitle" name="title"
                        placeholder="عنوان منو..." value="{{ $menu->title }}" onfocus="rmvCls(this)" />
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

                        <input type="hidden" @if ($menu->color) value="{{$menu->color}}" @else value="#42445a" @endif
                        name="color" disabled class="vazir fs-12 fw-bold" id="inputColor">
                        <div id="color-picker"></div>
                    </div>
                </div>
                <div class="col-12 d-flex flex-wrap">
                    <div class="col-12"><label class="form-label">لینک</label></div>
                    <div class="form-group col-6 p-3">
                        <select id="selectLink" class="form-control def-select vazir fs-12 fw-bold form-select"
                            role="button" name="is_link">
                            <option disabled>انتخاب کنید</option>
                            <option value="0" @if ($menu->is_link == '0') selected @endif>بدون لینک</option>
                            <option value="1" @if ($menu->is_link == '1') selected @endif>از دسته بندی</option>
                            <option value="2" @if ($menu->is_link == '2') selected @endif>افزودن دستی</option>
                        </select>
                    </div>
                    <div class="form-group col-6 p-3">
                        <select id="selectCategories" class="form-control vazir fs-12 fw-bold form-select"
                            role="button" name="category_id" @if ($menu->category_id == null) disabled @endif>
                            <option class="defaultOption" disabled>انتخاب دسته بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if($menu->category_id == $category->id) selected @endif>
                                    {{ $category->title }}</option>
                                @if ($category->children)
                                    @include('admin.partials.CategoryChildren', [
                                        'categories' => $category->children,
                                        'level' => 1,
                                        'toltipTitle' => $category->title,
                                        'disableParent' => false,
                                        'selectedId' => $menu->category_id
                                    ])
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 p-3">
                        <input type="text" class="form-control vazir fs-12 fw-bold" id="inputLink" @if($menu->is_cat != 2) disabled @endif
                            name="link" placeholder="لینک منو..." value="{{ $menu->link }}" />
                    </div>
                </div>

                <div class="col-12 d-flex gap-3 align-items-center">
                    <label class="form-check-label text-muted" for="DiactiveMenu">وضعیت منو</label>
                    <div class="form-check">
                        <input class="form-check-input border border-danger" type="radio" name="status" id="flexRadioDefault1" value="0"
                        @if($menu->status == 0) checked @endif role="button" >
                        <label class="form-check-label" for="DiactiveMenu" role="button">
                            غیرفعال
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input border border-success" type="radio" name="status" id="ActiveMenu" value="1"
                        @if($menu->status == 1) checked @endif role="button">
                        <label class="form-check-label" for="ActiveMenu" role="button">
                            فعال
                        </label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="selectPosition" class="form-label">موقعیت</label>
                        <select id="selectPosition" class="form-control def-select form-select" role="button"
                            name="position">
                            <option disabled>انتخاب کنید</option>
                            <option value="Top" @if ($menu->position == 'Top') selected @endif>بالای صفحه (هدر)
                            </option>
                            <option value="Bottom" @if ($menu->position == 'Bottom') selected @endif>پایین صفحه (فوتر)
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="selectParent" class="form-label">والد</label>
                        <select id="selectParent" class="form-control vazir fs-12 fw-bold def-select form-select"
                            role="button" name="parent_id" @if ($menu->orginalPosition != 'Top') disabled @endif>
                            <option disabled>انتخاب کنید</option>
                            <option value="0" @if ($menu->parent_id == 0) selected @endif>بدون والد</option>
                            @foreach ($menus as $item)
                                <option value="{{ $item->id }}" @if ($menu->parent_id == $item->id) selected @endif
                                    class="text-primary parent"> {{ $item->title }}</option>
                                @if ($item->children)
                                    @include('admin.partials.MenuChildren', [
                                        'menus' => $item->children,
                                        'level' => 1,
                                        'toltipTitle' => $item->title,
                                        'selectedId' => $menu->parent_id,
                                    ])
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group py-2">
                        <div class="form-check form-switch d-flex align-items-center justify-content-start">
                            <input
                                class="form-check-input vazir fs-12 fw-bold @if ($menu->best == 0) disabled @endif me-2"
                                @if ($menu->best != 0) checked @endif type="checkbox"
                                id="SwitchCheckBest" name="best_status" role="button">
                            <label class="form-check-label" for="SwitchCheckBest">بهترین برند ها یا طراحان</label>
                            <small class="mx-1 text-danger">(برای منو بالای صفحه [هدر] می باشد)</small>
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-wrap">
                        <div class="col-6 px-2 my-2">
                            <label for="inputTitle" class="form-label">عنوان</label>
                            <input type="text" class="b-input-t vazir fs-12 fw-bold form-control" id="inputTitle"
                                name="best_title" placeholder="عنوان..." value="{{ $menu->best_title }}"
                                @if ($menu->best == 0) disabled @endif />
                        </div>
                        <div class="col-6 px-2 my-2">
                            <label for="inputTitle" class="form-label">لینک عنوان</label>
                            <input type="text" class="b-input-t vazir fs-12 fw-bold form-control" id="inputTitle"
                                name="best_link" placeholder="لینک عنوان..." value="{{ $menu->best_link }}"
                                @if ($menu->best == 0) disabled @endif />
                        </div>
                        <div class="imgBest col-12 px-2 my-2 d-flex flex-wrap align-items-center @if ($menu->best == 0) d-none @endif">
                            <div class="col-12">
                                <label for="inputTitle" class="form-label">تصاویر برترین</label>
                                <small class="text-danger">(تعداد مجاز 4 تصویر می باشد)</small>
                            </div>

                            <div id="ImgBox" class="best_menu_img col-12">
                                <input type="hidden" id="photos" name="bests">
                                <input type="hidden" id="menu_id" name="menu_id" value="{{ $menu->id }}">
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
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget',true)">ویرایش منو</button>
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
                    $('#photos').attr('disabled', false)
                    $('#photos').val(photosId);

                    c++;
                    const tag =
                        '<li class="p-1 ImgItem d-flex flex-wrap align-items-center" id="PI-' +
                        responseText['file_id'] + '">' +
                        '<img src="' + responseText['path'] + '">' +
                        '<div class="w-50 p-3">' +
                        '<input type="text" class="form-control vazir fs-12 fw-bold reqCheck" name="link-' +
                        responseText[
                            'file_id'] + '" placeholder="لینک برند یا طراح برتر...." onfocus="rmvCls(this)" />' +
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
                this.on("removedfile", async (file) => {
                    let id = false;
                    if (file.id) {
                        id = file.id;
                    } else if (file.xhr.responseText) {
                        const file_xhr = JSON.parse(file.xhr.responseText);
                        id = file_xhr.file_id;
                    }
                    $('.dz-message').addClass('d-none');
                    if (id) {
                        var formData = new FormData()
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("id", id);
                        const response = await fetch("{{ route('files.remove') }}", {
                            method: "POST",
                            body: formData
                        })
                        const result = await response.json()
                        if (result['status'] == 'success') {
                            photosId = photosId.filter(item => item !== id);
                            $('#photos').val(photosId);
                            $("#PI-" + id).fadeOut(250);
                            setTimeout(() => {
                                $("#PI-" + id).remove();
                                if (document.getElementsByClassName("ImgItem")
                                    .length == 0) {
                                    $('.ImgChooseLabel').addClass('d-none');
                                    c = 0;
                                    $('#photos').attr('disabled', false)
                                }
                                if (document.getElementsByClassName("dz-preview").length ==
                                    0) {
                                    $('.dz-message').removeClass('d-none')
                                }
                            }, 300);
                            if (result['media'].length > 0) {
                                const best_menu = result['media'][0].mediable_id;
                                let url = "{{ route('menus.bestMenu_destroy', 'id') }}";
                                url = url.replace('id', best_menu);
                                await fetch(url, {
                                    method: "GET"
                                })
                                $("li[data-id='" + best_menu + "']").fadeOut(150);
                                $("#PI-" + best_menu + "]").fadeOut(150);
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
                default: $('#inputColor').val(),
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

        var myDropzone = $("div#dropzoneTag").get(0).dropzone;

        var getPhotosUrl = "{{ route('menus.photos', 'id') }}";
        $.ajax({
            url: getPhotosUrl.replace("id", {{ $menu->id }}),
            type: 'GET',
            dataType: 'json',
            success: function(values) {

                values.data.forEach(function(val) {
                    var media = val.media[0];
                    var mockFile = {
                        id: media.file.id,
                        name: media.file.path,
                        size: media.file.size,
                    }; // اطلاعات جعلی برای فایل
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, media.file.path);
                    var myElement = document.getElementsByClassName("dz-progress");
                    // تغییر display به "none"
                    myElement.forEach((tag) => {
                        tag.style.display = "none";
                    })
                    photosId.push(media.file.id);

                    const tag =
                        '<li class="p-1 ImgItem d-flex flex-wrap align-items-center" id="PI-' +
                        media.file_id + '" data-id="' + val.id + '">' +
                        '<img src="' + media.file.path + '">' +
                        '<div class="w-50 p-3">' +
                        '<input type="text" class="form-control vazir fs-12 fw-bold" name="link-' +
                        media.file_id + '" placeholder="لینک برند یا طراح برتر...." value="' + val
                        .link + '" />' +
                        '</div>' +
                        '</li>';
                    $('.ImgChoose').append(tag);
                    $('.ImgChooseLabel').removeClass('d-none');

                    c++;
                });
                $('#photos').val(photosId);
            },
            error: function(error) {
                console.log('Error fetching image data: ', error.status);
            }
        });

        $('#SwitchCheckBest').on('change', async (e) => {
            if (!e.target.checked) {
                $('.ImgItem').remove();
                $('.ImgChooseLabel').addClass('d-none');
                $('.dz-message').removeClass('d-none')
                myDropzone.removeAllFiles();
                const menu_id = $('#menu_id').val();
                let url = "{{ route('menus.bestMenu_destroy', ['id', 'status']) }}";
                url = url.replace('id', menu_id);
                url = url.replace('status', 'multi');
                await fetch(url, {
                    method: "GET"
                })

                var formData = new FormData()
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("id", photosId);

                await fetch("{{ route('files.remove') }}", {
                    method: "POST",
                    body: formData
                })


            }
        })
    </script>
    <script src="{{ asset('js/ajax.js') }}"></script>
@endsection
