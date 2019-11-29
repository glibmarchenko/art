@extends('web.layout.template')


@section('content')

    @include('web.pages.subscriptions.subscriptions-nav' , ['isGallery' => 1])

    <section id="main-content" class="galleries">
        
        <section class="main-content-heading top-sp-68">
            <h1>{{ trans('account.Subscriptions') }}</h1>
            <h2>{{ trans('dashboard.galleries_subscribed') }}</h2>
        </section>
        
        <div class="wrapper">
            <div class="row">
                @foreach($galleries as $gallery)
                    <div class="gallery-container">
                        <div class="gallery-avatar">
                            <a href="{{route('gallery.show',$gallery->id)}}">
                                @if($gallery->bg&&$gallery->bg!='')
                                    <div class="img-block"
                                         style="background-image: url('/web/images/galleries/{{$gallery->bg}}')"></div>
                                @else
                                    <div class="img-block"
                                         style="background-image: url('/web/images/ui/icon-bg-gallery.svg')"></div>
                                @endif
                            </a>
                        </div>
                        <div class="gallery-content">
                            <a href="{{route('gallery.show',$gallery->id)}}">
                                <div class="name">{{$gallery->name}}</div>
                            </a>
                            <div class="country">{{$gallery->address}}</div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>



@endsection