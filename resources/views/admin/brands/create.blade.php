@extends('admin.layouts.master')


@section('navigation')
    ایجاد برند
@endsection

@section('content')
    <div class="row justify-content-center">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="col-6 py-4">
            <form class="row g-4" action="{{ route('brands.store') }}" method="post">
                @csrf
                <div class="col-12">
                    <label for="inputTitle" class="form-label">نام</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="نام برند..."
                        value="{{ old('title') }}" />
                </div>
                <div class="col-12">
                    <label for="inputTitle" class="form-label">تصویر برند</label>
                    <div class=" d-flex align-items-end justify-content-start gap-3 noSelect">
                        <div class="mediaFileBox d-flex align-items-center justify-content-center rounded-3 p-1">
                            <i class="icon-picture text-muted fs-1"></i>
                            @if(old('photo_path'))
                            <img src="{{old('photo_path')}}" id="mediaFileImg" class="w-100" />
                            @else
                            <img src="" class="w-100"  id="mediaFileImg" />
                            @endif
                        </div>
                        <button type="button" class="btn btn-primary @if(old('photo_path')) disabled @endif" data-bs-toggle="modal" data-bs-target="#uploadModal" id="uploadModalBtn">
                            آپلود تصویر برند
                        </button>
                        <button type="button" class="btn btn-danger @if(old('photo_path')) '' @else d-none @endif" id="deleteBrandImg">
                            حذف تصویر برند
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea name="description" id="inputDescription" class="form-control" placeholder="توضیحات برند...." cols="10"
                        rows="5">{{ old('description') }}</textarea>
                </div>
                <div class="col-12 d-flex justify-content-between">

                    <input type="hidden" name="photo_path" id="mediafile_path" >
                    <input type="hidden" name="photo_id" id="mediafile_id" value="{{old('photo_id')}}">
                    <button type="submit" class="btn btn-primary">ثبت برند</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>
            </form>

            @include('admin.partials.ModalUpload', [
                'title' => 'تصویر برند',
                'upload' => route('mediafiles.upload'),
                'type' => 'image'
            ])
        </div>
    </div>
@endsection
