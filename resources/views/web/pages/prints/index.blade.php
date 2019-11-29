@extends('web.layout.template')



@section('content')
       <product-list-container :products="{{$posters}}" :product_type="1"></product-list-container>
@endsection
