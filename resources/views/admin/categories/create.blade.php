﻿@extends('admin.layouts.master')

@section('navigation')
    ایجاد دسته بندی
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('categories.store') }}" method="post" id="formTarget" >
                @csrf
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان دسته بندی..."
                        value="{{ old('title') }}" />
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نام مستعار</label>
                    <small class="text-danger">(برای استفاده در لینک)</small>
                    <input type="text" class="form-control" id="inputSlug" name="slug"
                        placeholder="نام مستعار دسته بندی..." value="{{ old('slug') }}" />
                </div>
                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته والد</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="parent_id">
                        <option selected disabled value="choose">انتخاب کنید...</option>
                        <option value="0">بدون والد</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @if ($category->children)
                                @include('admin.partials.CategoryChildren', [
                                    'categories' => $category->children,
                                    'level' => 1,
                                    'toltipTitle' => $category->title
                                ])
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="inputTitle" class="form-label">تصویر دسته بندی</label>
                    <small class="fs-10 text-danger">(افزودن تصویر اختیاری می باشد)</small>
                    <div class=" d-flex align-items-end justify-content-start gap-3 noSelect">
                        <div class="FileBox d-flex align-items-center justify-content-center rounded-3 p-1">
                            <i class="icon-picture text-muted fs-1"></i>
                            @if (old('photo_path'))
                                <img src="{{ old('photo_path') }}" id="FileImg" class="w-100" />
                            @else
                                <img src="" class="w-100" id="FileImg" />
                            @endif
                        </div>
                        <button type="button" class="btn btn-primary @if (old('photo_path')) disabled @endif"
                            data-bs-toggle="modal" data-bs-target="#uploadModal" id="uploadModalBtn">
                            آپلود تصویر
                        </button>
                        <button type="button"
                            class="btn btn-danger @if (old('photo_path')) '' @else d-none @endif"
                            id="deleteBrandImg">
                            حذف تصویر برند
                        </button>
                    </div>
                    <input type="hidden" name="photo_path" id="file_path">
                    <input type="hidden" name="photo_id" id="file_id" value="{{ old('photo_id') }}">
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea class="form-control" id="inputDescription" name="description" placeholder="توضیحات دسته بندی...">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputMetaDescription" class="form-label">متا توضیحات</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <textarea class="form-control" id="inputMetaDescription" name="meta_description"
                        placeholder="توضیحات متا تگ دسته بندی...">{{ old('meta_description') }}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputKeywords" class="form-label">کلمات کلیدی</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <small class="text-danger">(بیشتر از 5 کلمه کلیدی وارد نکنید!)</small>
                    <input type="text" class="form-control" id="inputKeywords" name="meta_keywords"
                        placeholder="کلمات کلیدی را با '،' جدا کنید" value="{{ old('meta_keywords') }}">

                </div>

            </form>
            @include('admin.partials.ModalUpload', [
                'title' => 'تصویر دسته بندی',
                'upload' => route('files.upload'),
                'folder' => 'category',
                'type' => 'image',
            ])
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت دسته بندی</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<script src="{{ asset('js/ajax.js') }}"></script>
@endsection
