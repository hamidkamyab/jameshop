@extends('admin.layouts.master')

@section('navigation')
    ویرایش برند
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row gap-4 m-0" action="{{ route('brands.update', $brand->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-6">
                        <label for="inputTitle" class="form-label">عنوان</label>
                        <input type="text" class="form-control" id="inputTitle" name="title" placeholder="عنوان برند..."
                            value="{{ $brand->title }}">
                    </div>
                    <div class="col-6">
                        <label for="inputTitle" class="form-label">کشور</label>
                        <select class="form-select searchSelect mb-4" id="inputParent" name="country_id">
                            <option value="null">انتخاب کنید...</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if($country->id == $brand->country_id) selected @endif>{{ $country->fa_name }} - {{ $country->en_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputTitle" class="form-label">تصویر برند</label>
                    <div class=" d-flex align-items-end justify-content-start gap-3 noSelect">
                        <div class="FileBox d-flex align-items-center justify-content-center rounded-3 p-1">
                            <i class="icon-picture text-muted fs-1"></i>
                            <img src="{{ @$brand->media[0]->file->path }}" id="FileImg" />
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            آپلود تصویر برند
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea type="text" class="form-control" id="inputDescription" name="description" placeholder="توضیحات برند...">{{ $brand->description }}</textarea>
                </div>
                <input type="hidden" name="photo_id" id="file_id" value="{{ @$brand->photo->id }}">
            </form>
            @include('admin.partials.ModalUpload', [
                'title' => 'تصویر برند',
                'upload' => route('files.upload'),
                'folder' => 'brands',
                'type' => 'image',
            ])
        </div>
    </div>
    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ویرایش برند</button>
                <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
