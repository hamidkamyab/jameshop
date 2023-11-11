@extends('admin.layouts.master')

@section('navigation')
    ویرایش سایزبندی
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row gap-4 m-0" action="{{ route('sizes.update', $size->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان سایز..."
                        value="{{ $size->title }}">
                </div>
            </form>
        </div>
    </div>

    <div class="col-3 bg-white p-2 pe-3 border-start border-4 border-info left-box">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ویرایش سایز</button>
                <a href="{{ route('sizes.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
