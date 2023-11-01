﻿@extends('admin.layouts.master')

@section('navigation')
    ایجاد دسته بندی
@endsection

@section('content')
    <div class="row justify-content-center">
        @if (count($errors) > 0)
                @include('admin.partials.Alert',['msg'=>$errors->all(),'status'=>'danger'])
        @endif
        <div class="col-6 py-4">
            <form class="row g-4" action="{{ route('categories.update',$category->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title"  placeholder="عنوان دسته بندی..." value="{{$category->title}}">
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نام مستعار</label>
                    <small class="text-danger">(برای استفاده در لینک)</small>
                    <input type="text" class="form-control" id="inputSlug" name="slug" placeholder="نام مستعار دسته بندی..." value="{{$category->slug}}">
                </div>
                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته والد</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="parent_id">
                        <option selected disabled>انتخاب کنید...</option>
                        @foreach ($categories as $category_children)
                            <option value="{{ $category_children->id }}" @if($category->parent_id == $category_children->id) selected @endif>{{ $category_children->title }}</option>
                            @if($category_children->children)
                                @include('admin.partials.CategoryCreate',['categories'=>$category_children->children,'level'=>1,'parent_id'=> $category->parent_id])
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea class="form-control" id="inputDescription" name="description"  placeholder="توضیحات دسته بندی...">{{$category->description}}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputMetaDescription" class="form-label">متا توضیحات</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <textarea class="form-control" id="inputMetaDescription" name="meta_description" placeholder="توضیحات متا تگ دسته بندی...">{{$category->meta_description}}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputKeywords" class="form-label">کلمات کلیدی</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <small class="text-danger">(بیشتر از 5 کلمه کلیدی وارد نکنید!)</small>
                    <input type="text" class="form-control" id="inputKeywords" name="meta_keywords"
                        placeholder="کلمات کلیدی را با '،' جدا کنید" value="{{$category->meta_keywords}}">

                </div>

                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">ویرایش دسته بندی</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>

            </form>

        </div>
    </div>

@endsection