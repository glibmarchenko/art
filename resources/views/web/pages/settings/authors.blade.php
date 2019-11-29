@extends('web.pages.settings.index')

@section('settings-content')
    <section class="settings-block">
        <!-- Settings menu -->
        <h1 class="title" style="margin-top:0; margin-left:0;">
            @lang('pages.edit_authors')
        </h1>
        <div class="content">

            <div class="btns-group group-centered">
                <a href="{{route('settings.authors.add')}}" class="btn btn-fill-green btn-55 btn-m-89">@lang('pages.add_author')</a>
            </div>


            @if(count($authors))
                <div class="info-block-authors">
                    <div class="authors-list" style="background:none !important;">
                        @foreach($authors as $author)
                            <div class="author-item" id="author-{{$author->id}}">
                                <div class="author-avatar">

                                    <figure>
                                        <div class="img-block" style="background-image: url('/web/images/avatars/{{$author->avatar}}')"></div>
                                        <div class="bg-fill-gray">
                                            <a href="{{route('settings.authors.edit',$author->id)}}"
                                               class="btn btn-white medium edit-item btn-m-89">@lang('pages.edit')</a>
                                        </div>

                                    </figure>
                                </div>
                                <div class="author-content">
                                    <div class="name"><a href="{{$author->profileURL()}}">{{$author->full_name}}</a>
                                    </div>
                                    <div class="country">{{$author->country}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
