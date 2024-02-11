@extends('admin.layouts.master')

@section('navigation')
ویژگی ها
@endsection
@section('navBtnBox')
    <a href="{{ route('attributes_group.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
        <i class="icon-plus"></i>
        <span>افزودن</span>
    </a>
@endsection
@section('content')
    <div class="bg-white col-12 p-3 pb-5 border-start border-4 border-info right-box">
        @if(Session::has('opration_attribute'))
            @include('admin.partials.Alert',['msg'=>[session('opration_attribute')],'status'=>'success'])
        @endif

        @if(Session::has('error_attr'))
            @include('admin.partials.Alert',['msg'=>[session('error_attr')],'status'=>'danger'])
        @endif
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">عنوان ویژگی</th>
                    <th class="fw-normal fs-18">نوع ویژگی</th>
                    <th class="fw-normal fs-18">تاریخ ایجاد</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small class="fs-12">(ویرایش - حذف)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attributesGroup as $key=>$attribute)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$attribute->title}}</td>
                        <td>{{$attribute->type}}</td>
                        <td>{{verta($attribute->created_at)->format('H:i:s')}} - {{verta($attribute->created_at)->format('Y/m/d')}}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('attributes_group.edit', $attribute->id) }}" title="ویرایش ویژگی {{ $attribute->title }}">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <form action="{{route('attributes_group.destroy',$attribute->id)}}" method="Post"  class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger border-0 p-0 bg-transparent" title="حذف ویژگی {{$attribute->title}}">
                                        <i class="icon-trash fs-6"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$attributesGroup->links()}}</div>

    </div>
@endsection
