@extends('web.layout.template')



@section('content')

    <!--Author page-->
    <section id="left-block-au">
        <div class="card-menu {{isset($author)?'author-details':''}}">
            <div class="author-avatar">
                @if(isset($user))
                    @if($user->avatar&&$user->avatar!='')
                        <img src="/web/images/avatars/{{$user->avatar}}"/>
                    @else
                        <img src="/web/images/ui/icon-default-avatar.svg"/>
                    @endif
                @else
                    <img src="/web/images/temp/avatar-test.png"/>
                @endif
            </div>
            @if(!isset($author))
                <author-subscribe :likes_amount="{{count($user->subscribedToMe)}}"
                                  :is_liked="{{(!Auth::guest()&&Auth::user()->subscribed($user->id))? 1: 0}}"
                                  :author_id="{{$user->id}}"
                >
                </author-subscribe>
            @endif

            <div class="description">
                <div class="wrap">
                    <h1>{{$user->nickname}}</h1>
                    <h2>{{isset($user)?$user->country:'Украина'}}</h2>


                @if(isset($user->gallery))

                    <div class="gallery-link">
                        <a href="{{route('gallery.show',$user->gallery->id)}}"
                           title="Галерея {{$user->gallery->name}}">{{$user->gallery->name}}</a>
                    </div>


                    @if($user->about != '')
                        <div class="block-text-details">
                            <div class="block-details-body">{!! nl2br($user->about) !!}</div>
                        </div>
                    @endif
                </div>
                @else
                    @if($user->description)
                        <p>
                            {!! nl2br($user->description) !!}
                        </p>
                    @else
                        <p>
                            {!! nl2br($user->about) !!}
                        </p>
                    @endif
                @endif
            </div>
        </div>
        <div class="mob-navigation">
            <div class="cols part-2 ">
                @if(!isset($author))
                    <author-subscribe :likes_amount="{{count($user->subscribedToMe)}}"
                                      :is_liked="{{(!Auth::guest()&&Auth::user()->subscribed($user->id))? 1: 0}}"
                                      :author_id="{{$user->id}}"
                    >
                    </author-subscribe>
                @endif
            </div>
            <div class="cols part-2 info">
                Инфо
            </div>
        </div>
        <div id="info-box">
            <h4>Инфо</h4>
            @if(isset($user->gallery))

                @if($user->about != '')
                    <div class="block-text-details">
                        <div class="block-details-body">{!! nl2br($user->about) !!}</div>
                    </div>
                @endif

            @else
                @if($user->description)
                    <p>
                        {!! nl2br($user->description) !!}
                    </p>
                @else
                    <p>
                        {!! nl2br($user->about) !!}
                    </p>
                @endif
            @endif
        </div>

    </section>

    <section id="right-block-au">
        <h2 class="title">Работы</h2>
        <product-list-container :nofilterlayout="true"
                                :products="{{json_encode($products)}}"
                                :author="{{$user}}"
                                :hasfilter="false"
        ></product-list-container>
    </section>
    <!--End Author page -->

@endsection
