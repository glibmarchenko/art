@extends('web.admin.layout.master')

@section('page-title','Ценители (' . count($users) . ')')
@section('page-subtitle','')

@section('content')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('web.admin.users._navigate',['type'=>'common'])
            </div>
            <div class="col-md-12">
                <div class="widget clean-widget">
                    <div class="widget-body">
                        <table id="users-table" cellspacing="0" width="100%" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                            <tr>
                                <th class="admin-avatar-column"></th>
                                <th>ID</th>
                                <th>ФИО</th>
                                <th>Никнейм</th>
                                <th>Страна</th>
                                <th>Город</th>
                                <th>Телефон</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="table-hover-row">
                                    <td class="avatar-cell-block">
                                        @if($user->avatar)
                                            <img class="admin-user-avatar" src="/web/images/avatars/{{ $user->avatar }}"/>
                                        @else
                                            <img class="admin-item-avatar"
                                                 src="{{url('/web/images/ui/icon-default-avatar.svg')}}">
                                        @endif
                                    </td>
                                    <td>{{ $user->id }}</td>
                                    <td><a href="#" target="_blank">{{ $user->name }} {{ $user->surname }}</a>
                                    <br>
                                        {{$user->email}}
                                        <br>
                                        @if($user->last_login_date)
                                            Login: {{$user->last_login_date->diffForHumans()}}
                                        @endif
                                    </td>
                                    <td>{{ $user->nickname }}
                                    </td>
                                    <td>{{ $user->country }}</td>
                                    <td>{{ $user->city }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td class="action-box">
                                        <div class="btn-group mr-10">
                                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-sm dropdown-toggle btn-change-item-status"></button>
                                            <ul class="dropdown-menu dropdown-menu-right dropdown-color-status">
                                                <li title="Новый"><a href="#" class="bg-box-red"> </a></li>
                                                <li title="Проверенный"><a href="#" class="bg-box-green"> </a></li>
                                                <li title="На модерацию"><a href="#" class="bg-box-blue"> </a></li>
                                                <li title="В черный список"><a href="#" class="bg-box-black"> </a></li>
                                            </ul>

                                        </div>
                                        <a class="action-href" href="#">
                                            <i class="fa fa-pencil" aria-hidden="true" title="Редактировать"></i>
                                        </a>

                                        <a href="{{route('admin.authenticate.user',$user)}}">
                                            <i class="fa fa-user"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
