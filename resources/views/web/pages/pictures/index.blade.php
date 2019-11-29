@extends('web.layout.template')

@section('content')

    <product-list-container :products="{{json_encode($pictures)}}" :product_type="2"></product-list-container>

@endsection
