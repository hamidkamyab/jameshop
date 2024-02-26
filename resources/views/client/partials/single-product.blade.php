<div class="h-product-items h-product-items-ds swiper-items bg-transparent">
    {{-- [amazing-items] --}}
    <div class="d-flex flex-column gap-3 position-relative bg-white p-2">

        {{-- amazing-items-offer-box --}}
        <div class="amazing-items-offer-box hidden">
            <div class="d-flex align-items-center justify-content-between">
                <img src="{{ asset('imgs/client/amazing-offer.svg') }}" alt="" srcset="">
                <span class="text-pink d-flex flex-row-reverse">
                    <span class="hours">00</span>:
                    <span class="minutes">00</span>:
                    <span class="seconds">00</span>
                </span>
            </div>
        </div>
        {{-- amazing-items-offer-box --}}

        <div class=" h-product-items-top position-relative">
            <div class="h-product-overly"></div>
            <span class="h-product-items-brand bg-white py-1 px-2 position-absolute top-0 fs-14">
                {{ $item->brand->title }}
            </span>
            <div class="h-product-items-pic d-flex justify-content-center">
                @foreach ($item->media as $img)
                    @if ($img->file->id == $item->first_pic)
                        <img src="{{ $img->file->path }}" alt="">
                    @endif
                @endforeach
            </div>
            <div class="h-product-items-info position-absolute">
                <div class="h-product-items-info-top d-flex justify-content-between">
                    <span class="bg-white d-inline-block p-2 fs-14">سایز</span>
                    @if ($item->discount_price)
                        <span class="h-product-items-off text-white d-inline-block p-2 fs-14">
                            {{ $item->discount_price }}%
                        </span>
                    @endif
                </div>
                <div class="bg-white d-flex align-items-center gap-3 p-2 w-100 fs-14">
                    @foreach ($item->sizes as $size)
                        <span class="text-dark">{{ $size->title }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div
            class="h-product-items-bottom position-relative bg-white d-flex flex-column gap-2 pt-2">
            <a href="#" class="text-dark">{{ $item->title }}</a>
            <div class="d-flex align-items-center justify-content-end">
                <span class="fs-5">{{ number_format($item->price) }}</span>
                <i class="icon-toman-1 fs-3"></i>
            </div>
        </div>
    </div>
</div>

@if(@$amz)
<script>
    var targetDate = new Date('{{ $amazings->end }}')
</script>
@endif
