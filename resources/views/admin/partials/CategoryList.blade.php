@foreach ($categories as $key=>$category)
    <tr>
        <td>{{session('count') + 1}}{{session(['count' => session('count') + 1])}}</td>
        <td>{{str_repeat('+',$level)}} {{ $category->title }}</td>
        <td>{{ verta($category->created_at)->format('Y/m/d') }}</td>
        <td>
            <form action="{{route('categories.destroy',$category->id)}}" method="Post"  class="m-0 mt-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-danger border-0 p-0 bg-transparent">
                    <i class="icon-cancel-1 fs-5"></i>
                </button>
            </form>
        </td>
    </tr>
    @if ($category->children)
        @include('admin.partials.CategoryList',['categories'=>$category->children,'level'=>$level+1])
    @endif
@endforeach
