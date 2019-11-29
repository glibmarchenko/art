<section id="subscription-navigation">
    <a  href="{{route('user.subscriptions.type','author')}}">
        <div {!!  !isset($isGallery) ? 'class="active"': '' !!}>{{ trans('homepage.Artists') }}</div>
    </a>
    <a  href="{{route('user.subscriptions.type','gallery')}}">
        <div {!!  isset($isGallery) ? 'class="active"': '' !!}>{{ trans('homepage.Galleries') }}</div>
    </a>
</section>
