@extends('web.layout.template')

@section('content')
  @include('web.pages.settings._tabs')
  @yield('settings-content')
@endsection
