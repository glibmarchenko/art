@extends('web.layout.template')

@section('content')

    <product-list-container :products="[{{$product}}]" :product_type="1" :single_product="{{$product}}"></product-list-container>
    
@endsection
