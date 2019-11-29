@extends('web.admin.layout.master')

@section('page-title','Художники (' . count($users) . ')')
@section('page-subtitle','')

@section('content')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills mb-15 admin-navigate-bar">
                    <li class="bg-status-red {{ (\Request::is('systems/users/artist') || \Request::is('systems/users/artist/new*') ) ? 'active' : '' }}"
                        data-class="bg-box-red">
                        <a href="{{ route('admin.users.artist.new') }}">Новые</a>
                    </li>
                    <li class="bg-status-green {{ \Request::is('systems/users/artist/accepted*') ? 'active' : '' }}"
                        data-class="bg-box-green">
                        <a href="{{ route('admin.users.artist.accepted') }}">Просмотрены</a>
                    </li>
                    <li class="bg-status-black {{ \Request::is('systems/users/artist/top*') ? 'active' : '' }}"
                        data-class="bg-box-black">
                        <a href="{{ route('admin.users.artist.top') }}">Топ</a>
                    </li>
                    <li class="bg-status-black {{ \Request::is('systems/users/artist/gallery*') ? 'active' : '' }}"
                        data-class="bg-box-black">
                        <a href="{{ route('admin.users.artist.gallery') }}">Галереи</a>
                    </li>
                    <li class="bg-status-black {{ \Request::is('systems/users/artist/rejected*') ? 'active' : '' }}"
                        data-class="bg-box-black">
                        <a href="{{ route('admin.users.artist.rejected') }}">Отклонены</a>
                    </li>
                    <li class="bg-status-black {{ \Request::is('systems/users/artist/deleted*') ? 'active' : '' }}"
                        data-class="bg-box-black">
                        <a href="{{ route('admin.users.artist.deleted') }}">Удалены</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="widget clean-widget">
                    <div class="widget-body">
                        <table id="users-table" cellspacing="0" width="100%"
                               class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="admin-avatar-column"></th>
                                <th>Имя</th>
                                <th>Откуда</th>
                                <th></th>
                                <th></th>
                                <th>Топ</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr id="{{$user->id}}">
                                    <td style="font-size:0;">{{$user->id}}</td>

                                    <td class="avatar-cell-block">
                                        @if($user->avatar)
                                            <img class="admin-item-avatar"
                                                 src="{{url('/web/images/avatars/'.$user->avatar)}}">
                                        @else
                                            <img class="admin-item-avatar"
                                                 src="{{url('/web/images/ui/icon-default-avatar.svg')}}">
                                        @endif
                                    </td>

                                    <td>
                                        <small>#{{$user->id}}</small>
                                        <a href="{{route('user.show',$user)}}" target="_blank">
                                            <h4 style="margin-bottom:5px;">{{$user->full_name}}</h4>
                                        </a>
                                        <br>
                                        @if($user->gallery_id)
                                            {{$user->gallery->name}}
                                        @else
                                            {{$user->email}}
                                        @endif<br>
                                        {{$user->phone}}
                                        <br>
                                        {{$user->contact_phone}}
                                        <br>
                                        @if($user->last_login_date)
                                           Login: {{$user->last_login_date->diffForHumans()}}
                                        @endif
                                        <br>

                                    </td>


                                    <td>{{$user->country}} {{$user->city}}</td>

                                    <td class="text-center">
                                        <a href="{{route('user.viewed.toggle',$user->id)}}"
                                           class="btn {!! $user->viewed ? 'btn-warning' : 'btn-default' !!}">Проверено</a>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{route('user.rejected.toggle',$user->id)}}"
                                           class="btn {!! $user->rejected ? 'btn-warning' : 'btn-default' !!}">Отклонено</a>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{route('user.top.toggle',$user->id)}}"
                                           class="btn {!! $user->top ? 'btn-warning' : 'btn-default' !!}">Топ</a>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{route('admin.authenticate.user',$user->id)}}">
                                            <i class="fa fa-user fa-2x"></i>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <form action="{{route('admin.users.artist.destroy',$user->id)}}"
                                              onsubmit="return confirm('Действительно {{ $user->deleted_at === null ? 'удалить' : 'восстановить' }} пользователя?');"
                                              method="POST">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            {{ method_field('DELETE') }}
                                            <button type="submit"
                                                    class="btn {!! $user->deleted_at === null ? 'btn-default' : 'btn-warning' !!}">
                                                ✖
                                            </button>
                                        </form>
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
