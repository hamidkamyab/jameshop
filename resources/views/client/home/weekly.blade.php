        <!-- s-weekly-style -->
        <section class="s-weekly-style vh-100 my-5">
            <div class="weekly-style-container container vh-100 py-5 mt-5 position-relative">

                <div class="weekly-style-title d-flex justify-content-between align-items-center position-relative">
                    <h3 class="IRYekan fw-bold bg-white py-2">
                        اســتایلـــ هفتـه
                    </h3>

                    <button type="button" class="btn btn-outline-dark rounded-0 px-4 py-2">خرید همه</button>
                </div>

                <!-- weekly-style-box -->
                <div class="weekly-style-box h-100 d-flex align-items-center">

                    <div class="weekly-style-main-pic my-4 position-relative">
                        <img src="{{ $weekStyle->media[0]->file->path }}" alt="">
                    </div>

                    <!-- swiper-main -->
                    <div class="swiper-main w-100 d-flex align-items-center mx-4 gap-3 overflow-hidden position-relative"
                        data-m-right="0" data-s-count="1">

                        <div class="swiper-container d-flex align-items-center">

                            @foreach ($weekStyle->products as $item)
                                @include('client.partials.single-product',[
                                    $item,
                                ])
                            @endforeach


                        </div>

                        <button type="button"
                            class="swiper-btn swiper-btn-prev icon-right fs-3 px-2 py-3 position-absolute btn btn-light p-0 text-muted disabled"
                            disabled>
                        </button>
                        <button type="button"
                            class="swiper-btn swiper-btn-next icon-left fs-3 px-2 py-3 position-absolute btn btn-light p-0 text-muted">
                        </button>

                    </div>
                    <!-- End swiper-main -->

                </div>
                <!-- End weekly-style-box -->

                <div class="weekly-style-line border border-1 border-dark position-absolute" style="top:30px;"></div>
            </div>

        </section>
        <!-- End s-weekly-style -->




        <!-- h-product-items -->
        {{-- <div
        class="weekly-style-items h-product-items swiper-items d-flex flex-column gap-3 position-relative bg-white">
        <div class=" h-product-items-top position-relative">
            <div class="h-product-overly"></div>
            <span class="h-product-items-brand bg-white py-1 px-2 position-absolute top-0 fs-14">
                {{$item->brand->title}}
            </span>
            <div class="h-product-items-pic d-flex justify-content-center">
                @foreach ($item->media as $img)
                    @if($img->file->id == $item->first_pic)
                        <img src="{{$img->file->path}}" alt="">
                    @endif
                @endforeach

            </div>
            <div class="h-product-items-info position-absolute">
                <div class="h-product-items-info-top d-flex justify-content-between">
                    <span class="bg-white d-inline-block p-2 fs-14">سایز</span>
                    @if($item->discount_price)
                        <span class="h-product-items-off text-white d-inline-block p-2 fs-14">
                            {{$item->discount_price}}%
                        </span>
                    @endif
                </div>
                <div class="bg-white d-flex align-items-center gap-3 p-2 w-100 fs-14">
                    @foreach ($item->sizes as $size)
                        <span class="text-dark">{{$size->title}}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div
            class="h-product-items-bottom position-relative bg-white d-flex flex-column gap-2 pt-2">
            <a href="#" class="text-dark">{{$item->title}}</a>
            <div class="d-flex align-items-center justify-content-end">
                <span class="fs-5">{{number_format($item->price)}}</span>
                <i class="icon-toman-1 fs-3"></i>
            </div>
        </div>
    </div> --}}
    <!-- End h-product-items -->
