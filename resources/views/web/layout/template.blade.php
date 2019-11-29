<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url" content="{{ isset($metatags)? $metatags['url'] : URL::to('/')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ isset($metatags) ? $metatags['title'] : 'ArtDealer.pro'}}"/>
    <meta property="og:description" content="{{ isset($metatags) ? $metatags['description'] : 'ArtDealer. Платформа для покупки и продажи современного исскуства.'}}"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/favicon.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta property="og:image"
          content="{{ isset($metatags) ? $metatags['image'] :URL::to('/web/images/ui/artdealerr_500x1000.png')}}"/>

    <title>ArtDealer</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href="/web/css/assets.css" rel="stylesheet">
    <link href="/web/fonts/Akrobat.css" rel="stylesheet">
    <link href="/web/fonts/Proxima.css" rel="stylesheet">
    <link href="/web/fonts/UniNeue.css" rel="stylesheet">
    <link href="/web/lib/cropperjs/cropper.min.css" rel="stylesheet">
    <link href="/web/lib/jquery-colorpickersliders/jquery.colorpickersliders.css" rel="stylesheet">

    @if((new \Jenssegers\Agent\Agent)->isMobile() && !(new \Jenssegers\Agent\Agent)->isTablet() )
        <link href="/web/css/mob-combine.css" rel="stylesheet">
        <script>window.is_mobile = true</script>
    @else
        <link href="/web/css/combine.css" rel="stylesheet">
        <script>window.is_mobile = false</script>
    @endif
</head>
<body class="{{ $title or 'default' }}">

@yield('scripts_before')

<div id="app">
    @include('web.layout.sections.top-navigation')
    @yield('content')
    <dialog-box></dialog-box>
</div>


@include('web.layout.modals.login')
@include('web.layout.modals.registration')
@include('web.layout.modals.forgot')
@include('web.layout.modals.reset-password')
@include('web.layout.modals.saved')
@include('web.layout.modals.rules')


{{--@include('web.layout.sections.product-overview')--}}
@if (Session::has('dialog-box'))
    <script>
      window.sessionStorage.setItem('dialog-box', '{{Session::get('dialog-box')}}');
    </script>
    {{(Session::forget('dialog-box'))}}
@endif

{{--@include('web.layout.sections.google-maps-place')--}}
<script type="text/javascript" src="/web/js/combine.js?v=11"></script>
<script type="text/javascript" src="/web/vue/2-vue-app.js"></script>

<script>
  let laravel = {authCheck: {!! Auth::check() ? 1 : 0 !!} }
</script>

@yield('scripts_after')


</body>
</html>
