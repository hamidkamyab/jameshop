﻿@extends('admin.layouts.master')

@section('navigation')
    ویرایش برند
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row gap-4 m-0" action="{{ route('brands.update', $brand->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان برند..."
                        value="{{ $brand->title }}">
                </div>
                <div class="col-12">
                    <label for="inputTitle" class="form-label">تصویر برند</label>
                    <div class=" d-flex align-items-end justify-content-start gap-3 noSelect">
                        <div class="mediaFileBox d-flex align-items-center justify-content-center rounded-3 p-1">
                            <i class="icon-picture text-muted fs-1"></i>
                            <img src="{{ $brand->photo()->path }}" id="mediaFileImg" />
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            آپلود تصویر برند
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea type="text" class="form-control" id="inputDescription" name="description" placeholder="توضیحات برند...">{{ $brand->description }}</textarea>
                </div>

                <input type="hidden" name="photo_id" id="mediafile_id" value="{{ $brand->photo()->id }}">

            </form>
            @include('admin.partials.ModalUpload', [
                'title' => 'تصویر برند',
                'upload' => route('mediafiles.upload'),
                'type' => 'image',
            ])
        </div>
    </div>

    <div class="col-3 bg-white p-2 pe-3 border-start border-4 border-info left-box">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">ویرایش برند</button>
                <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
