@extends('web.layout.template')

@section('content')

    <section id="subscription-navigation">
        <a href="{{route('order.active')}}">
            <div {!! \Request::is('*/active*') ? 'class="active"': '' !!}>{{ trans('dashboard.Active') }}</div>
        </a>
        <a href="{{route('order.cancelled')}}">
            <div {!! \Request::is('*/cancelled*') ? 'class="active"': '' !!}>{{ trans('dashboard.Pay') }}</div>
        </a>
        <a href="{{route('order.completed')}}">
            <div {!! \Request::is('*/completed*')  ? 'class="active"': '' !!}>{{ trans('dashboard.Completed') }}</div>
        </a>
    </section>

    <section id="orders">
        <div class="wrapper">
            @foreach($orders as $order)
                <div class="order">
                    <h1>Заказ {{$order->uid}} <span>{{$order->created_at}}</span> <span>{{$order->state}}</span> <span
                                class="total-price">{{$order->total_amount}} eur</span></h1>
                    <div class="products">
                        @foreach($order->purchases as $purchase)
                            <div class="product">
                                <div class="content">
                                    <div class="product-image"
                                         style="
                                                 background-image: url('{{$purchase->product->image_preview_m}}');
                                                 background-size: contain;
                                                 background-repeat: no-repeat;
                                                 background-position:center
                                                 ">
                                    </div>
                                    <div class="product-description">
                                        <div class="product-type {{'obj-'.$purchase->product->type}}">{{$purchase->product->type_name}}</div>
                                        <div class="product-author">{{$purchase->product->author->name}}
                                            {{$purchase->product->author->surname}}
                                        </div>
                                        <div class="product-name">{{$purchase->product->name}}</div>
                                        <ul class="product-details-list">
                                            <li>Материал - <span>Печать на холсте</span></li>
                                            <li>Размер - <span>{{$purchase->product->width}}
                                                    x {{$purchase->product->height}} мм</span>
                                            </li>
                                            <li>Упаковка - <span>Картон, Пленка</span></li>
                                        </ul>
                                    </div>
                                    <div class="delivery-details">
                                        <div class="product-type">Доставка</div>
                                        <ul class="product-details-list" style="margin-top:0;">
                                            <li>Компания доставки - <span>Новая почта</span></li>
                                            <li>Номер накладной - @if($order->delivery_id !== '00000000000')
                                                    <span>{{$order->delivery_id}}</span>@endif</li>
                                        </ul>

                                        <ul class="product-details-list">
                                            <li>Адрес - <span>{{$order->delivery_country}}, {{$order->delivery_city}}
                                                    , {{$order->delivery_street}} {{$order->delivery_house}}</span></li>
                                            <li>Получатель - <span>{{$order->delivery_name}}</span></li>
                                            <li>Телефон - <span>{{$order->delivery_phone}}</span></li>
                                        </ul>

                                    </div>
                                    @if($order->delivery_id !== '00000000000' && !$order->completed)
                                        <div class="product-delete">
                                            <a class="btn btn-outline-gray btn-55" target="_blank"
                                               href="https://novaposhta.ua/ru/tracking/?cargo_number={{$order->delivery_id}}">Отследить</a>
                                        </div>
                                    @endif

                                    @if(!$order->paid)
                                        <div class="product-delete">
                                            <a class="btn btn-outline-gray btn-55" style="margin-right:8px;"
                                               href="{{route('order.delete',$order->id)}}">Отменить</a>
                                        </div>
                                    @endif


                                </div>
                                <div class="separator-small"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </section>
@endsection
