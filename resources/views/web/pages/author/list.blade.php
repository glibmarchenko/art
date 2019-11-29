@extends('web.layout.template')


@section('content')

    <section id="subscriptions">

        <section class="main-content-heading">
            <h1>{{ trans('homepage.Artists') }}</h1>
            <h2>{{ trans('pages.talented') }}</h2>
        </section>

        <div class="wrapper" style="padding-top:0;">
            @foreach($authors as $author)
                <div class="author-container">
                    <div class="author-avatar">
                        <a href="{{route('profile.page',$author->id)}}">
                            <div class="img-block"
                                 style="background-image: url('/web/images/avatars/{{$author->avatar}}')"></div>
                        </a>
                    </div>
                    <div class="author-content">
                        <a href="{{route('profile.page',$author->id)}}">
                            <div class="name">{{$author->nickname}}</div>
                        </a>
                        <div class="country">{{$author->country}}</div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

@endsection
