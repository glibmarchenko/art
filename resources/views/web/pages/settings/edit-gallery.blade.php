@extends('web.pages.settings.index')

@section('settings-content')
   <settings-edit-gallery/>
@endsection

@section('scripts_before')
   <script>
     window.gallery = {!! $gallery->toJSON(JSON_UNESCAPED_UNICODE ) !!};
   </script>
@endsection

