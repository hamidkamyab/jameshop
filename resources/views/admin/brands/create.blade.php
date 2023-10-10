@extends('admin.layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
@endsection
@section('navigation')
    ایجاد ویژگی
@endsection

@section('content')
    <div class="row justify-content-center">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="col-6 py-4">
            <form class="row g-4" action="{{ route('brands.store') }}" method="post">
                @csrf
                <div class="col-12">
                    <label for="inputTitle" class="form-label">نام</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="نام برند..."
                        value="{{ old('title') }}" />
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea name="description" id="inputDescription" class="form-control" placeholder="توضیحات برند...." cols="10"
                        rows="5"></textarea>
                </div>
                <div class="col-12">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        آپلود تصویر برند
                    </button>
                </div>
                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">ثبت برند</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>
            </form>
            @include('admin.partials.ModalUpload',['title'=>'تصویر برند','url'=>route('photos.upload')])
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
@endsection

{{-- <script>
    Dropzone.autoDiscover = false; // غیرفعال کردن اتوماتیک Dropzone
    let myDropzone = new Dropzone("#dropzoneTag", {

        maxFilesize: 2, // حداکثر اندازه فایل (مگابایت)
        acceptedFiles: ".avi", // نوع‌های مجاز فایل
        paramName: "file", // نام فیلد برای ارسال فایل
        uploadMultiple: false, // امکان آپلود چند فایل به صورت همزمان غیرفعال باشد
        addRemoveLinks: true, // اضافه کردن لینک حذف فایل
        // تنظیمات دیگر
        init: function() {
            this.on("success", function(file, response) {
                // عملیات موفقیت‌آمیز پس از آپلود فایل
                console.log(response);
            });
        },
    });
</script> --}}
