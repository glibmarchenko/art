@extends('web.layout.template',['title' => $gallery])


@section('content')

    <div class="gallery-page">
        <div class="main-gallery-bg">
            @if($gallerz->bg!='')
                <img src="/web/images/galleries/{{$gallery->bg}}"/>
            @else
                <img src="/web/images/ui/icon-bg-gallery.svg"/>
            @endif
        </div>

        <div class="gallery-title-row">
            <div class="gallery-cell">
                <div class="gallery-name">
                    {{$gallery->nameg}}
                </div>
                <div class="gallery-address">
                    {{$gallery->address}}
                </div>
            </div>

            @if(Auth::guest()||(isset($gallery)&&Auth::user()->id!=$gallery->user_id))
                <gallery-subscribe
                        gallery_id="{{$gallery->user_id}}"
                        gallery="{{json_encode($gallery)}}"
                        is_subscribed="{{(!Auth::guest()&&Auth::user()->subscribed($gallery->user_id))? true: false}}"
                ></gallery-subscribe>
            @endif

            <div class="btn btn-default ">О галерее</div>
        </div>

        <div class="gallery-detail-blocks">
            <div class="gallery-left-block">
                <div class="gallery-links">
                    @if($gallery->country && $gallery->country != '')
                        <div class="gallery-link-box">
                            <a href="http://maps.google.com/?q={{$gallery->full_address}}"
                               target="_blank">{{$gallery->full_address}}</a>
                        </div>
                    @endif

                    @if($gallery->phonesList() && count($gallery->phonesList()))
                        @foreach($gallery->phonesList() as $phone)
                            <div class="gallery-link-box inline">
                                <a href="tel:{{$phone}}">{{$phone}}</a>
                            </div>
                        @endforeach
                    @endif

                    @if($gallery->facebook && $gallery->facebook != '')
                        <div class="gallery-link-box">
                            <a href="{{$gallery->facebook}}" target="_blank">Facebook</a>
                        </div>
                    @endif

                    @if($gallery->instagram && $gallery->instagram != '')
                        <div class="gallery-link-box">
                            <a href="{{$gallery->instagram}}" target="_blank">Instagram</a>
                        </div>
                    @endif

                    @if($gallery->vk && $gallery->vk != '')
                        <div class="gallery-link-box">
                            <a href="{{$gallery->vk}}" target="_blank">Vkontakte</a>
                        </div>
                    @endif

                    @if($gallery->google && $gallery->google != '')
                        <div class="gallery-link-box">
                            <a href="{{$gallery->google}}" target="_blank">Google +</a>
                        </div>
                    @endif

                    @if($gallery->web && $gallery->web != '')
                        <div class="gallery-link-box">
                            <a href="{{$gallery->web}}" target="_blank">{{$gallery->web}}</a>
                        </div>
                    @endif
                </div>

                <div class="gallery-description-block">
                    {!! nl2br($gallery->description) !!}
                </div>

                @if(isset($gallery->authors) && count($gallery->authors))
                    <div class="gallery-artists">
                        <div class="gallery-artists-title">Художники</div>
                        <div class="gallery-artists-list">

                            @foreach($gallery->authors as $author)
                                <div class="author-row">
                                    <figure>
                                        @if($author->avatar&&$author->avatar!='')
                                            <img class="" src="/web/images/avatars/{{$author->avatar}}"/>
                                        @else
                                            <img class="" src="/web/images/ui/icon-default-avatar.svg"/>
                                        @endif
                                    </figure>
                                    <div class="about-user">
                                        <h5>
                                            <a href="{{$author->profileURL()}}">{{$author->name}} {{$author->surname}}</a>
                                        </h5>
                                        <p>{{$author->country}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="gallery-items">
                @if(count($gallery->items))
                    <div class="my-products-list author-index-products">
                        <product-list-container :nofilterlayout="true" :products="{{json_encode($gallery->items)}}"
                                                :hasfilter="false"></product-list-container>
                    </div>
                @endif
            </div>
        </div>


    </div>

@endsection