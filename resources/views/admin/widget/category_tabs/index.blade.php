@extends('admin.layouts.master')

@section('navigation')
    برگه دستی بندی ها
@endsection
@section('navBtnBox')
    <a href="{{ route('category_tabs.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
        <i class="icon-plus"></i>
        <span>افزودن</span>
    </a>
@endsection
@section('content')
    <div class="bg-white col-12 p-3 border-start border-4 border-info right-box">
        @if (Session::has('opration_catTab'))
            @include('admin.partials.Alert', [
                'msg' => [session('opration_catTab')],
                'status' => 'success',
            ])
        @endif
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">عنوان</th>
                    <th class="fw-normal fs-18">دسته بندی</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small
                            class="fs-12">(ویرایش - حذف - افزودن زیر مجموعه)</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catTabs as $key => $catTab)
                    @if ($catTab->parent_id == 0)
                        <tr class="align-middle">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if ($catTab->title)
                                    {{ $catTab->title }}
                                @else
                                    {{ $catTab->category->title }}
                                @endif
                            </td>
                            <td>{{ $catTab->category->title }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-3 pt-1">
                                    <a href="{{ route('category_tabs.edit', $catTab->id) }}"
                                        title=" ویرایش برگه {{ $catTab->title }} ">
                                        <i class="icon-edit-1 fs-6"></i>
                                    </a>
                                    <form action="{{ route('category_tabs.destroy', $catTab->id) }}" method="Post"
                                        class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger border-0 p-0 bg-transparent"
                                            title=" حذف برگه {{ $catTab->title }} ">
                                            <i class="icon-trash fs-6"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('category_tabs.children.create', $catTab->id) }}"
                                        title=" ویرایش برگه {{ $catTab->title }} ">
                                        <i class="icon-plus-circle-1 text-success fs-6"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if (count($catTab->children) > 0)
                        <tr>
                            <td colspan="4">
                                <table class="border border-secondary table table-striped">
                                    <thead class="bg-secondary text-white">
                                        <tr>
                                            <th class="fw-normal fs-18">عنوان</th>
                                            <th class="fw-normal fs-18">دسته بندی</th>
                                            <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small
                                                    class="fs-12">(ویرایش - حذف)</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($catTab->children as $child)
                                            <tr class="align-middle">
                                                <td>
                                                    @if ($child->title)
                                                        {{ $child->title }}
                                                    @else
                                                        {{ $child->category->title }}
                                                    @endif
                                                </td>
                                                <td>{{ $child->category->title }}</td>
                                                <td>
                                                    <div
                                                        class="d-flex align-items-center justify-content-center gap-3 pt-1">
                                                        <a href="{{ route('category_tabs.children.edit', $child->id) }}"
                                                            title=" ویرایش برگه {{ $child->title }} ">
                                                            <i class="icon-edit-1 fs-6"></i>
                                                        </a>
                                                        <form action="{{ route('category_tabs.destroy', $child->id) }}"
                                                            method="Post" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-danger border-0 p-0 bg-transparent"
                                                                title=" حذف برگه {{ $child->title }} ">
                                                                <i class="icon-trash fs-6"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div>{{ $catTabs->links() }}</div>

    </div>
@endsection
