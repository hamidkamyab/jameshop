@extends('admin.layouts.master')

@section('navigation')
رنگ ها
@endsection
@section('content')
    <div class="bg-white col-12 p-3 pb-5 border-start border-4 border-info right-box">
        @if(Session::has('opration_color'))
            @include('admin.partials.Alert',['msg'=>[session('opration_color')],'status'=>'success'])
        @endif

        @if(Session::has('error_attr'))
            @include('admin.partials.Alert',['msg'=>[session('error_attr')],'status'=>'danger'])
        @endif
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">نام رنگ</th>
                    <th class="fw-normal fs-18 text-center">رنگ</th>
                    <th class="fw-normal fs-18">تاریخ ایجاد</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small class="fs-12">(ویرایش - حذف)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colors as $key=>$color)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$color->name}}</td>
                        <td class="text-center">
                            <span class="colorPreview" style="background-color: {{$color->code}}"></span>
                        </td>
                        <td>{{verta($color->created_at)->format('H:i:s')}} - {{verta($color->created_at)->format('Y/m/d')}}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('colors.edit', $color->id) }}" title="ویرایش رنگ {{ $color->name }}">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <form action="{{route('colors.destroy',$color->id)}}" method="Post"  class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger border-0 p-0 bg-transparent" title="حذف رنگ {{$color->name}}">
                                        <i class="icon-trash fs-6"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{$colors->links()}}</div>

    </div>
@endsection
