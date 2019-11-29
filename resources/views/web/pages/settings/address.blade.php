@extends('web.pages.settings.index')

@section('settings-content')
    <section class="settings-block">
        <!-- Settings menu -->
        @if(Auth::user()->role !== 1)
            <h1 class="title">
                {{ trans('dashboard.send_here')  }}
            </h1>
        @else
            <h1 class="title">
                Адрес и контактная информация
            </h1>
        @endif
        <div class="content">
            <div class="form-block">
                <form action="{{route('settings.address.save')}}" class="form-address" method="POST">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <label>{{ trans('homepage.Country') }}</label>
                        <div class="form-error-message show-this">{{$errors->first('country')}}</div>
                        <div class="form-row-group">
                            <input type="text" id="country-input" placeholder="" name="country"
                                   value="{{old('country') ? old('country') : $user->country}}"/>
                            <!-- Use .available  -->
                            <span class="dot-availability available"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <label>{{ trans('dashboard.City') }}</label>
                        <input type="text" name="city" value="{{old('city') ? old('city') : $user->city}}"/>
                    </div>
                    <div class="form-row">
                        <label>{{ trans('dashboard.Street') }}</label>
                        <input type="text" name="street" value="{{old('street') ? old('street') : $user->street}}"/>
                    </div>
                    <div class="form-row-group-inputs">
                        <div class="form-row">
                            <label>{{ trans('dashboard.Building number') }}</label>
                            <input type="text" name="house_number"
                                   value="{{old('house_number') ? old('house_number') : $user->house_number}}"/>
                        </div>
                        <div class="form-row">
                            <label>{{ trans('dashboard.Apartment number') }}</label>
                            <input type="text" name="apartment_number"
                                   value="{{old('apartment_number') ? old('apartment_number') : $user->apartment_number}}"/>
                        </div>
                        <div class="form-row">
                            <label>{{ trans('dashboard.Index') }}</label>
                            <input type="text" name="index" value="{{old('index') ? old('index') : $user->index}}"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <label>{{ trans('dashboard.phone_courier') }}</label>
                        <div class="form-error-message show-this">{{$errors->first('phone')}}</div>
                        <input type="text" name="phone" placeholder="38 000 000 00 00"
                               value="{{old('phone') ? old('phone') : $user->phone}}"/>
                    </div>
                    <div class="form-row">
                        <label>{{ trans('dashboard.Note') }}</label>
                        <textarea name="note">{{ old('note') ? old('note') : $user->note}}</textarea>
                    </div>
                    <div class="form-row submit-row">
                        <button type="submit" class="btn btn-55 btn-fill-red btn-m-89">{{ trans('dashboard.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


@endsection
