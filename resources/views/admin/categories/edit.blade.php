@extends('admin.layouts.master')

@section('navigation')
    ویرایش دسته بندی
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('categories.update', $category->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان دسته بندی..."
                        value="{{ $category->title }}">
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نام مستعار</label>
                    <small class="text-danger">(برای استفاده در لینک)</small>
                    <input type="text" class="form-control" id="inputSlug" name="slug"
                        placeholder="نام مستعار دسته بندی..." value="{{ $category->slug }}">
                </div>
                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته والد</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="parent_id">
                        <option selected disabled>انتخاب کنید...</option>
                        <option  @if ($category->parent_id == 0) selected @endif value="0">بدون والد</option>
                        @foreach ($categories as $category_children)
                            <option value="{{ $category_children->id }}" @if ($category->parent_id == $category_children->id) selected @endif>
                                {{ $category_children->title }}</option>
                            @if ($category_children->children)
                                @include('admin.partials.CategoryChildren', [
                                    'categories' => $category_children->children,
                                    'level' => 1,
                                    'selectedId' => $category->parent_id,
                                    'toltipTitle' => $category->title
                                ])
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="inputTitle" class="form-label">تصویر برند</label>
                    <div class=" d-flex align-items-end justify-content-start gap-3 noSelect">
                        <div class="FileBox d-flex align-items-center justify-content-center rounded-3 p-1">
                            <i class="icon-picture text-muted fs-1"></i>
                            <img src="{{ @$category->media[0]->file->path }}" id="FileImg" />
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            آپلود تصویر برند
                        </button>
                    </div>
                    <input type="hidden" name="photo_id" id="file_id" value="{{ @$category->media[0]->file_id }}">
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea class="form-control" id="inputDescription" name="description" placeholder="توضیحات دسته بندی...">{{ $category->description }}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputMetaDescription" class="form-label">متا توضیحات</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <textarea class="form-control" id="inputMetaDescription" name="meta_description"
                        placeholder="توضیحات متا تگ دسته بندی...">{{ $category->meta_description }}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputKeywords" class="form-label">کلمات کلیدی</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <small class="text-danger">(بیشتر از 5 کلمه کلیدی وارد نکنید!)</small>
                    <input type="text" class="form-control" id="inputKeywords" name="meta_keywords"
                        placeholder="کلمات کلیدی را با '،' جدا کنید" value="{{ $category->meta_keywords }}">

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
                <button type="submit" class="btn btn-primary"  onclick="sendForm('formTarget')">ویرایش دسته بندی</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
