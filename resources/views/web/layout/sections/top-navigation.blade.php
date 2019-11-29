@if(Route::current()->getName() !== 'register.main' && Route::current()->getName() !== 'register.step1')
<section id="nav-section" class="nav-section">
    <nav class="nav ">
        <div class="left-mob-menu">
            <div class="menu-trigger second">
                <span class="line line-1"></span>
                <span class="line line-2"></span>
                <span class="line line-3"></span>
            </div>
        </div>
        <div class="logo">
            <a href="{{route('home')}}">
                <img class="main" src="/web/images/ui/artdiller-logo.svg">
                <img class="main-hover" src="/web/images/ui/artdiller-logo-hover.svg">
            </a>
        </div>
        <language-block></language-block>

        <ul class="nav-bar list-inline left-menu ">
            <li><a class="{{\Request::is('poster')?'active':''}}"
                   href="{{route('poster.index')}}">{{ trans('homepage.Prints') }}</a></li>
            <li><a class="{{\Request::is('picture')?'active':''}}"
                   href="{{route('picture.index')}}">{{ trans('homepage.Paintings') }}</a></li>
            <li><a class="{{\Request::is('object')?'active':''}}"
                   href="{{route('object.index')}}">{{ trans('homepage.Designs') }}</a></li>
            <li><a class="{{\Request::is('gallery*')?'active':''}}"
                   href="{{route('gallery.index')}}">{{ trans('homepage.Galleries') }}</a></li>
            <li><a class="{{\Request::is('author*')?'active':''}}"
                   href="{{route('author.index')}}">{{ trans('homepage.Artists') }}</a></li>
            @if(Auth::check())
                @if(Auth::user()->isAdmin)
                    <li><a href="{{route('admin.home')}}">{{ trans('account.Dashboard') }}</a>
                    </li>
                @endif
            @endif
        </ul>
        <div class="mobile-logo">
            <a href="{{route('home')}}">
                <img class="main" src="/web/images/ui/logo_art_mob.svg">
            </a>
        </div>
        <div class="purchases pull-right">

            @if (!Auth::guest())
                <notifications></notifications>

                <purchase-cart></purchase-cart>

                <a>
                    <div class="menu-sandwich">
                        @if (Auth::user()->avatar&&file_exists(public_path('/web/images/avatars/'.Auth::user()->avatar)))
                            <div class="profile-avatar-icon">
                                <img src="/web/images/avatars/{{Auth::user()->avatar}}"/>
                            </div>
                        @endif

                        <a href="#" class="my-cabinet btn-add-item-dropdown">{{ trans('account.Account') }}</a>

                        <div class="menu-trigger second">
                            <span class="line line-1"></span>
                            <span class="line line-2"></span>
                            <span class="line line-3"></span>
                        </div>
                        <div class="right-mob-menu">
                            ...
                        </div>
                    </div>
                </a>


            @endif
        </div>


        <ul class="nav-bar pull-right list-inline pos-relative">
            <!--<li><a href="#">Как это работает</a></li>-->
            <li>
                @if (Auth::guest())
                    <a data-toggle="modal" data-target="#login-modal"
                       class="btn btn-fill btn-fill-lowblack-top add-product-btn">{{ trans('account.Add artwork') }}</a>
                @elseif(Auth::user()->role==2||Auth::user()->role==3)
                    {{--<a href="#" class="add-product-logged btn-add-item-dropdown" data-type="main">Добавить работу</a>--}}
                    {{--<ul class="submenu" data-type="main">--}}
                    {{--<li>--}}
                    {{--<a href="{{route('poster.create')}}">Принт</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="{{route('picture.create')}}">Картину</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="{{route('object.create')}}" class="">Предмет</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                @endif
            </li>
            @if (Auth::guest())
                <li>
                    <a data-toggle="modal" data-target="#login-modal">{{ trans('account.Log in') }}</a>
                </li>
            @endif

        </ul>
    </nav>
</section>
@endif

@if (!Auth::guest())
    @include('web.layout.sections.menu')
@endif
