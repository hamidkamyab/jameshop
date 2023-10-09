@extends('admin.layouts.master')

@section('navigation')
    ایجاد مقدار ویژگی
@endsection

@section('content')
    <div class="row justify-content-center">
        @if (count($errors) > 0)
                @include('admin.partials.Alert',['msg'=>$errors->all(),'status'=>'danger'])
        @endif
        <div class="col-6 py-4">
            <form class="row g-4" action="{{ route('attributes_value.store') }}" method="post">
                @csrf
                <div class="col-12">
                    <label for="inputTitle" class="form-label">مقدار</label>
                    <input type="text" class="form-control" id="inputTitle" name="title"
                        placeholder="مقدار ویژگی..." value="{{ old('title') }}" />
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">ویژگی</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="attributes_group_id">
                        <option selected disabled>انتخاب کنید...</option>
                        @foreach ($attributesGroup as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">ثبت مقدار ویژگی </button>
                    <a href="{{ route('attributes_value.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>

            </form>

        </div>
    </div>

@endsection
