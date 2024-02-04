@extends('admin.layouts.master')

@section('navigation')
    طراحان برتر
@endsection
@section('navBtnBox')
    <a href="{{ route('top_brands.create') }}" class="btn btn-success d-flex align-items-center">
        <i class="icon-plus"></i>
        <span>افزودن</span>
    </a>
@endsection
@section('content')
    <div class="bg-white col-12 p-3 border-start border-4 border-info right-box">
        @if (Session::has('opration_top_brand'))
            @include('admin.partials.Alert', ['msg' => [session('opration_top_brand')], 'status' => 'success'])
        @endif

        @if (Session::has('error_attr'))
            @include('admin.partials.Alert', ['msg' => [session('error_attr')], 'status' => 'danger'])
        @endif
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">برند</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small
                            class="fs-12">(ویرایش - حذف)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topBrands as $key => $topBrand)
                    <tr class="align-middle">
                        <td>{{ $key + 1 }}</td>
                        <td>{{$topBrand->brand->title}}</td>

                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('top_brands.edit', $topBrand->id) }}" title="ویرایش">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <form action="{{ route('top_brands.destroy', $topBrand->id) }}" method="Post" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger border-0 p-0 bg-transparent"
                                        title="حذف">
                                        <i class="icon-trash fs-6"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{ $topBrands->links() }}</div>

    </div>
@endsection
