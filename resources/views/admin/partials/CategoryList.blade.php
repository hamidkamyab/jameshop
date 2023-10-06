@foreach ($categories as $key=>$category)
    <tr>
        <td>{{session('count') + 1}}{{session(['count' => session('count') + 1])}}</td>
        <td>{{str_repeat('+',$level)}} {{ $category->title }}</td>
        <td>{{ verta($category->created_at)->format('Y/m/d') }}</td>
        <td>
            <a href="#" class="text-danger">
                <i class="icon-cancel-1"></i>
            </a>
        </td>
    </tr>
    @if ($category->children)
        @include('admin.partials.CategoryList',['categories'=>$category->children,'level'=>$level+1])
    @endif
@endforeach
