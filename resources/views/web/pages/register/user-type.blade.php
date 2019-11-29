@extends('web.layout.template')

@section('content')

<section class="fill-block register-block">
    <div class="panel-block" :class="{'block-33 left-part-section fill-bg-white':!$root.is_mobile}">
        <div class="content">
            <div class="title color-black">{{ trans('homepage.Art lover') }}</div>
            <div class="description color-black">
                {{ trans('account.buy_paintings') }}.<br>
                {{ trans('account.follow_authors') }}.<br>
                {{ trans('account.add_liked') }}.
            </div>
            <div class="button-block">
                <div class="button">
                    <a href="{{route('register.step1',['type'=>1])}}" class="btn btn-fill btn-fill-green btn-m-89">{{ trans('account.continue_as') }} {{ trans('homepage.Art lover') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-block" :class="{'block-33 left-part-section fill-bg-light-gray':!$root.is_mobile}">
        <div class="content">
            <div class="title color-black">{{ trans('account.Artist') }}</div>
            <div class="description color-black">
                {{ trans('account.sell_pictures') }}.<br>
                {{ trans('account.portfolio') }}.<br>
                {{ trans('account.look_others') }}.
            </div>
            <div class="button-block">
                <div class="button">
                    <a href="{{route('register.step1',['type'=>2])}}" class="btn btn-fill btn-fill-red btn-m-89">{{ trans('account.continue_as') }} {{ trans('account.Artist') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-block" :class="{'block-33 left-part-section fill-bg-white':!$root.is_mobile}">
        <div class="content">
            <div class="title color-black">{{ trans('dashboard.Gallery') }}</div>
            <div class="description color-black">
                {{ trans('account.create_profiles') }}<br>
                {{ trans('account.post_works') }}.<br>
                {{ trans('account.add_info') }}.

            </div>
            <div class="button-block">
                <div class="button">
                    <a href="{{route('register.step1',['type'=>3])}}" class="btn btn-fill btn-fill-blue btn-m-89">{{ trans('account.continue_as') }} {{ trans('dashboard.Gallery') }}</a>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
