@extends('client.layouts.master')
@section('head')
    <style>
        .head-text-white {
            color: var(--bs-white) !important;
        }
        .head-text-silver{
            color: var(--silver) !important;
        }
        .head-bg-white{
            background-color: var(--bs-white) !important;
        }
        .head-border-white{
            border-color: var(--bs-white) !important;
        }
        .header-logo-light img{
            filter:none !important;
        }
    </style>
@endsection
@section('content')
    @if (@$sliders && count($sliders) > 0)
        @include('client.home.slider', [$sliders])
    @endif

    @if ($amazings)
        @include('client.home.amazing', [$amazings])
    @endif

    @if ($weekStyle)
        @include('client.home.weekly', [$weekStyle]);
    @endif

    @if (@$catTabs && count($catTabs) > 0)
        @include('client.home.category-tab', [$catTabs])
    @endif

    @if (@$bestSell && count($bestSell) > 0)
        @include('client.partials.best-sell', [$bestSell]);
    @endif

    @if (@$popular && count($popular) > 0)
        @include('client.partials.popular', [$popular]);
    @endif

    @if (@$recents && count($recents) > 0)
        @include('client.partials.recent', [$recents]);
    @endif

    @if (@$designers && count($designers) > 0)
        @include('client.home.designers', [$designers]);
    @endif

    @if (@$visits && count($visits) > 0)
        @include('client.section.visit', [$visits]);
    @endif

    @if (@$blog && count($blog) > 0)
        @include('client.home.blog', [$blog]);
    @endif

    @if ($settings['Setting_GiftCat'] && $settings['Setting_GiftCat'] != null)
        @include('client.home.gift', [
            'Gift' => $settings['Gift'],
        ]);
    @endif

    {{--
@include('client.section.footer-menu');
@include('client.section.footer-rules'); --}}
@endsection
