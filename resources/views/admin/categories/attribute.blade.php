@extends('admin.layouts.master')

@section('navigation')
    ثبت ویژگی دسته بندی {{$category->title}}
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('categories.attributes_store',$category->id) }}" method="post" id="formTarget" >
                @csrf
                <div class="col-12">
                    <label for="inputAttribute" class="form-label">
                        ویژگی
                        <small class="text-primary ms-1">(ویژگی های مدنظرتان را انتخاب کنید)</small>
                    </label>
                    <select class="form-select searchSelect mb-4" id="inputAttribute" name="attributes_id[]" multiple>
                        @foreach ($attributes_group as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->title }}</option>
                        @endforeach
                    </select>
                </div>

            </form>

        </div>
    </div>
    <div class="col-3 bg-white p-2 pe-3 border-start border-4 border-info left-box">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">الحاق ویژگی</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection


