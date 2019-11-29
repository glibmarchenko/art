@extends('web.admin.layout.master')

@section('page-title','Коммиссии авторов')
@section('page-subtitle','')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills mb-15 admin-navigate-bar">

                    <li class="bg-status-red {{ \Request::is('*commissions/new*') ? 'active' : '' }}">
                        <a href="{{ route('admin.commissions.new') }}">Новые</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*commissions/pending*') ? 'active' : '' }}">
                        <a href="{{ route('admin.commissions.pending') }}">В ожидании</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*commissions/ready*') ? 'active' : '' }}">
                        <a href="{{ route('admin.commissions.ready') }}">Доступно авторам</a>
                    </li>


                    {{--<li class="bg-status-red {{ \Request::is('*print/status/packing*') ? 'active' : '' }}">--}}
                    {{--<a href="{{ route('admin.order.print.packing') }}">Запросы</a>--}}
                    {{--</li>--}}

                    <li class="bg-status-red pull-right {{ \Request::is('*commissions/archive*') ? 'active' : '' }}">
                        <a href="{{ route('admin.commissions.archive') }}">Архив</a>
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
                                <th>Что</th>
                                <th>Стоимость</th>
                                <th>Покупатель</th>
                                <th>Статус Заказа</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($commissions as $commission)
                                <tr>
                                    <td class="avatar-cell-block">
                                        <div class="avatar-with-details">
                                            <img class="admin-item-avatar"
                                                 onclick="window.open('{{url($commission->product->image_preview_m)}}', 'Preview', 'width=600, height=600'); return false;"
                                                 src="{{url($commission->product->image_preview_s)}}">
                                            <div class="details">
                                                <small>#{{$commission->product->id}}</small>
                                                <h4 style="margin-bottom:5px;">{{$commission->product->name}}</h4>
                                                <a href="{{$commission->product->author->profile_url}}"
                                                   target="_blank">{{$commission->product->author->name}} {{$commission->product->author->surname}}</a>
                                                <h5>Продает: {{$commission->user->full_name}}
                                                    @if($commission->user->gallery_profile)
                                                        {{$commission->user->gallery_profile->name}}
                                                    @endif
                                                </h5>
                                                <br>

                                                <br>
                                                <a href="{{url($commission->product->image_preview_original)}}"
                                                   download>
                                                    <i class="fa fa-file"></i>
                                                </a>
                                                {{$commission->product->width}} x {{$commission->product->height}} мм

                                            </div>

                                        </div>

                                    </td>
                                    <td>
                                        <div class="price-table-cell">
                                            <div class="content">
                                                <h4 class="{{$commission->product->type_class_colour}}">{{$commission->product->type_name}}</h4>
                                                <p>Цена автора - {{$commission->product->price}}
                                                    <small>EUR</small>
                                                </p>
                                                <p>Платформа - {{$commission->product->prices->platform }}
                                                    <small>EUR</small>
                                                </p>
                                                <p>
                                                    Коммиссия автора - {{$commission->amount}}
                                                    <small>EUR</small>
                                                </p>
                                                <p>
                                                    Цена клиента - {{$commission->product->prices->final}}
                                                    <small>EUR</small>
                                                </p>
                                                @if(!$commission->pending_start_at)
                                                    <br><br>
                                                    <a href="{{route('admin.commissions.approve',$commission)}}"
                                                       class="btn btn-default btn-success">
                                                        <div>
                                                            Подтвердить коммиссию
                                                        </div>
                                                    </a>
                                                    @else
                                                    <br>
                                                    <a class="btn btn-success btn-small">{{$commission->amount}} EUR</a>
                                                @endif



                                                @if($commission->manual)

                                                    <a class="btn btn-warning btn-small">Вручную</a>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h4>#{{$commission->order->uid}}</h4>
                                        <small>{{$commission->order->created_at->format('d-m-Y')}}</small>
                                        @if($commission->order->delivery_id !== '00000000000')
                                            <small>{{$commission->order->delivery_id}}</small>
                                        @endif
                                        <br>
                                        <br>
                                        <h5>{{$commission->order->buyer->full_name}}</h5>
                                        {{$commission->order->buyer->email}}
                                        <hr>
                                        {{$commission->order->delivery_country}}
                                        {{$commission->order->delivery_city}}
                                        {{$commission->order->delivery_street}}
                                        {{$commission->order->delivery_house}}
                                        <br>
                                        {{$commission->order->delivery_name}}               {{$commission->order->delivery_phone}}
                                    </td>
                                    <td class="statuses">

                                        <div class="{{$commission->order->paid ? ' active'   : '' }}">Оплачено</div>


                                        <a href="{{route('admin.order.state.produced',$commission->order)}}">
                                            <div class="{{$commission->order->produced ? ' active' : '' }}">Печать</div>
                                        </a>

                                        <a href="{{route('admin.order.state.packed',$commission->order)}}">
                                            <div class="{{$commission->order->produced ? ' active' : '' }}">Упаковка
                                            </div>
                                        </a>

                                        <div data-toggle="modal" data-target="#exampleModal"
                                             onclick="document.getElementById('order_id').value= '{{$commission->order->id}}'"
                                             class="{{$commission->order->shipped ? ' active' : '' }}">Отправлено
                                        </div>
                                        <a href="{{route('admin.order.state.completed',$commission->order)}}">
                                            <div class="{{$commission->order->completed ? ' active' : '' }}">Готово
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Введи ТНН</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form method="POST" action="{{route('admin.order.state.shipped')}}">
                                        {{csrf_field()}}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="delivery_id"
                                                       name="delivery_id">
                                                <input type="hidden" value="" name="order_id" id="order_id">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Сохранить</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
