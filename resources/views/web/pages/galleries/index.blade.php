@extends('web.layout.template')



@section('content')

    <section id="main-content" class="galleries">

        <section class="main-content-heading">
            <h1>{{ trans('homepage.Galleries') }}</h1>
            <h2>{{ trans('homepage.List of galleries') }}</h2>
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