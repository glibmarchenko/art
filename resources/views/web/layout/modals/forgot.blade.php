<section id="forgot-modal-section">
    <!-- Modal -->
    <div class="modal fade" id="forgot-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <h2 class="modal-heading"><a data-dismiss="modal" data-toggle="modal"
                                             data-target="#login-modal">{{ trans('account.Log in') }}</a> / <a
                            data-dismiss="modal" data-toggle="modal"
                            data-target="#registration-modal">{{ trans('account.Registration') }}</a></h2>

                <div class="socials-container">
                    {{--<a href="{{route('social.auth',['soc'=>'vk'])}}"><div><img src="{{asset('web/images/ui/social/vk.svg')}}"></div></a>--}}
                    <a href="{{route('social.auth',['soc'=>'google'])}}"><div><img src="{{asset('web/images/ui/social/g.svg')}}"></div></a>
                    <a href="{{route('social.auth',['soc'=>'facebook'])}}"><div><img src="{{asset('web/images/ui/social/fb.svg')}}"></div></a>
                </div>

                <form class="modal-form" action="/password/email" method="POST">

                    <div class="form">
                        {{ csrf_field() }}
                        <input type="text" name="email" placeholder="{{ trans('homepage.Email') }}">
                        <div class="form-error-message" data-field="email"></div>

                    </div>

                    <input type="submit" class="submit" value="{{ trans('homepage.Restore access') }}">


                </form>
            </div>
        </div>
    </div>

</section>