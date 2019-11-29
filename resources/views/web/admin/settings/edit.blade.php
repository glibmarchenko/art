@extends('web.admin.layout.master')

@section('page-title','Настройки')
@section('page-subtitle','')

@section('content')

    <div class="container">

        <div class="col-lg-8">
            <h1>Настройки</h1>

            {{Form::open([''])}}

            @foreach($settings as $setting)
                <div class="form-group">
                    <label>{{$setting->description}}</label>
                    <input type="text" name="{{$setting->name}}" class="form-control" value="{{$setting->value}}">
                </div>
            @endforeach

            <input type="submit" class="btn btn-large">

            {{Form::close()}}
        </div>
    </div>


@endsection