@if (isset($selectedId))
    @foreach ($menus as $menu)
        <option value="{{ $menu->id }}" class="child" @if ($selectedId == $menu->id) selected @endif
            title="{{ $toltipTitle }} -> {{ $menu->title }}" >{{ str_repeat('-', $level) }}» {{ $menu->title }}
        </option>
        @if ($menu->children)
            @include('admin.partials.MenuChildren', [
                'menus' => $menu->children,
                'level' => $level + 1,
            ])
        @endif
    @endforeach
@else
    @foreach ($menus as $menu)
        <option value="{{ $menu->id }}" class="child" title="{{ $toltipTitle }} -> {{ $menu->title }}">
            {{ str_repeat('-', $level) }}» {{ $menu->title }}</option>
        @if ($menu->children)
            @include('admin.partials.MenuChildren', [
                'menus' => $menu->children,
                'level' => $level + 1,
            ])
        @endif
    @endforeach

@endif
