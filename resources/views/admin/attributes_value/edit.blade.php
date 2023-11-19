@extends('admin.layouts.master')

@section('navigation')
    ویرایش مقدار ویژگی
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('attributes_value.update', $attributeValue->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">مقدار ویژگی</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="مقدار ویژگی..."
                        value="{{ $attributeValue->title }}">
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">ویژگی</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="attributes_group_id">
                        <option selected disabled>انتخاب کنید...</option>
                        @foreach ($attributesGroup as $attribute)
                            <option value="{{ $attribute->id }}" @if ($attributeValue->attributes_group_id == $attribute->id) selected @endif>
                                {{ $attribute->title }}</option>
                        @endforeach
                    </select>
                </div>

            </form>

        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ویرایش مقدار ویژگی</button>
                <a href="{{ route('attributes_value.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
