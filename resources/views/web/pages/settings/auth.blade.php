@extends('web.pages.settings.index')

@section('settings-content')
    <section class="settings-block">
        <!-- Settings menu -->
        <h1 class="title">
            {{ trans('dashboard.login_edit') }}
        </h1>
        <div class="content">
            <div class="form-block">
                <form action="{{route('settings.auth.save')}}" class="form-login" method="POST">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <label>{{ trans('homepage.Email') }}</label>
                        <div class="form-error-message show-this">{{isset($errors->email)&&count($errors->email)?$errors->email:''}}</div>
                        @if($user->temp_email)
                            <input value="{{old('email') ? old('email') : ''}}" name="email"/>
                        @else
                            <input value="{{old('email') ? old('email') : $user->email}}" name="email"/>
                        @endif

                    </div>
                    <div class="form-row {{isset($errors->old_password)||isset($errors->new_password)?'hidden':''}}">
                        <label>{{ trans('account.Password') }}</label>
                        <div class="form-row-group">
                            <input type="password" value="********" disabled/>
                            <span class="message change-password">{{ trans('dashboard.change') }}</span>
                        </div>
                    </div>
                    <div class="password-block {{isset($errors->old_password)||isset($errors->new_password)?'show-this':''}}">
                        @if(!$user->no_password)
                            <div class="form-row">
                                <label>{{ trans('dashboard.Old password') }}</label>
                                <div class="form-error-message show-this">{{isset($errors->old_password)&&count($errors->old_password)?$errors->old_password:''}}</div>
                                <div class="form-row-group">
                                    <input type="password" name="old_password" value="" />
                                </div>
                            </div>
                        @endif
                        <div class="form-row">
                            <label>{{ trans('dashboard.New password') }}</label>
                            <div class="form-error-message show-this">{{isset($errors->new_password)&&count($errors->new_password)?$errors->new_password:''}}</div>
                            <div class="form-row-group">
                                <input type="password" name="new_password" value="" />
                            </div>
                        </div>
                        <div class="form-row">
                            <label>{{ trans('account.Repeat password') }}</label>
                            <div class="form-row-group">
                                <input type="password" name="confirm_password" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row submit-row">
                        <button type="submit" class="btn btn-55 btn-fill-red btn-m-89">{{ trans('dashboard.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


@endsection
