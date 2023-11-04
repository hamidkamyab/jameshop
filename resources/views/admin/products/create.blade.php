@extends('admin.layouts.master')

@section('navigation')
    ایجاد محصول جدید
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('products.store') }}" method="post">
                @csrf
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان محصول..."
                        value="{{ old('title') }}" />
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نام مستعار</label>
                    <small class="text-danger">(برای استفاده در لینک)</small>
                    <input type="text" class="form-control" id="inputSlug" name="slug"
                        placeholder="نام مستعار محصول..." value="{{ old('slug') }}" />
                </div>

                <div class="col-12">
                    <label for="inputSlug" class="form-label">توضیحات</label>
                    <textarea name="discription" id="inputDiscription">{{ old('discription') }}</textarea>
                </div>

                <div class="col-6">
                    <label for="inputBrand" class="form-label">برند</label>
                    <select class="form-select searchSelect mb-4" id="inputBrand" name="brand_id">
                        <option selected disabled>انتخاب کنید...</option>
                        <option value="null">متفرقه</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته بندی <small class="text-danger fs-12">(دسته بندی دارای
                            زیر مجموعه را نمیتوان انتخاب کرد!)</small></label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="parent_id" data-id="categoriesList"
                        onchange="getAttrCat(event)">
                        <option selected disabled>انتخاب کنید...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (count($category->children) > 0) disabled @endif>
                                {{ $category->title }}</option>
                            @if ($category->children)
                                @include('admin.partials.CategoryChildren', [
                                    'categories' => $category->children,
                                    'level' => 1,
                                    'toltipTitle' => $category->title,
                                    'disableParent' => true,
                                ])
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="inputMetaDescription" class="form-label">متا توضیحات</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <textarea class="form-control" id="inputMetaDescription" name="meta_description" placeholder="توضیحات متاتگ محصول...">{{ old('meta_description') }}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputKeywords" class="form-label">کلمات کلیدی</label>
                    <small class="text-danger">(برای افزایش سئو سایت)</small>
                    <small class="text-danger">(بیشتر از 5 کلمه کلیدی وارد نکنید!)</small>
                    <input type="text" class="form-control" id="inputKeywords" name="meta_keywords"
                        placeholder="کلمات کلیدی را با '،' جدا کنید" value="{{ old('meta_keywords') }}">

                </div>

                <input type="hidden" name="attribute_value" />

            </form>

        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">ثبت محصول</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>

        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between flex-wrap">
                <h6 class="border-bottom border-1 py-2 mb-3 w-100">ویژگی های دسته بندی</h6>
                <div id="categoryAttr" class="col-12 d-flex flex-column gap-2">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#inputDiscription'), {
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
    <script src="{{ asset('js/ajax.js') }}"></script>


@endsection
