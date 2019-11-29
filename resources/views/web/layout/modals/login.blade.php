<section id="login-modal-section">
    <!-- Modal -->
    <div class="modal fade" id="login-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-close-circle btn-icon-close" data-dismiss="modal">
                    <img src="/web/images/ui/modal_close.svg">
                </div>
                <h2 class="modal-heading">{{ trans('account.Log in') }} / <a data-dismiss="modal" data-toggle="modal" data-target="#registration-modal">{{ trans('account.Registration') }}</a></h2>

                <div class="socials-container">
                    {{--<a href="{{route('social.auth',['soc'=>'vk'])}}"><div><img src="{{asset('web/images/ui/social/vk.svg')}}"></div></a>--}}
                    <a href="{{route('social.auth',['soc'=>'google'])}}"><div><img src="{{asset('web/images/ui/social/g.svg')}}"></div></a>
                    <a href="{{route('social.auth',['soc'=>'facebook'])}}"><div><img src="{{asset('web/images/ui/social/fb.svg')}}"></div></a>
                </div>

                <form class="modal-form" action="/login" method="POST" data-success-modal="refreshPage">

                    <div class="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="email" placeholder="{{ trans('homepage.Email') }}">
                        <div class="form-error-message" data-field="email"></div>

                        <input type="password" name="password" placeholder="{{ trans('account.Password') }}">
                        <div class="form-error-message" data-field="password"></div>
                    </div>

                    <input type="submit" class="submit" value="{{ trans('account.Log in') }}">

                    <div class="forgot-password">
                        <a data-dismiss="modal" data-toggle="modal"
                           data-target="#forgot-modal">{{ trans('account.Forgot password') }}</a>
                    </div>

                </form>

                <div class="modal-close-wrapper">
                    <a class="btn btn-m-89" data-dismiss="modal">{{ trans('pages.Close') }}</a>
                </div>
            </div>
        </div>
    </div>

</section>