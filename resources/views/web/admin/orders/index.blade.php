@extends('web.admin.layout.master')

@section('page-title','Заказы, Принты')
@section('page-subtitle','')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills mb-15 admin-navigate-bar">

                    <li class="bg-status-red {{ \Request::is('*print/status/active*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.active') }}">В работе</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*print/status/preparation*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.state', ['type' => 'print', 'state' => 'preparation']) }}">Подготавливаются</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*print/status/production*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.state', ['type' => 'print', 'state' => 'production']) }}">Печатаются</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*print/status/packing*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.state', ['type' => 'print', 'state' => 'packing']) }}">Упаковываются</a>
                    </li>

                    <li class="bg-status-red {{ \Request::is('*print/status/delivery*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.state', ['type' => 'print', 'state' => 'delivery']) }}">К отправке</a>
                    </li>



                    <li class="bg-status-red pull-right {{ \Request::is('*print/status/archived*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.archived') }}">Архив</a>
                    </li>

                    <li class="bg-status-red pull-right {{ \Request::is('*print/status/completed*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.state', ['type' => 'print', 'state' => 'completed']) }}">Завершенные</a>
                    </li>

                    <li class="bg-status-red pull-right {{ \Request::is('*print/status/cancelled*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.print.state', ['type' => 'print', 'state' => 'cancelled']) }}">Отменены</a>
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


                                                    <br>
                                                    <br>
                                                    <div class="btn btn-warning btn-small"> {{$order->state}}</div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        @include('web.admin.orders.prices.print-price')
                                        @include('web.admin.orders.prices.commission')
                                    </td>
                                    <td>
                                        @include('web.admin.orders.delivery.delivery')
                                    </td>
                                    <td class="statuses">
                                        @include('web.admin.orders.statuses.print-statuses')
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
