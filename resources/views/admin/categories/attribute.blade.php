@extends('admin.layouts.master')

@section('navigation')
    ثبت ویژگی دسته بندی {{ $data['category']->title }}
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('categories.attributes_store', $data['category']->id) }}" method="post"
                id="formTarget">
                @csrf
                <div class="col-12">
                    <label for="inputAttribute" class="form-label">
                        ویژگی
                        <small class="text-primary ms-1">(ویژگی های مدنظرتان را انتخاب کنید)</small>
                    </label>
                    <select class="form-select searchSelect mb-4" id="inputAttribute" name="attributes_id[]" multiple>
                        @foreach ($data['attributes_group'] as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->title }}</option>
                        @endforeach
                    </select>
                </div>
                @if (count($data['attributes_group_this_filter']) > 0)
                    <div class="col-12 border-bottom border-1 py-4">
                        <h6 class="mb-2">ویژگی های زیر به دسته {{ $data['category']->title }} الحاق شده است.</h6>
                        @foreach ($data['attributes_group_this_filter'] as $attribute_group_this_filter)
                            <span
                                class="badge attrGroupItem text-dark p-2 BYekan">{{ $attribute_group_this_filter->title }}</span>
                        @endforeach
                    </div>
                @endif
                <div class="col-12">
                    @if (count($data['attributes_group_filter']) > 0)
                        <h6 class="mb-2">ویژگی های زیر به دسته های والد یا فرزند الحاق شدن</h6>
                        @foreach ($data['attributes_group_filter'] as $attribute_group_filter)
                            <span
                                class="badge attrGroupItem text-dark p-2 BYekan">{{ $attribute_group_filter->title }}</span>
                        @endforeach
                    @endif
                </div>

            </form>

        </div>
    </div>
    <div class="col-3 left-box d-flex flex-wrap gap-3">

        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">الحاق ویژگی</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>

    </div>
@endsection
