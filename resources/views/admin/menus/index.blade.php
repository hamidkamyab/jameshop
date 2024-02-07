@extends('admin.layouts.master')

@section('navigation')
    منوها
@endsection
@section('content')
    <div class="bg-white col-12 p-3 border-start border-4 border-info right-box">
        @if (Session::has('opration_menu'))
            @include('admin.partials.Alert', ['msg' => [session('opration_menu')], 'status' => 'success'])
        @endif
        <table class="table">
            <thead class="bg-dark text-white">
                <tr>
                    <th>#</th>
                    <th class="fw-normal fs-18">عنوان منو</th>
                    {{-- <th class="fw-normal fs-18">والد منو</th> --}}
                    <th class="fw-normal fs-18">محل منو</th>
                    <th class="fw-normal fs-18">وضعیت</th>
                    <th class="fw-normal fs-18">تاریخ ایجاد</th>
                    <th class="fw-normal fs-18 d-flex align-items-center gap-1 justify-content-center">عملیات<small
                            class="fs-12">(ویرایش - حذف)</small></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $key => $menu)
                    <tr class="align-middle">
                        <td>{{ $key + 1 }}
                        <td>{{ $menu->title }}</td>
                        <td>{{ $menu->position }}</td>
                        <td>
                            @if($menu->status == 0)
                                <span class="badge bg-danger fw-normal">غیرفعال</span>
                            @else
                            <span class="badge bg-success fw-normal">فعال</span>
                            @endif
                        </td>
                        <td>{{ verta($menu->created_at)->format('H:i:s') }} -
                            {{ verta($menu->created_at)->format('Y/m/d') }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                                <a href="{{ route('menus.edit', $menu->id) }}" title="ویرایش منو {{ $menu->title }}">
                                    <i class="icon-edit-1 fs-6"></i>
                                </a>
                                <form action="{{ route('menus.destroy', $menu->id) }}" method="Post" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger border-0 p-0 bg-transparent"
                                        title="حذف منو {{ $menu->title }}">
                                        <i class="icon-trash fs-6"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="oc-box">
                            @if ($menu->children && count($menu->children) > 0)
                            <i class="icon-plus-circled fs-6 text-success open-btn toggleSTL" data-Id="{{ $menu->id }}" role="button"></i>
                            <i class="icon-minus-circled fs-6 text-warning close-btn toggleSTL" data-Id="{{ $menu->id }}" role="button"></i>
                        @endif
                        </td>
                    </tr>
                    @if ($menu->children && count($menu->children) > 0)
                        <tr class="trSubTbl st-{{$menu->id}}">
                            <td colspan="6">
                                @include('admin.partials.MenuList', [
                                    'menus' => $menu->children,
                                    'level' => 1,
                                    'Id' => $menu->id
                                ])
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div>{{ $menus->links() }}</div>

    </div>
@endsection
