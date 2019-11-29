<section class="settings-tabs">
    <ul>

        @if(Auth::user()->role=='1')
            <li class="{{\Request::is('settings/profile')?'active':''}}">
                <a href="{{route('settings.profile')}}">{{ trans('dashboard.About me') }}</a>
            </li>
            <li class="{{\Request::is('settings/address')?'active':''}}">
                <a href="{{route('settings.address')}}">Адрес доставки</a>
            </li>
            <li class="{{\Request::is('settings/auth')?'active':''}}">
                <a href="{{route('settings.auth')}}">{{ trans('dashboard.Entry') }}</a>
            </li>
        @endif

        @if(Auth::user()->role=='2')
            <li class="{{\Request::is('settings/profile')?'active':''}}">
                <a href="{{route('settings.profile')}}">{{ trans('dashboard.About me') }}</a>
            </li>
            <li class="{{\Request::is('settings/address')?'active':''}}">
                <a href="{{route('settings.address')}}">{{ trans('dashboard.Address') }}</a>
            </li>
            <li class="{{\Request::is('settings/auth')?'active':''}}">
                <a href="{{route('settings.auth')}}">{{ trans('dashboard.Entry') }}</a>
            </li>
            {{--<li class="{{\Request::is('settings/finance')?'active':''}}">--}}
                {{--<a href="{{route('settings.finance')}}">Финансы</a>--}}
            {{--</li>--}}
            <li class="{{\Request::is('settings/items')?'active':''}}">
                <a href="{{route('settings.items')}}">{{ trans('homepage.Artworks') }}</a>
            </li>
        @endif

        @if(Auth::user()->role=='3')
            <li class="{{\Request::is('settings/gallery')?'active':''}}">
                <a href="{{route('settings.gallery')}}">{{ trans('dashboard.Gallery') }}</a>
            </li>
            <li class="{{\Request::is('settings/auth')?'active':''}}">
                <a href="{{route('settings.auth')}}">{{ trans('dashboard.Entry') }}</a>
            </li>
            {{--<li class="{{\Request::is('settings/finance')?'active':''}}">--}}
                {{--<a href="{{route('settings.finance')}}">Финансы</a>--}}
            {{--</li>--}}
            <li class="{{\Request::is('settings/authors*')?'active':''}}">
                <a href="{{route('settings.authors')}}">{{ trans('homepage.Artists') }}</a>
            </li>
            <li class="{{\Request::is('settings/items')?'active':''}}">
                <a href="{{route('settings.items')}}">{{ trans('homepage.Artworks') }}</a>
            </li>
        @endif

    </ul>
</section>