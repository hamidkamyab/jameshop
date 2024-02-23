@extends('client.layouts.master')

@section('content')

@if (@$sliders && count($sliders) > 0)
    @include('client.section.slider',[
        $sliders
    ])
@endif

@if($amazings)
    @include('client.section.amazing',[
        $amazings
    ])
@endif

@if($weekStyle)
    @include('client.section.weekly',[
        $weekStyle
    ]);
@endif

@if (@$catTabs && count($catTabs) > 0)
    @include('client.section.category-tab',[
        $catTabs
    ])
@endif

@if (@$bestSell && count($bestSell) > 0)
    @include('client.section.best-sell',[
        $bestSell
    ]);
@endif

@if (@$popular && count($popular) > 0)
    @include('client.section.popular',[
        $popular
    ]);
@endif

@if (@$recents && count($recents) > 0)
    @include('client.section.recent',[
        $recents
    ]);
@endif

@if (@$designers && count($designers) > 0)
    @include('client.section.designers',[
        $designers
    ]);
@endif

@if (@$visits && count($visits) > 0)
    @include('client.section.visit',[
        $visits
    ]);
@endif

@if (@$blog && count($blog) > 0)
    @include('client.section.blog',[
        $blog
    ]);
@endif

@if($settings['Setting_GiftCat'] && $settings['Setting_GiftCat'] != null)
    @include('client.section.gift',[
        'Gift' => $settings['Gift']
    ]);
@endif

{{--
@include('client.section.footer-menu');
@include('client.section.footer-rules'); --}}


@endsection
