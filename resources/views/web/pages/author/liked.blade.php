@extends('web.layout.template')
<style>
    #main-content {
        margin-top:0 !important;
        height:auto !important;
    }
    .wrapper {
        padding-top:0 !important;
    }
    .main-content-heading {
        /*padding:0 !important;*/
    }
</style>

@section('content')

    <product-list-container :products="{{json_encode($products)}}" :hasfilter="false"></product-list-container>

@endsection

