@extends('web.layout.template')

        <!-- Include Filter Bar-->

@section('content')


    <product-list-container :products="{{$objects}}"  :product_type="3"></product-list-container>


@endsection