@extends('admin.layouts.master')

@section('head')
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        Launch static backdrop modal
                    </button>
                </div>
                <div class="col-12 d-flex justify-content-between">
                    <input type="hidden" name="photo_id" id="photo_id" >
                    <button type="submit" class="btn btn-primary">ثبت برند</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>
            </form>

            @include('admin.partials.ModalUpload', [
                'title' => 'تصویر برند',
                'url' => route('photos.upload'),
            ])
        </div>
    </div>
@endsection



