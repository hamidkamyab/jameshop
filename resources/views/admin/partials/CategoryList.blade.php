@foreach ($categories as $key => $category)
    <tr>
        <td>{{ session('count') + 1 }}{{ session(['count' => session('count') + 1]) }}</td>
        <td>{{ str_repeat('+', $level) }} {{ $category->title }}</td>
        <td>{{ verta($category->created_at)->format('Y/m/d') }}</td>
        <td>
            <div class="d-flex align-items-center justify-content-center gap-2 pt-1">
                <a href="{{ route('categories.edit', $category->id) }}" title="ویرایش دسته {{ $category->title }}">
                    <i class="icon-edit-1 fs-6"></i>
                </a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="Post" class="m-0">
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
            'level' => $level + 1,
        ])
    @endif
@endforeach
