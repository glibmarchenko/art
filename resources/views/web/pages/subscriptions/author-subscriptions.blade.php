@extends('web.layout.template')


@section('content')

    @include('web.pages.subscriptions.subscriptions-nav')
    
    <section id="subscriptions">

        <section class="main-content-heading top-sp-68">
            <h1>{{ trans('account.Subscriptions') }}</h1>
            <h2>{{ trans('dashboard.artists_subscribed') }}</h2>
        </section>
        
        <div class="wrapper" style="padding-top:0;">
            @foreach($subscriptions as $subscription)
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

@endsection