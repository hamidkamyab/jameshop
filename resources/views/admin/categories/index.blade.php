@extends('admin.layouts.master')

@section('navigation')
    دسته بندی ها
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center px-2 reportCard mb-5">
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
                <tr>
                    <td>1</td>
                    <td>تیشرت</td>
                    <td>پوشاک</td>
                    <td>1402/07/05</td>
                    <td>
                        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>کلاه</td>
                    <td>پوشاک</td>
                    <td>1402/07/05</td>
                    <td>
                        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
