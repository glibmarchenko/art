@extends('web.layout.template')
<style>
    #main-content {
        margin-top:0 !important;
        height:auto !important;
    }
    .wrapper {
        padding-top:0 !important;
    }
</style>

@section('content')

    <section id="subscriptions">
        <h1>{{ trans('account.News') }}</h1>
        <h2>{{ trans('dashboard.works_subscribed') }}</h2>
        <product-list-container :products="{{json_encode($products)}}" :hasfilter="false"></product-list-container>
    </section>

@endsection
