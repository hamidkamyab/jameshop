@extends('admin.layouts.master')

@section('navigation')
    ایجاد دسته بندی
@endsection

@section('content')
    <div class="col-6 py-4">
        <form class="row g-4" action="{{ route('categories.store') }}" method="post">
            @csrf
            <div class="col-12">
                <label for="inputTitle" class="form-label">عنوان</label>
                <input type="text" class="form-control" id="inputTitle" name="title">
            </div>
            <div class="col-12">
                <label for="inputSlug" class="form-label">نام مستعار</label>
                <small class="text-danger">(برای استفاده در لینک)</small>
                <input type="text" class="form-control" id="inputSlug" name="slug">
            </div>
            <div class="col-12">
                <label for="inputDescription" class="form-label">توضیحات</label>
                <textarea class="form-control" id="inputDescription" name="description"></textarea>
            </div>
            <div class="col-12">
                <label for="inputMetaDescription" class="form-label">متا توضیحات</label>
                <small class="text-danger">(برای افزایش سئو سایت)</small>
                <textarea class="form-control" id="inputMetaDescription" name="meta_description"></textarea>
            </div>
            <div class="col-12">
                <label for="inputKeywords" class="form-label">کلمات کلیدی</label>
                <small class="text-danger">(برای افزایش سئو سایت)</small>
                <small class="text-danger">(بیشتر از 5 کلمه کلیدی وارد نکنید!)</small>
                <input type="text" class="form-control" id="inputKeywords"  name="meta_keywords" placeholder="کلمات کلیدی را با '،' جدا کنید">

            </div>
            <div class="col-6">
                <label for="inputParent" class="form-label">دسته والد</label>
                <select id="inputParent" class="form-select" name="parent_id">
                    <option selected disabled>انتخاب کنید...</option>
                    <option value="1">دسته اول</option>
                </select>
            </div>
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">ثبت دسته بندی</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>

        </form>


    </div>
@endsection
