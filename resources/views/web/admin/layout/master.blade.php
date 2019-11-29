<!DOCTYPE html>
<html lang="en">
<head>

    @include('web.admin.layout.head')

</head>
<body>
<!-- Header start-->
<header>

    @include('web.admin.layout.header')

</header>
<!-- Header end-->
<div class="main-container">

    @include('web.admin.layout.menu')

    <!-- Main Sidebar end-->
    <div class="page-container">

        @yield('content')

        {{--
        @include('web.admin.layout.footer-block')
        --}}

    </div>
</div>


@include('web.admin.layout.footer')

</body>
</html>



