@extends('web.pages.settings.index')

@section('settings-content')
    <section class="settings-block">
        <!-- Settings menu -->
        <h1 class="title">
            {{ trans('dashboard.Work’s editing') }}
        </h1>

        <div class="btns-group group-centered">
            <a href="{{route('poster.create')}}"
               class="btn btn-fill-red btn-large btn-m-89">{{ trans('dashboard.Add print') }}</a>
            <a href="{{route('picture.create')}}"
               class="btn btn-fill-green btn-large btn-m-89">{{ trans('dashboard.Add painting') }}</a>
            <a href="{{route('object.create')}}"
               class="btn btn-fill-blue btn-large btn-m-89">{{ trans('dashboard.Add design') }}</a>
        </div>


        <div class="content">

            @if(count($items))

                <div class="wrapper">

                    <div class="isotope" id="columns">
                        @foreach($items as $item)
                            <div class="pic-content-block" id="product-{{$item->id}}">
                                <figure>
                                    <img class="pic-image" src="{{url(''.$item->image_preview_s.'')}}">
                                    <div class="bg-fill-gray">
                                        <a href="{{route('product.edit',$item->id)}}"
                                           class="btn btn-white medium edit-item btn-m-89">@lang('pages.edit')</a>
                                    </div>
                                </figure>
                                <div class="pic-description-container">
                                    <h2 class="pic-author"><a
                                                href="{{$item->author->profileURL()}}">{{$item->author->nickname}}</a>
                                    </h2>
                                    <h3 class="pic-name">{{$item->name}}</h3>
                                    <p class="pic-size">{{$item->width}}
                                        x {{$item->height}} {{$item->depth?'x '.$item->depth:''}} мм</p>
                                    <hr>
                                    <p class="pic-type {{'obj-'.$item->type}}">{{$item->type_name}}</p>
                                  @if($item->rejected)
                                    <a class="pic-price"><span class="small">@lang('pages.declined')</span></a>
                                  @else
                                    @if( $item->for_sale )
                                        <a class="pic-price">{{$item->price}} <span class="small">EUR</span></a>
                                    @elseif($item->sold)
                                        <a class="pic-price"><span class="small">@lang('pages.sold')</span></a>

                                        <a class="pic-price"><span class="small">@lang('pages.not_for_sale')</span></a>
                                    @endif
                                   @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif

        </div>
    </section>

@endsection
