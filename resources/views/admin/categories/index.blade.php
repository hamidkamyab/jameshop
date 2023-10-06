@extends('admin.layouts.master')

@section('navigation')
    دسته بندی ها
@endsection
@section('content')
    <div class="col-12 d-flex flex-wrap justify-content-center px-2 mb-5">
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">عنوان دسته</th>
                    <th class="fw-normal fs-18">تاریخ ایجاد</th>
                    <th class="fw-normal fs-18">عملیات</th>
                </tr>
            </thead>
            <tbody>
                {{session(['count' => 0])}}
                @foreach ($categories as $key=>$category)
                    <tr class="bg-light-gray">
                        <td>{{(session('count')+1) + (($categories->currentPage()-1) * $categories->perPage())}}{{session(['count' => session('count') + 1])}}</td>
                        <td>{{$category->title}}</td>
                        <td>{{verta($category->created_at)->format('Y/m/d')}}</td>
                        <td>
                            <a href="#" class="text-danger">
                                <i class="icon-cancel-1"></i>
                            </a>
                        </td>
                    </tr>
                    @if($category->children)
                        @include('admin.partials.CategoryList',['categories'=>$category->children,'level'=>1])
                    @endif
                @endforeach
            </tbody>
        </table>
        <div>{{$categories->links()}}</div>

    </div>
@endsection
