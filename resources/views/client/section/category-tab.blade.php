<!-- s-category-tab -->
<section class="s-category-tab vh-100 my-5">
    <div class="category-tab-container container">
        <nav class="category-tab-nav">
            <ul class="nav nav-tabs d-flex justify-content-center gap-2 align-items-center pt-3" role="tablist">
                @foreach ($catTabs as $key=>$item)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($key == 0) active @endif fs-5" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#tab-cate-{{$key}}" type="button" role="tab"
                        aria-selected="true">
                            @if($item->title != null) {{$item->title}} @else {{$item->category->title}} @endif
                        </button>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="category-tab-content tab-content mt-4">
            @foreach ($catTabs as $key=>$item)
                <div class="tab-pane fade show @if($key == 0) active @endif" id="tab-cate-{{$key}}" role="tabpanel" tabindex="{{$key}}">
                    <div class="col-12 d-flex align-items-center flex-wrap">
                        @foreach ($item->children as $key=>$child)
                        <div class="category-tab-item p-2 ">
                            <a href="#" class="category-tab-link position-relative text-black-50 d-block w-100 h-100 overflow-hidden">
                                <img src="{{$child->media[0]->file->path}}" alt="" class="category-tab-img">
                                <span class="position-absolute bottom-0 start-0 px-3 py-2 bg-white fs-18">
                                    @if($child->title != null)
                                        {{$child->title}}
                                    @else
                                        {{$child->category->title}}
                                    @endif
                                </span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
<!-- End s-category-tab -->
