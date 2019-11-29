@extends('web.pages.settings.index')

@section('settings-content')
    <settings-gallery :gallery="gallery"/>

@endsection

@section('scripts')
    <script>
        var gallery = JSON.parse({!! $gallery->toJSON !!});
    </script>
@endsection
