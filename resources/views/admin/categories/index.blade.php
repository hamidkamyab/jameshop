@extends('admin.layouts.master')

@section('navigation')
    دسته بندی ها
@endsection
@section('navBtnBox')
    <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
        <i class="icon-plus"></i>
        <span>افزودن</span>
    </a>
@endsection
@section('content')
    <div class="bg-white col-12 p-3 pb-5 border-start border-4 border-info right-box">
        @if (Session::has('opration_category'))
            @include('admin.partials.Alert', [
                'msg' => [session('opration_category')],
                'status' => 'success',
            ])
        @endif
        @if (Session::has('error_category'))
            @include('admin.partials.Alert', ['msg' => [session('error_category')], 'status' => 'danger'])
        @endif
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">عنوان دسته</th>
                    <th class="fw-normal fs-18">تاریخ ایجاد</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small
                            class="fs-12">(الحاق ویژگی - مشاهده ویژگی - ویرایش - حذف)</small></th>
                </tr>
            </thead>
            <tbody>
                {{ session(['count' => 0]) }}
                @foreach ($categories as $key => $category)
                    <tr class="bg-light-gray">
                        <td>{{ session('count') + 1 }}{{ session(['count' => session('count') + 1]) }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ verta($category->created_at)->format('Y/m/d') }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('categories.attributes_create', $category->id) }}"
                                    title="الحاق ویژگی به دسته {{ $category->title }}" class="text-primary">
                                    <i class="icon-attach fs-6"></i>
                                </a>
                                <button type="button" title="نمایش ویژگی های دسته {{ $category->title }}"
                                    class="AttributeModalBtn text-orange border-0 p-0 bg-transparent" data-bs-toggle="modal"
                                    data-bs-target="#AttributeModal" id="{{$category->id}}">
                                    <i class="icon-eye fs-6"></i>
                                </button>
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    title="ویرایش دسته {{ $category->title }}" class="text-success">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="Post"
                                    class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger border-0 p-0 bg-transparent"
                                        title="حذف دسته {{ $category->title }}">
                                        <i class="icon-trash fs-6"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @if ($category->children)
                        @include('admin.partials.CategoryList', [
                            'categories' => $category->children,
                            'level' => 1,
                        ])
                    @endif
                @endforeach
            </tbody>
        </table>
        <div>{{ $categories->links() }}</div>
        @include('admin.partials.CategoryAttributes')
    </div>

@endsection


@section('footer')
<script>
    const _token =  "{{ csrf_token() }}";
    const url = "{{route('categories.attributes_list')}}"
</script>
<script src="{{asset('js/ajax.js')}}"></script>
@endsection
