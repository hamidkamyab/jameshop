@extends('admin.layouts.master')

@section('navigation')
    ایجاد ویژگی
@endsection

@section('content')
    <div class="row justify-content-center">
        @if (count($errors) > 0)
                @include('admin.partials.Alert',['msg'=>$errors->all(),'status'=>'danger'])
        @endif
        <div class="col-6 py-4">
            <form class="row g-4" action="{{ route('attributes_group.store') }}" method="post">
                @csrf
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title"
                        placeholder="عنوان ویژگی..." value="{{ old('title') }}" />
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نوع ویژگی</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <label for="inputTypeOne"  role="button">تکی</label>
                            <input type="radio" class="form-check-input" id="inputTypeOne" name="type" value="0" role="button" />
                        </div>
                        <div class="form-check">
                            <label for="inputTypeMulti"  role="button">دسته ای</label>
                            <input type="radio" class="form-check-input" id="inputTypeMulti" name="type" value="1" role="button" />
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">ثبت ویژگی</button>
                    <a href="{{ route('attributes_group.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>

            </form>

        </div>
    </div>

@endsection
