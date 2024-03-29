﻿@extends('admin.layouts.master')


@section('navigation')
    ایجاد برگه دسته بندی
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('category_tabs.store') }}" method="post" id="formTarget">
                @csrf

                <div class="form-group col-6 mb-3">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <small class="text-danger">(در صورت خالی بودن، از عنوان دسته بندی میخواند!)</small>
                    <input type="text" id="inputTitle" class="form-control BYekan" name="title" value="{{old('title')}}"
                    placeholder="عنوان برگه..." />
                </div>

                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته بندی</label>
                    <select class="form-select searchSelect select-cl mb-4" id="inputParent" name="category_id"
                        data-id="categoriesList" >
                        <option selected disabled value="choose">انتخاب کنید...</option>
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
            </form>
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت</button>
                <a href="{{ route('category_tabs.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
