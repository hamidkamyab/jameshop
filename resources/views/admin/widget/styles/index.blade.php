@extends('admin.layouts.master')

@section('navigation')
    استیل هفته
@endsection
@section('navBtnBox')
    <a href="{{ route('styles.create') }}" class="btn btn-success d-flex align-items-center">
        <i class="icon-plus"></i>
        <span>افزودن</span>
    </a>
@endsection
@section('content')
    <div class="bg-white col-12 p-3 border-start border-4 border-info right-box">
        @if (Session::has('opration_style'))
            @include('admin.partials.Alert', ['msg' => [session('opration_style')], 'status' => 'success'])
        @endif

        @if (Session::has('error_attr'))
            @include('admin.partials.Alert', ['msg' => [session('error_attr')], 'status' => 'danger'])
        @endif
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">عنوان</th>
                    <th class="fw-normal fs-18">تاریخ اتمام</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small
                            class="fs-12">(ویرایش - حذف)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($styles as $key => $style)
                    <tr class="align-middle">
                        <td>{{ $key + 1 }}</td>
                        <td >{{$style->title}}</td>
                        <td class="d-ltr text-start">{{convertMtoJ($style->date)}}</td>

                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('styles.edit', $style->id) }}" title=" ویرایش استایل هفته {{ $style->title }} ">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <form action="{{ route('styles.destroy', $style->id) }}" method="Post" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger border-0 p-0 bg-transparent"
                                        title=" حذف استایل هفته {{ $style->title }} ">
                                        <i class="icon-trash fs-6"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{ $styles->links() }}</div>

    </div>
@endsection
