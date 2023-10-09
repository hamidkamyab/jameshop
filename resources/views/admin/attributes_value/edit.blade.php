@extends('admin.layouts.master')

@section('navigation')
    ایجاد دسته بندی
@endsection

@section('content')
    <div class="row justify-content-center">
        @if (count($errors) > 0)
                @include('admin.partials.Alert',['msg'=>$errors->all(),'status'=>'danger'])
        @endif
        <div class="col-6 py-4">
            <form class="row g-4" action="{{ route('attributes_group.update',$attributeGroup->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title"  placeholder="عنوان ویژگی..." value="{{$attributeGroup->title}}">
                </div>
                <div class="col-12">
                    <label for="inputSlug" class="form-label">نوع ویژگی</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <label for="inputTypeOne"  role="button">تکی</label>
                            <input type="radio" class="form-check-input" id="inputTypeOne" name="type" @if($attributeGroup->getRawOriginal('type') == '0') checked @endif value="0" role="button" />
                        </div>
                        <div class="form-check">
                            <label for="inputTypeMulti"  role="button">دسته ای</label>
                            <input type="radio" class="form-check-input" id="inputTypeMulti" name="type" @if($attributeGroup->getRawOriginal('type') == '1') checked @endif value="1" role="button" />
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">ثبت دسته بندی</button>
                    <a href="{{ route('attributes_group.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>

            </form>

        </div>
    </div>

@endsection
