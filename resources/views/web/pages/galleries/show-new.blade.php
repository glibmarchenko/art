@extends('web.layout.template')


@section('content')
    <section id="gallery-show">
        <section class="banner"
                 style="background:url('/web/images/galleries/{{$gallery->bg}}') no-repeat center; background-size:cover"></section>

        <section class="title-bar">
            <div class="title">
                <h1>{{$gallery->name}}</h1>
                <h2>{{$gallery->country}} / {{$gallery->type_name}}</h2>
            </div>

            <div class="navigation">
                <gallery-subscribe
                        gallery_id="{{$gallery->user_id}}"
                        gallery="{{json_encode($gallery)}}"
                        is_subscribed="{{(!Auth::guest()&&Auth::user()->subscribed($gallery->user_id))? true: false}}"
                ></gallery-subscribe>
                <div class="btn btn-fill-black btn-large" id="gallery-about">О Галерее</div>
            </div>
        </section>
        <div class="mob-navigation">
            <div class="cols part-3 author">
                Авторы
            </div>
            <div class="cols part-3 ">
                <gallery-subscribe
                        gallery_id="{{$gallery->user_id}}"
                        gallery="{{json_encode($gallery)}}"
                        is_subscribed="{{(!Auth::guest()&&Auth::user()->subscribed($gallery->user_id))? true: false}}"
                ></gallery-subscribe>
            </div>
            <div class="cols part-3 info">
                    Инфо
            </div>
        </div>

        <section id="info-box">
            <div class="gallery-about-container">
                <div class="gallery-description">
                    <h2>{{$gallery->name}}</h2>
                    <h3>{{$gallery->country}}</h3>
                    <div class="underline"></div>

                    <div class="gallery-links">
                        <h4>Инфо</h4>
                        @if($gallery->country && $gallery->country != '')
                            <div class="gallery-link-box">
                                <a href="http://maps.google.com/?q={{$gallery->full_address}}"
                                   target="_blank">{{$gallery->full_address}}</a>
                            </div>
                        @endif

                        <div>
                            @if($gallery->phonesList() && count($gallery->phonesList()))
                                @foreach($gallery->phonesList() as $phone)
                                    <div class="gallery-link-box inline">
                                        <a href="tel:{{$phone}}">{{$phone}}</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="socials">
                            @if($gallery->facebook && $gallery->facebook != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->facebook}}" target="_blank">Facebook</a>
                                </div>
                            @endif

                            @if($gallery->instagram && $gallery->instagram != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->instagram}}" target="_blank">Instagram</a>
                                </div>
                            @endif

                            @if($gallery->vk && $gallery->vk != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->vk}}" target="_blank">Vkontakte</a>
                                </div>
                            @endif

                            @if($gallery->google && $gallery->google != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->google}}" target="_blank">Google +</a>
                                </div>
                            @endif
                        </div>

                        @if($gallery->web && $gallery->web != '')
                            <div class="gallery-link-box">
                                <a href="{{$gallery->web}}" target="_blank">{{$gallery->web}}</a>
                            </div>
                        @endif
                    </div>

                    <p>{{$gallery->description}}</p>
                </div>
            </div>
        </section>

        <section id="gallery-about-popup">
            <div class="gallery-about-container">
                <div class="gallery-avatar"
                     style="background:url('{{$gallery->owner->avatar_link}}') no-repeat center; background-size:cover;"></div>
                <div class="gallery-description">
                    <h2>{{$gallery->name}}</h2>
                    <h3>{{$gallery->country}}</h3>
                    <div class="underline"></div>

                    <div class="gallery-links">
                        @if($gallery->country && $gallery->country != '')
                            <div class="gallery-link-box">
                                <a href="http://maps.google.com/?q={{$gallery->full_address}}"
                                   target="_blank">{{$gallery->full_address}}</a>
                            </div>
                        @endif

                        <div>
                            @if($gallery->phonesList() && count($gallery->phonesList()))
                                @foreach($gallery->phonesList() as $phone)
                                    <div class="gallery-link-box inline">
                                        <a href="tel:{{$phone}}">{{$phone}}</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="socials">
                            @if($gallery->facebook && $gallery->facebook != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->facebook}}" target="_blank">Facebook</a>
                                </div>
                            @endif

                            @if($gallery->instagram && $gallery->instagram != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->instagram}}" target="_blank">Instagram</a>
                                </div>
                            @endif

                            @if($gallery->vk && $gallery->vk != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->vk}}" target="_blank">Vkontakte</a>
                                </div>
                            @endif

                            @if($gallery->google && $gallery->google != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->google}}" target="_blank">Google +</a>
                                </div>
                            @endif
                        </div>

                        @if($gallery->web && $gallery->web != '')
                            <div class="gallery-link-box">
                                <a href="{{$gallery->web}}" target="_blank">{{$gallery->web}}</a>
                            </div>
                        @endif
                    </div>

                    <p>{{$gallery->description}}</p>
                </div>
            </div>
        </section>

        <section class="authors-bar">
            <div class="header">
                <h2>Авторы</h2>
                <div class="navigation">
                    <div class="show-more-authors-button" id="show-all-authors">Показать всех</div>
                </div>
            </div>

            <div class="authors-small-list" id="authors-gallery-list">
                @foreach($gallery->authors as $author)
                    <a href="{{$author->profile_url}}">
                        <div class="author-single">
                            <div class="author-avatar"
                                 style="background:url('{{$author->avatar_link}}') no-repeat center; background-size:cover;"></div>
                            <div class="author-description">
                                <h2>{{$author->nickname}}</h2>
                                <h3>{{$author->country}}</h3>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="gallery-content compensated">
            <div class="gallery-items">
                @if(count($gallery->items))
                    <div class="my-products-list author-index-products">
                        <product-list-container :products="{{json_encode($gallery->items()->paginate(100))}}"
                                                :hasfilter="false"></product-list-container>
                    </div>
                @endif
            </div>
        </section>


        <section id="gallery-about-popup">
            <div class="gallery-about-container">
                <div class="gallery-avatar"
                     style="background:url('{{$gallery->owner->avatar_link}}') no-repeat center; background-size:cover;"></div>
                <div class="gallery-description">
                    <h2>{{$gallery->name}}</h2>
                    <h3>{{$gallery->country}}</h3>
                    <div class="underline"></div>

                    <div class="gallery-links">
                        @if($gallery->country && $gallery->country != '')
                            <div class="gallery-link-box">
                                <a href="http://maps.google.com/?q={{$gallery->full_address}}"
                                   target="_blank">{{$gallery->full_address}}</a>
                            </div>
                        @endif

                        <div>
                            @if($gallery->phonesList() && count($gallery->phonesList()))
                                @foreach($gallery->phonesList() as $phone)
                                    <div class="gallery-link-box inline">
                                        <a href="tel:{{$phone}}">{{$phone}}</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="socials">
                            @if($gallery->facebook && $gallery->facebook != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->facebook}}" target="_blank">Facebook</a>
                                </div>
                            @endif

                            @if($gallery->instagram && $gallery->instagram != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->instagram}}" target="_blank">Instagram</a>
                                </div>
                            @endif

                            @if($gallery->vk && $gallery->vk != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->vk}}" target="_blank">Vkontakte</a>
                                </div>
                            @endif

                            @if($gallery->google && $gallery->google != '')
                                <div class="gallery-link-box inline">
                                    <a href="{{$gallery->google}}" target="_blank">Google +</a>
                                </div>
                            @endif
                        </div>

                        @if($gallery->web && $gallery->web != '')
                            <div class="gallery-link-box">
                                <a href="{{$gallery->web}}" target="_blank">{{$gallery->web}}</a>
                            </div>
                        @endif
                    </div>

                    <p>{{$gallery->description}}</p>
                </div>
            </div>
        </section>


    </section>

@endsection
