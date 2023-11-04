@if (isset($selectedId))
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" @if ($selectedId == $category->id) selected @endif
            title="{{ $toltipTitle }} -> {{ $category->title }}">{{ str_repeat('-', $level) }}» {{ $category->title }}
        </option>
        @if ($category->children)
            @include('admin.partials.CategoryChildren', [
                'categories' => $category->children,
                'level' => $level + 1,
            ])
        @endif
    @endforeach
@else
    @if (@$disableParent)
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" title="{{ $toltipTitle }} -> {{ $category->title }}" @if(count($category->children) > 0) disabled @endif >
                {{ str_repeat('-', $level) }}» {{ $category->title }}</option>
            @if ($category->children)
                @include('admin.partials.CategoryChildren', [
                    'categories' => $category->children,
                    'level' => $level + 1,
                ])
            @endif
        @endforeach
    @else
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" title="{{ $toltipTitle }} -> {{ $category->title }}">
                {{ str_repeat('-', $level) }}» {{ $category->title }}</option>
            @if ($category->children)
                @include('admin.partials.CategoryChildren', [
                    'categories' => $category->children,
                    'level' => $level + 1,
                ])
            @endif
        @endforeach
    @endif

@endif
