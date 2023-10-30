@extends('admin.layouts.master')

@section('navigation')
    ایجاد دسته بندی
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('attributes_group.update', $attributeGroup->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان ویژگی..."
                        value="{{ $attributeGroup->title }}">
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نوع ویژگی</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <label for="inputTypeOne" role="button">تکی</label>
                            <input type="radio" class="form-check-input" id="inputTypeOne" name="type"
                                @if ($attributeGroup->getRawOriginal('type') == '0') checked @endif value="0" role="button" />
                        </div>
                        <div class="form-check">
                            <label for="inputTypeMulti" role="button">دسته ای</label>
                            <input type="radio" class="form-check-input" id="inputTypeMulti" name="type"
                                @if ($attributeGroup->getRawOriginal('type') == '1') checked @endif value="1" role="button" />
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته بندی</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="category_id">
                        <option selected disabled>انتخاب کنید...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if($category->id == $attributeGroup->category_id) selected @endif>{{ $category->title }}</option>
                            @if ($category->children)
                                @include('admin.partials.CategoryChildren', [
                                    'categories' => $category->children,
                                    'level' => 1,
                                    'toltipTitle' => $category->title,
                                    'selectedId' => $attributeGroup->category_id
                                ])
                            @endif
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="col-3 bg-white p-2 pe-3 border-start border-4 border-info left-box">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary"  onclick="sendForm('formTarget')">ویرایش ویژگی</button>
                <a href="{{ route('attributes_group.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
