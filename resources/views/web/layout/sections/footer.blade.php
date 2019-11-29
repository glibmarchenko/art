    <div class="footer-film">
    <section class="footer">
        <div class="block-container block-part-3 about">
            <div class="title">Artdealer</div>
            <div class="simple-text">{{ trans('homepage.platform_for_buying_selling') }}
                <br>    <br>
                {{ trans('homepage.any_artist') }}
                <br>    <br>
                {{ trans('homepage.each_gallery') }}
                <br>    <br>
                {{ trans('homepage.if_you_are_interested') }}</div>
        </div>
        <div class="block-container block-part-3 contact-form">
            <div class="title">{{ trans('homepage.Write to us') }}</div>
            <div class="simple-text">
                <form action="#" class="form-block">
                    <input class="input-field input-50 input-1" placeholder="{{ trans('homepage.Name') }}" name="name"/>
                    <select class="input-field select-field input-50  input-2" name="country">
                        <option value="0">{{ trans('homepage.Country') }}</option>
                        @include('web.layout.sections.countries-options')
                    </select>

                    <input class="input-field" placeholder="{{ trans('homepage.Email') }}" name="email"/>
                    <textarea class="input-field textarea-field" placeholder="{{ trans('homepage.Message text') }}"
                              name="message"></textarea>
                    <button type="submit" class="send-form">{{ trans('homepage.Send a message') }}</button>
                </form>
            </div>
        </div>
        <div class="block-container block-part-2 social">
            <div class="title">{{ trans('homepage.Social networks') }}</div>
            <div class="mob-title">{{ trans('homepage.Contacts') }} </div>
            <div class="simple-text">
                <a href="https://www.facebook.com/my.artdealer.pro/" target="_blank">Facebook</a>
                <a href="https://www.instagram.com/artdealer.pro/" target="_blank">Instagram</a>
            </div>
            <div class="title">{{ trans('homepage.Our friends') }}</div>
            <div class="simple-text">
                <a href="http://www.archi.world" target="_blank">www.archi.world</a>
                <a href="http://www.radiofolder.com" target="_blank">www.radiofolder.com</a>
            </div>

            <div class="title">{{ trans('homepage.Phone') }}</div>
            <div class="simple-text">
                <a>+38 09 33 44 33 26</a>
            </div>

            <div class="title">
                <a id="footer_rules" data-dismiss="modal" data-toggle="modal" data-target="#registration-modal">Правила пользования</a>
            </div>
            <div class="simple-text"></div>

            <img src="{{URL::to('web/images/ui/icons_footer.png')}}">

        </div>
    </section>
</div>
