@extends('web.admin.layout.master')

@section('page-title','Галереи (' . count($galleries) . ')')
@section('page-subtitle','')

@section('content')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills mb-15 admin-navigate-bar">
                    <li class="bg-status-red {{ (\Request::is('systems/users/gallery') || \Request::is('systems/users/gallery/new*') ) ? 'active' : '' }}"
                        data-class="bg-box-red">
                        <a href="{{ route('admin.users.gallery.new') }}">Новые</a>
                    </li>
                    <li class="bg-status-green {{ \Request::is('systems/users/gallery/accepted*') ? 'active' : '' }}"
                        data-class="bg-box-green">
                        <a href="{{ route('admin.users.gallery.accepted') }}">Проверены</a>
                    </li>

                    <li class="bg-status-green {{ \Request::is('systems/users/gallery/top*') ? 'active' : '' }}"
                        data-class="bg-box-green">
                        <a href="{{ route('admin.users.gallery.top') }}">Топ</a>
                    </li>
                    <li class="bg-status-black {{ \Request::is('systems/users/gallery/rejected*') ? 'active' : '' }}"
                        data-class="bg-box-black">
                        <a href="{{ route('admin.users.gallery.rejected') }}">Отклонены</a>
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
                                <th>Название</th>
                                <th>Владелец</th>
                                <th>Страна</th>
                                <th>Проверено</th>
                                <th>Топ</th>
                                <th>Отклонено</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($galleries as $gallery)
                                <tr id="{{$gallery->id}}">
                                    <td style="font-size:0;">{{$gallery->id}}</td>

                                    <td class="avatar-cell-block">
                                        @if($gallery->bg)
                                            <img class="admin-item-avatar"
                                                 src="{{url('/web/images/galleries/'.$gallery->bg)}}">
                                        @else
                                            <img class="admin-item-avatar"
                                                 src="{{url('/web/images/ui/icon-default-avatar.svg')}}">
                                        @endif
                                    </td>

                                    <td>
                                        <small>#{{$gallery->id}}</small>
                                        <a href="{{route('gallery.show',$gallery)}}" target="_blank">
                                            <h4 style="margin-bottom:5px;">{{$gallery->name}}</h4>
                                        </a>
                                        {{$gallery->full_address}}
                                        <br>
                                        {{$gallery->type_name}}

                                        <br>
                                        {{$gallery->web}}
                                        <br>
                                        {{$gallery->owner->contact_phone}}
                                        <br>
                                        @if($gallery->owner->last_login_date)
                                            Login: {{$gallery->owner->last_login_date->diffForHumans()}}
                                        @endif
                                        <br>
                                    </td>

                                    <td class="">
                                        {{$gallery->gallery_owner_name}}
                                        <br>
                                        {{$gallery->gallery_owner_phone}}
                                    </td>

                                    <td>{{$gallery->country}}</td>

                                    <td class="text-center">
                                        <a href="{{route('gallery.viewed.toggle',$gallery->id)}}"
                                           class="btn {!! $gallery->viewed ? 'btn-warning' : 'btn-default' !!}">Проверено</a>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{route('gallery.top.toggle',$gallery->id)}}"
                                           class="btn {!! $gallery->top ? 'btn-warning' : 'btn-default' !!}">Топ</a>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{route('gallery.rejected.toggle',$gallery->id)}}"
                                           class="btn {!! $gallery->rejected ? 'btn-warning' : 'btn-default' !!}">Отклонено</a>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{route('admin.authenticate.user',$gallery->owner->id)}}">
                                            <i class="fa fa-user fa-2x"></i>
                                        </a>

                                        <form action="{{route('admin.users.artist.destroy',$gallery->owner->id)}}"
                                              onsubmit="return confirm('Действительно {{ $gallery->owner->deleted_at === null ? 'удалить' : 'восстановить' }} пользователя?');"
                                              method="POST">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            {{ method_field('DELETE') }}
                                            <button type="submit"
                                                    class="btn {!! $gallery->owner->deleted_at === null ? 'btn-default' : 'btn-warning' !!}">
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
