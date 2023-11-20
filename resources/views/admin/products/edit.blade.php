@extends('admin.layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
@endsection

@section('navigation')
    ویرایش محصول
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('products.update', $product->id) }}" method="POST" id="formTarget">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان محصول..."
                        value="{{ $product->title }}" />
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نام مستعار</label>
                    <small class="text-danger">(برای استفاده در لینک)</small>
                    <input type="text" class="form-control" id="inputSlug" name="slug"
                        placeholder="نام مستعار محصول..." value="{{ $product->slug }}" />
                </div>

                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea name="description" id="inputDescription">{{ $product->description }}</textarea>
                </div>

                <div class="col-6">
                    <label for="inputBrand" class="form-label">برند</label>
                    <select class="form-select searchSelect mb-4" id="inputBrand" name="brand_id">
                        <option selected disabled>انتخاب کنید...</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @if ($brand->id == $product->brand->id) selected @endif>
                                {{ $brand->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته بندی <small class="text-danger fs-12">(دسته بندی دارای
                            زیر مجموعه را نمیتوان انتخاب کرد!)</small></label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="category_id"
                        data-id="categoriesList" onchange="getAttrCat(event)">
                        <option selected disabled value="choose">انتخاب کنید...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (count($category->children) > 0) disabled @endif
                                @if ($category->id == $product->category->id) selected @endif>
                                {{ $category->title }}</option>
                            @if ($category->children)
                                @include('admin.partials.CategoryChildren', [
                                    'categories' => $category->children,
                                    'level' => 1,
                                    'toltipTitle' => $category->title,
                                    'selectedId' => $product->category->id,
                                    'disableParent' => true,
                                ])
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="inputParent" class="form-label">قیمت محصول <small class="text-danger fs-12">(قیمت به ریال می
                            باشد)</small></label>
                    <input type="text" class="form-control" name="price" value="{{ $product->price }}"
                        placeholder="برای مثال: 1000000">
                </div>

                <div class="col-6">
                    <label for="inputDiscountPrice" class="form-label">تخفیف <small class="text-danger fs-12">(%)</small></label>
                    <input type="number" class="form-control" name="discount_price" value="{{ $product->discount_price }}"
                        min="0" max="100" placeholder="0" id="inputDiscountPrice">
                </div>

                <div class="col-6">{{ gettype($product->sizes) }}
                    <label for="inputSize" class="form-label">سایزبندی <small class="text-danger fs-12">(%)</small></label>
                    <select class="form-select searchSelect mb-4" id="inputSize" name="size_id[]" multiple>
                        {{-- <option value=""></option> --}}
                        @foreach ($sizes as $size)
                            @if (in_array($size->id, $product->sizes))
                                <option value="{{ $size->id }}" selected>
                                    {{ $size->title }}
                                </option>
                            @else
                                <option value="{{ $size->id }}">
                                    {{ $size->title }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="inputSize" class="form-label">وضعیت انتشار <small class="text-danger fs-12">(برای نمایش در
                            سایت گزینه انتشار را انتخاب کنید)</small></label>
                    <div class="d-flex gap-4 mt-1">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="status" value="0"
                                @if ($product->status == 0) checked @endif id="radioBtnSpread">
                            <label class="form-check-label" for="radioBtnSpread" role="button">
                                عدم انتشار
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="status" value="1"
                                @if ($product->status == 1) checked @endif id="radioBtnNonSpread">
                            <label class="form-check-label" for="radioBtnNonSpread" role="button">
                                انتشار
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputMetaDescription" class="form-label">متا توضیحات</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <textarea class="form-control" id="inputMetaDescription" name="meta_description"
                        placeholder="توضیحات متاتگ محصول...">{{ $product->meta_description }}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputKeywords" class="form-label">کلمات کلیدی</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <small class="text-danger">(بیشتر از 5 کلمه کلیدی وارد نکنید!)</small>
                    <input type="text" class="form-control" id="inputKeywords" name="meta_keywords"
                        placeholder="کلمات کلیدی را با '،' جدا کنید" value="{{ $product->meta_keywords }}">

                </div>

                <div class="col-12">
                    <label for="" class="mb-1">رنگ بندی محصول</label>
                    <div class="border border-1 border-gray-500 p-2 d-flex mCustomScrollbar" data-mcs-theme="dark"
                        style="height:80px;">
                        <div class="d-flex flex-wrap p-1 gap-2">
                            @foreach ($colors as $color)
                                <span id="{{ $color->id }}"
                                    class="position-relative colorItem d-inline-block NoSelect @if (in_array($color->id, $product->colors)) active @endif"
                                    style="background-color: {{ $color->code }}" title="{{ $color->name }}">
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border border-light rounded-circle">
                                    </span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <select name="colors[]" id="colorsFakeSelector" class="d-none" multiple>
                        @foreach ($colors as $color)
                            <option id="color-{{ $color->id }}" value="{{ $color->id }}"
                                @if (in_array($color->id, $product->colors)) selected @endif>{{ $color->name }}</option>
                        @endforeach
                    </select>
                    <a href="javascript:void(0);" onclick="clearColors()" class="btn btn-danger btn-sm m-1">لغو رنگ</a>
                </div>

                <div class="col-12">
                    <label for="" class="mb-1">تصاویر محصول</label>

                    <div id="productImgBox">
                        <input type="hidden" id="photos" name="photos" class="ClearLoad">
                        <div class="border border-1 border-gray-500 dropzone" id="dropzoneTag">
                            <div class="dz-message">
                                <div class="d-flex flex-column">
                                    <i class="icon-upload m-1 fs-2"></i>
                                    <span class="fs-5">فایل‌های خود را کشیده و اینجا رها کنید</span>
                                    <span class="fs-5">یا اینجا کلیک کنید</span>
                                </div>

                            </div>
                        </div>

                        <label for="" class="productImgChooseLabel my-1 d-none">انتخاب تصویر اول <small
                                class="text-danger">(برای نمایش به عنوان تصویر اصلی محصول)</small></label>

                        <ul class="productImgChoose list-unstyled my-2 d-flex gap-1 p-1">

                        </ul>

                    </div>
                </div>
                <input type="hidden" name="first_pic" id="inputFirstPicId" />
                <input type="text" name="attribute_value" id="attribute_value" value="{{implode(',',$attributesValues)}}" />
            </form>

        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت محصول</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>

        <div id="attrCategoryBox"
            class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100 hidden">
            {{-- {{dd(json_decode($product->attributes_values))}} --}}
            <div class="col-12 d-flex justify-content-between flex-wrap">
                <h6 class="border-bottom border-1 py-2 mb-3 w-100" onclick="selectAttrValue()">ویژگی های دسته بندی</h6>
                <div id="categoryAttr" class="col-12 d-flex flex-column gap-2">
                    @foreach ($attributesGroup as $key => $attrGroup)
                        <h6>{{ $attrGroup->title }}</h6>
                        <select id="selectAttr-{{ $key }}" onchange="selectAttrValue(this,true)"
                            class="searchSelect attrSelect">
                            <option value="0" selected disabled>انتخاب کنید...</option>
                            @foreach ($attrGroup->attributes_value as $key => $attrValue)
                                <option value="{{$attrValue->id}}" @if (in_array($attrValue->id,$attributesValues)) selected @endif>{{$attrValue->title}}</option>
                            @endforeach
                        </select>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#inputDescription'), {
                language: 'fa'
            })
            .then(editor => {
                window.editor = editor;
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', '300px', editor.editing.view.document.getRoot());
                    writer.setStyle('max-height', '400px', editor.editing.view.document.getRoot());
                });
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>

    <script>
        var getAttrUrl = "{{ route('products.attributes', 'id') }}";
    </script>

    <script>
        const dateTime = new Date();
        const subFolder = "{{$product->photos[0]->is_dir}}";

        let photosId = [];
        var c = 0;

        $("div#dropzoneTag").dropzone({
            addRemoveLinks: true,
            uploadMultiple: false,
            url: "{{ route('mediafiles.upload') }}",
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}")
                formData.append("type", 'image')
                formData.append("folder", "products/" + subFolder)
                formData.append("is_dir", subFolder)
                formData.append("mimesFile", "jpg,jpeg,png")
                formData.append("thumbnail", "true")
            },
            init: function() {
                this.on("success", (file, responseText) => {
                    photosId.push(responseText['mediafile_id']);
                    $('#photos').val(photosId);
                    let active = '';
                    if (c == 0) {
                        active = 'active';
                        $('#inputFirstPicId').val(responseText['mediafile_id']);
                    }
                    c++;
                    const tag =
                        '<li class="p-1 productImgItem ' + active +
                        '" onClick="selectFirstImage(this)" id="PI-' +
                        responseText['mediafile_id'] + '">' +
                        '<img src="' + responseText['thumbnail'] + '" class="rounded-3">' +
                        '</li>';
                    $('.productImgChoose').append(tag);
                    $('.productImgChooseLabel').removeClass('d-none');
                });
                this.on("error", function(file, responseText) {
                    $('.uploadError').fadeIn(1500);
                    $('.uploadError .errorBody').text(responseText['errors']['file']);

                });
                this.on("removedfile", async (file, responseText) => {
                    let id;
                    $('.dz-message').addClass('d-none');
                    if (responseText != null) {
                        var response = JSON.parse(file['xhr']['responseText']);
                        id = response['mediafile_id'];
                    } else {
                        id = file.id;
                    }
                    var formData = new FormData()
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("id", id);

                    if (id) {
                        const response = await fetch("{{ route('mediafiles.remove') }}", {
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
                            // $('.dz-message').addClass('d-none');
                            setTimeout(() => {
                                $("#PI-" + id).remove();
                                if (document.getElementsByClassName("productImgItem")
                                    .length == 0) {
                                    $('.productImgChooseLabel').addClass('d-none');
                                    $('#inputFirstPicId').val('');
                                    c = 0;
                                }
                            }, 300);
                            if (document.getElementsByClassName("dz-preview").length == 0) {
                                $('.dz-message').removeClass('d-none')
                            }
                        }
                    }
                });
            }
        });

        var myDropzone = $("div#dropzoneTag").get(0).dropzone;

        var getPhotosUrl = "{{ route('products.photos', 'id') }}";
        $.ajax({
            url: getPhotosUrl.replace("id", {{ $product->id }}),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                data.photos.forEach(function(val) {
                    var mockFile = {
                        id: val.id,
                        name: val.path,
                        size: val.size,
                    }; // اطلاعات جعلی برای فایل
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, val.thumbnail);
                    var myElement = document.getElementsByClassName("dz-progress");
                    // تغییر display به "none"
                    myElement.forEach((tag) => {
                        tag.style.display = "none";
                    })

                    photosId.push(val.id);
                    let active = '';
                    if (val.pivot.first == 1) {
                        active = 'active';
                        $('#inputFirstPicId').val(val.id);
                    }
                    c++;
                    const tag =
                        '<li class="p-1 productImgItem ' + active +
                        '" onClick="selectFirstImage(this)" id="PI-' +
                        val.id + '">' +
                        '<img src="' + val.thumbnail + '" class="rounded-3">' +
                        '</li>';
                    $('.productImgChoose').append(tag);
                    $('.productImgChooseLabel').removeClass('d-none');
                });
                $('#photos').val(photosId);
            },
            error: function(error) {
                console.log('Error fetching image data: ', error.status);
            }
        });
    </script>

    <script src="{{ asset('js/ajax.js') }}"></script>
@endsection
