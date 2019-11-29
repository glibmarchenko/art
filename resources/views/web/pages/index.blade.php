@extends('web.layout.template')

@section('content')

    <section id="homepage">

        <section id="header">
            <div class="logo"></div>
            <div class="slogan">
                <p>
                    {{ trans('homepage.Platform for buying and selling') }}<br>
                    {{ trans('homepage.of modern art') }}.
                    <span class="c-red">{{ trans('homepage.Beta version') }} 1.3</span>
                </p>
            </div>
            <div class="button-right">
                <a href="{{URL::to('poster')}}"
                   class="btn btn-outline-black btn-d-55 btn-m-89">{{ trans('homepage.Review the artworks') }}</a>
            </div>
        </section>


        <section id="banner"
                 style="background:url('/web/images/landing/fon_homepage.jpg') no-repeat center; background-size:cover">
            <div class="content">
                <h1>{{ trans('homepage.BUY ART OF') }}
                    <span class="c-green">{{ trans('homepage.LIVING') }}</span>
                    {{ trans('homepage.ARTISTS') }}</h1>
                <h2>{{ trans('homepage.THE DEAD DON\'T NEED THE MONEY') }}</h2>
                <a class="btn btn-fill-red btn-d-55 btn-m-89 terms-popup">{{ trans('homepage.How it works') }}</a>
            </div>
        </section>


        <section class="book">
            <div class="page">
                <div class="content">
                    <h2>{{ trans('homepage.Create. Post. Sell.') }}</h2>
                    <p>{{ trans('homepage.create_personal_profile') }}</p>
                    <div class="buttons">
                        @if(!Auth::check())
                            <a data-toggle="modal" data-target="#login-modal"
                               class="btn btn-fill-green btn-d-55 btn-m-89">
                                {{ trans('homepage.Create profile') }}</a>
                        @else
                            <a href="{{URL::to('settings/items')}}" class="btn btn-fill-green btn-d-55 btn-m-89">
                                {{ trans('account.Add artwork') }}</a>
                        @endif

                        {{--<a class="btn btn-no-fill btn-d-55 btn-m-89 terms-popup">{{ trans('homepage.More info') }}</a>--}}
                    </div>
                </div>
            </div>
            <div class="page img"
                 style="background:url('/web/images/landing/fon-2.jpg') no-repeat center; background-size:cover">
            </div>
        </section>


        <section class="book">
            <div class="page img d-n"
                 style="background:url('/web/images/landing/fon3.jpg') no-repeat center; background-size:cover">
            </div>

            <div class="page">
                <div class="content">
                    <h2>{{ trans('homepage.Review. Be inspired. Purchase.') }}</h2>
                    <p>{{ trans('homepage.subscribe_artists') }}</p>
                    <div class="buttons">
                        @if(!Auth::check())
                            <a data-toggle="modal" data-target="#login-modal"
                               class="btn btn-fill-red btn-d-55 btn-m-89">
                                {{ trans('homepage.Create profile') }}</a>
                        @else
                            <a href="{{URL::to('poster')}}"
                               class="btn btn-fill-green btn-d-55 btn-m-89">{{ trans('homepage.Review the artworks') }}</a>
                        @endif
                        {{--<a class="btn btn-no-fill btn-d-55 btn-m-89 terms-popup">{{ trans('homepage.More info') }}</a>--}}
                    </div>
                </div>
            </div>

        </section>

        <section class="book" data-last="last">
            <div class="page img"
                 style="background:url('/web/images/landing/fon4.jpg') no-repeat center; background-size:cover">
            </div>
            <div class="page">
                <div class="content">
                    <h2>{{ trans('homepage.Worldwide delivery') }}</h2>
                    <p>{{ trans('homepage.deliver_art') }} <span>( Beta - {{ trans('homepage.Ukraine only') }} )</span>
                    </p>
                    <div class="buttons">
                        <a href="{{URL::to('poster')}}"
                           class="btn btn-fill-blue btn-d-55 btn-m-89">{{ trans('homepage.Review the artworks') }}</a>
                    </div>
                </div>
            </div>

        </section>


        <section id="main-content" class="galleries">

            <section class="main-content-heading top-sp-68">
                <h1><span class="d-b">Топ</span> {{ trans('homepage.Galleries') }}</h1>
                <h2>{{ trans('homepage.List of galleries') }}</h2>
                @if(!Auth::check())
                    <a data-toggle="modal" data-target="#login-modal"
                       class="btn btn-fill-green btn-d-55 btn-m-89 add-gallery">
                    {{ trans('homepage.Add') }}
                        <span class="d-n">{{ trans('homepage.gallery') }}</span></a>
                @else
                    <a href="{{URL::to('gallery')}}"
                       class="btn btn-fill-green btn-d-55 btn-m-89 add-gallery">Галереи
                    </a>
                @endif
            </section>

            <div class="wrapper">

                <div class="row">
                    @foreach(\App\Models\Gallery::whereTop(true)->get() as $gallery)
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

        <section id="product-types">
            <div class="row">
                <a href="{{URL::to('poster')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-5.jpg');">
                        {{ trans('homepage.Prints') }}
                    </div>
                </a>
                <a href="{{URL::to('picture')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-6.jpg');">
                        {{ trans('homepage.Paintings') }}
                    </div>
                </a>
                <a href="{{URL::to('object')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-7.jpg');">
                        {{ trans('homepage.Designs') }}
                    </div>
                </a>
            </div>
        </section>


        <section id="subscriptions">

            <section class="main-content-heading">
                <h1><span class="d-b">Топ</span> {{ trans('homepage.Artists') }}</h1>
                <h2>{{ trans('homepage.best_artists') }}</h2>
                @if(!Auth::check())
                    <a data-toggle="modal" data-target="#login-modal"
                       class="btn btn-fill-green btn-d-55 btn-m-89 add-gallery">
                    {{ trans('homepage.Add') }}
                        <span class="d-n">{{ trans('homepage.artist') }}</span> </a>
                @else
                    <a href="{{URL::to('authors')}}"
                       class="btn btn-fill-green btn-d-55 btn-m-89 add-gallery">Авторы
                    </a>
                @endif
            </section>

            <div class="wrapper" style="padding-top:0;">
                @foreach(\App\Models\Users\User::whereTop(1)->whereRole(2)->limit(8)->get() as $subscription)
                    <div class="author-container">
                        <div class="author-avatar">
                            <a href="{{route('profile.page',$subscription->id)}}">
                                <div class="img-block"
                                     style="background-image: url('/web/images/avatars/{{$subscription->avatar}}')"></div>
                            </a>
                        </div>
                        <div class="author-content">
                            <a href="{{route('profile.page',$subscription->id)}}">
                                <div class="name">{{$subscription->nickname}}</div>
                            </a>
                            <div class="country">{{$subscription->country}}</div>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>

        <section id="product-types">
            <div class="row">
                <a href="{{URL::to('poster/category/16')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-8.jpg');">
                        3D RENDERING
                    </div>
                </a>
                <a href="{{URL::to('poster/category/7')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-9.jpg');">
                        PORTRAITURE
                    </div>
                </a>
                <a href="{{URL::to('poster/category/3')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-10.jpg');">
                        FIGURATIVE
                    </div>
                </a>
                <a href="{{URL::to('poster/category/12')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-11.jpg');">
                        SURREALISM
                    </div>
                </a>
                <a href="{{URL::to('poster/category/13')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-12.jpg');">
                        COLLAGE
                    </div>
                </a>
                <a href="{{URL::to('poster/category/10')}}">
                    <div class="type" style="background-image:url('/web/images/landing/fon-13.jpg');">
                        СHARACTER
                    </div>
                </a>
            </div>
        </section>

        <section id="landing-products">
            <section class="main-content-heading top-sp-68">
                <h1><span class="d-b">Топ</span> {{ trans('homepage.Artworks') }}</h1>
                <h2>{{ trans('homepage.Selected paintings, prints, items') }}</h2>
                @if(!Auth::check())
                    <a data-toggle="modal" data-target="#login-modal"
                       class="btn btn-fill-green btn-d-55 btn-m-89 add-gallery">
                    {{ trans('homepage.Add') }}
                        <span class="d-n">{{ trans('homepage.artwork') }}</span> </a>
                @else
                    <a href="{{URL::to('poster')}}"
                       class="btn btn-fill-green btn-d-55 btn-m-89 add-gallery">Работы
                    </a>
                @endif
            </section>
            @if(isset($products))
            <product-list-container :products="{{ $products }}"
                                    :hasFilter="false"
                                    :product_type="1"></product-list-container>
            @endif
            <div class="center-block">
                <a href="{{URL::to('poster')}}"
                   class="btn btn-fill-green btn-d-55 btn-m-89 all-prints">{{ trans('homepage.All artworks') }}</a>
            </div>
        </section>


        <section id="header" class="header-down">
            <div class="logo"></div>
            <div class="slogan">
                <p>
                    {{ trans('homepage.Did you like ArtDiller?') }}
                    <br>
                    {{ trans('homepage.Tell your friends about us.') }}
                </p>
            </div>
            <div class="button-right">
                <a href="#" class="btn btn-fill-red btn-d-55 btn-m-89 google-button">G+</a>
                <a href="#" class="btn btn-fill-blue btn-d-55 btn-m-89 facebook-button">F</a>
            </div>
        </section>


        <section id="footer">
            @include('web.layout.sections.footer')
        </section>


    </section>
@endsection
