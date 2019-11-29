@extends('web.layout.template')

@section('content')

    <section class="new-item-content">
   
            <h1 class="title">
                {{$title}}
            </h1>
        
        <div class="content">
            <div class="form-block">
                <create-product-form :product_type="{{ $type }}"
                                     :product_prop="{{ isset($product) ? $product : json_encode([]) }}"
                                     :is_gallery="{{Auth::user()->isGalleryUser()}}"></create-product-form>
            </div>
        </div>

    </section>

@endsection