@extends('admin.layouts.master')

@section('navigation')
    ویرایش برند
@endsection

@section('content')
    <div class="row justify-content-center">
        @if (count($errors) > 0)
                @include('admin.partials.Alert',['msg'=>$errors->all(),'status'=>'danger'])
        @endif
        <div class="col-6 py-4">
            <form class="row g-4" action="{{ route('brands.update',$brand->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" class="form-control" id="inputTitle" name="title"  placeholder="عنوان برند..." value="{{$brand->title}}">
                </div>
                <div class="col-12">
                    <label for="inputTitle" class="form-label">تصویر برند</label>
                    <div class=" d-flex align-items-end justify-content-start gap-3 noSelect">
                        <div class="brand_imgDiv d-flex align-items-center justify-content-center rounded-3 p-1">
                            <i class="icon-picture text-muted fs-1"></i>
                            <img src="{{$brand->photo->path}}" class="w-100" />
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            آپلود تصویر برند
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputDescription" class="form-label">توضیحات</label>
                    <textarea type="text" class="form-control" id="inputDescription" name="description"  placeholder="توضیحات برند..." >{{$brand->description}}</textarea>
                </div>

                <div class="col-12 d-flex justify-content-between">
                    <input type="hidden" name="photo_id" id="photo_id" value="{{$brand->photo->id}}">
                    <button type="submit" class="btn btn-primary">ویرایش برند</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">انصراف</a>
                </div>

            </form>
            @include('admin.partials.ModalUpload', [
                'title' => 'تصویر برند',
                'url' => route('photos.upload'),
            ])
        </div>
    </div>

@endsection
