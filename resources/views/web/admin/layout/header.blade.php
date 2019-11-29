<div class="brand pull-left">
    <a href="{{URL::to('/')}}">
    <img src="/web/images/ui/artdiller-main-logo.svg" alt="" width="100" class="logo">
    <img src="/web/images/ui/artdiller-main-logo.svg" alt="" width="28" class="logo-sm">
    </a>
    <a href="javascript:;" role="button" class="hamburger-menu menu-hide-open"><span></span></a>
</div>

<div class="header-title">
    <h4 class="mt-0 mb-5">@yield('page-title')</h4>
    <p class="text-muted mb-0">@yield('page-subtitle')</p>
</div>

<ul class="notification-bar list-inline pull-right">
    <li class="dropdown hidden-xs"><a id="dropdownMenu2" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle header-icon lh-1 pt-15 pb-15">
            <div class="media mt-0">
                <div class="media-left avatar"><img src="{{Auth::user()->avatar_link}}" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                <div class="media-right media-middle pl-0">
                    <p class="fs-12 text-base mb-0">{{Auth::user()->full_name}}</p>
                </div>
            </div></a>
        {{--<ul aria-labelledby="dropdownMenu2" class="dropdown-menu fs-12 animated fadeInDown">--}}
            {{--<li><a href="profile.html"><i class="ti-user mr-5"></i> My Profile</a></li>--}}
            {{--<li><a href="profile.html"><i class="ti-settings mr-5"></i> Account Settings</a></li>--}}
            {{--<li><a href="login-v2.html"><i class="ti-power-off mr-5"></i> Logout</a></li>--}}
        {{--</ul>--}}
    </li>
</ul>
