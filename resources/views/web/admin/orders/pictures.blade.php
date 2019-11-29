@extends('web.admin.layout.master')

@section('page-title','Заказы, Картины')
@section('page-subtitle','')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills mb-15 admin-navigate-bar">

                    <li class="bg-status-red {{ \Request::is('*state/active*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.picture.state.active') }}">В работе</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*pictures/status/hold*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.pictures.state', ['state' => 'hold']) }}">Удержание</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*pictures/status/reserved*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.pictures.state', ['state' => 'reserved']) }}">В резерве</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*pictures/status/deliv*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.pictures.state', ['state' => 'delivery']) }}">Отправка</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*pictures/status/completed*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.pictures.state', ['state' => 'completed']) }}">Готово</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*pictures/status/cancelled*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.pictures.state', ['state' => 'cancelled']) }}">Отменено</a>
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
                                <th>Доставка</th>
                                <th>Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="avatar-cell-block">
                                        @foreach ($order->products as $item)
                                            <div class="avatar-with-details">
                                                <img class="admin-item-avatar"
                                                     onclick="window.open('{{url($item->image_preview_m)}}', 'Preview', 'width=600, height=600'); return false;"
                                                     src="{{url($item->image_preview_s)}}">
                                                <div class="details">
                                                    <small>#{{$item->id}}</small>
                                                    <h4 style="margin-bottom:5px;">{{$item->name}}</h4>
                                                    <a href="{{$item->author->profile_url}}"
                                                       target="_blank">{{$item->author->name}} {{$item->author->surname}}</a>
                                                    <br>
                                                    <br>
                                                    <a href="{{url($item->image_preview_original)}}" download>
                                                        <i class="fa fa-file"></i>
                                                    </a>
                                                    {{$item->width}} x {{$item->height}} мм
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($order->products as $item)
                                            <div class="price-table-cell">
                                                <div class="content">
                                                    <p>Стоимость - {{($item->price)}}
                                                        <small>EUR</small>
                                                    </p>

                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <h4>#{{$order->uid}}</h4>
                                        <small>{{$order->created_at->format('d-m-Y')}}</small>
                                        @if($order->delivery_id !== '00000000000')
                                            <br>
                                            <small>{{$order->delivery_id}}</small>
                                        @endif
                                        <br>
                                        <br>
                                        <h5>Адресс</h5>
                                        {{$order->delivery_country}}
                                        {{$order->delivery_city}}
                                        {{$order->delivery_street}}
                                        {{$order->delivery_house}}
                                        <br>
                                        {{$order->delivery_name}}               {{$order->delivery_phone}}
                                        <br>
                                        <br>
                                        @if($order->delivery_description)
                                            <h5>Примечание</h5>
                                            <small>{{$order->delivery_description}}</small>
                                        @endif
                                    </td>
                                    <td class="statuses">
                                        @include('web.admin.orders.statuses.other-statuses')
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
