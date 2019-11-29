@extends('web.layout.template')

@section('content')
    <section class="finance-block">
        <div class="header-block">
            <div class="available">
                <div class="title gray">{{ trans('dashboard.Available') }}:</div>
                <div class="finance-content">
                    <div class="sum">{{Auth::user()->commissions()->pendingOver()->sum('amount')}}
                        <div>EUR</div>
                    </div>
                    <div class="buttons">
                        <a href="#" class="btn btn-border btn-outline-black medium">{{ trans('dashboard.Rules') }}</a>
                        <a href="#" class="btn btn-c-fill btn-outline-black medium">{{ trans('dashboard.Receive') }}</a>
                    </div>
                </div>
            </div>
            <div class="waiting">
                <div class="title white">{{ trans('dashboard.Waiting') }}</div>
                <div class="finance-content">
                    <div class="sum">{{Auth::user()->commissions()->pending()->sum('amount')}}
                        <div>EUR</div>
                    </div>
                    <div class="buttons">
                        <a href="#" class="btn btn-border btn-c-white medium">{{ trans('dashboard.Rules') }}</a>
                        <a href="#" class="btn btn-c-fill btn-c-fill-white medium">{{ trans('homepage.More info') }}</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="history-block">
            <div class="main-title">
                {{ trans('dashboard.Sales history') }}
            </div>
            <div class="main-content">
                <table class="light-table">
                    <thead>
                    <tr>
                        <td>{{ trans('dashboard.Photo') }}</td>
                        <td>{{ trans('dashboard.Artwork name') }}</td>
                        <td>{{ trans('dashboard.Order') }} №</td>
                        <td>{{ trans('dashboard.Date') }}</td>
                        <td>{{ trans('dashboard.Type') }}</td>
                        <td>{{ trans('dashboard.Price') }}</td>
                        <td>{{ trans('dashboard.Status') }}</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($commissions as $commission)
                        @foreach($commission->order->products as $product)
                            <tr>
                                <td>
                                    <img src="{{url($product->image_preview_s)}}">
                                </td>
                                <td>
                                    {{$product->name}}
                                </td>
                                <td>{{$commission->order->uid}}</td>
                                <td>{{$commission->created_at->format('Y-m-d')}}</td>
                                <td>{{$commission->order->type}}</td>
                                <td>{{$commission->amount}} {{$commission->currency}}</td>
                                <td>{{trans('account.'.$commission->order->state)}}</td>
                            </tr>
                        @endforeach
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
