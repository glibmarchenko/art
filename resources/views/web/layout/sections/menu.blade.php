<section class="menu-section">

    <ul>

        @if(Auth::user()->role=='3' && isset(Auth::user()->gallery_profile))
            <li>
                <a href="{{route('gallery.show',Auth::user()->gallery_profile->id)}}">
                    {{ trans('account.Profile') }}
                </a>
            </li>
        @endif

        @if(!Auth::guest()&&Auth::user()->role==2)
            {{--
            <li>
                <a href="{{route('poster.create')}}">
                    Добавить принт
                </a>
            </li>
            <li>
                <a href={{route('picture.create')}}>
                    Добавить картину
                </a>
            </li>
            --}}
            <li>
                <a href="{{route('profile.page',['id'=>Auth::user()->id])}}">
                    {{ trans('account.Profile') }}
                </a>
            </li>
        @endif

        @if(Auth::user()->role!==1)
            <li>
                <a href="{{route('settings.items')}}">
                    {{ trans('account.Add artwork') }}
                </a>
            </li>
        @endif

        <li>
            <a href="{{route('user.news')}}">
                {{ trans('account.News') }}
            </a>
        </li>
        <li>
            <a href="{{route('user.liked')}}">
                {{ trans('account.Favorite') }}
            </a>
        </li>
        @if(Auth::user()->role!=='3')
            <li>
                <a href="{{route('order.active')}}">
                    {{ trans('account.Orders') }}
                </a>
            </li>
        @endif

        @if(Auth::user()->role!==1)
            <li>
                <a href="{{route('user.finance')}}">
                    {{ trans('account.Finances') }}
                </a>
            </li>
        @endif
        <li>
            <a href="{{route('user.subscriptions')}}">
                {{ trans('account.Subscriptions') }}
            </a>
        </li>
        <li>
            @if(Auth::user()->role=='1')
                <a href="{{route('settings.profile')}}">
                    {{ trans('account.Profile') }}
                </a>
            @else
                <a href="{{route('settings.items')}}">
                    {{ trans('account.Editing') }}
                </a>
            @endif
        </li>


        @if(Auth::user()->role=='3')
            <li>
                <a href="/settings/authors/add">
                    @lang('pages.add_author')
                </a>
            </li>
        @endif


        @if (!Auth::guest())
            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ trans('account.Log out') }}
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endif
    </ul>
</section>
