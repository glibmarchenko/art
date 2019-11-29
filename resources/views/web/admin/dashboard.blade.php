@extends('web.admin.layout.master')

@section('page-title','Главная')
@section('page-subtitle','Общие отчеты и графики')

@section('content')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Принты</h2>
                <div class="row">
                    <div class="col-md-2">
                        <div class="widget no-border p-15 bg-purple media">
                            <div class="media-left media-middle"><i class="media-object ti-shopping-cart fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">В работе</h6>
                                <div class="fs-20">{{\App\Models\Order::wherePaid(1)->whereCompleted(0)->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="widget no-border p-15 bg-success media">
                            <div class="media-left media-middle"><i class="media-object ti-user fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Печать</h6>
                                <div class="fs-20">{{\App\Models\Order::whereState('production')->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="widget no-border p-15 bg-warning media">
                            <div class="media-left media-middle"><i class="media-object ti-paint-bucket fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Доставка</h6>
                                <div class="fs-20">{{\App\Models\Order::whereState('delivery')->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="widget no-border p-15 bg-info media">
                            <div class="media-left media-middle"><i class="media-object ti-direction-alt fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Отменено</h6>
                                <div class="fs-20">{{\App\Models\Order::wherePaid(0)->count()}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="widget no-border p-15 bg-primary media">
                            <div class="media-left media-middle"><i class="media-object ti-email fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Готово</h6>
                                <div class="fs-20">{{\App\Models\Order::whereCompleted(1)->count()}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="widget no-border p-15 bg-primary media">
                            <div class="media-left media-middle"><i class="media-object ti-email fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Архив</h6>
                                <div class="fs-20">{{\App\Models\Order::whereCompleted(1)->count()}}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('script')
    <script type="text/javascript" src="/system/assets/js/page-content/dashboard/index-v2.js"></script>
@endpush
