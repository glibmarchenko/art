<section id="reset-modal-section">
    <!-- Modal -->
    <div class="modal fade" id="reset-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <h2 class="modal-heading">Сброс пароля</h2>

                <form class="modal-form" role="form" method="POST" action="{{ url('/password/reset') }}"  data-success-modal="redirectHome">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ isset($token)?$token:0 }}">


                    <input type="email" name="email" placeholder="{{ trans('homepage.Email') }}">
                    <div class="form-error-message" data-field="email"></div>


                    <input type="password" name="password" placeholder="{{ trans('account.Password') }}">
                    <div class="form-error-message" data-field="password"></div>


                    <input type="password" name="password_confirmation"
                           placeholder="{{ trans('account.Repeat password') }}">
                    <div class="form-error-message" data-field="password_confirmation"></div>


                    <input type="submit" class="submit" value="{{ trans('account.Reset password') }}">

                </form>

            </div>
        </div>
    </div>

</section>