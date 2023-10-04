@extends('admin.layouts.master')

@section('navigation')
    دسته بندی ها
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center px-2 mb-5">
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">عنوان دسته</th>
                    <th class="fw-normal fs-18">عنوان دسته والد</th>
                    <th class="fw-normal fs-18">تاریخ ایجاد</th>
                    <th class="fw-normal fs-18">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $key=>$category)
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$category->title}}</td>
                        <td>{{$category->parent_id}}</td>
                        <td>{{$category->created_at}}</td>
                        <td>
                            <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="icon-cancel-1"></i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
