@foreach ($categories as $category)
    <option value="{{ $category->id }}">{{str_repeat('-',$level)}}» {{ $category->title }}</option>
    @if($category->children)
        @include('admin.partials.CategoryCreate',['categories'=>$category->children,'level'=>$level+1])
    @endif
@endforeach
