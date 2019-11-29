<!--Card Product page-->
<div class="card-block {{$prevnext?'show-card-now':''}}">
<section id="card-menu">
    <div class="card-menu">
        <div class="header">
            <figure>
                @if($item->author->avatar&&$item->author->avatar!='')
                    <img class="{{$prevnext?'animated-wave-avatar':''}}" src="/web/images/avatars/{{$item->author->avatar}}"/>
                @else
                    <img class="{{$prevnext?'animated-wave-avatar':''}}" src="/web/images/ui/icon-default-avatar.svg"/>
                @endif
            </figure>
            <div class="about-user">
                <h5><a href="{{$item->author->profileURL()}}">{{$item->author->name}} {{$item->author->surname}}</a></h5>
                <p>{{$item->author->country}}</p>
            </div>
            <div class="button">
                <a href="{{$item->author->profileURL()}}" class="btn btn-blue">{{ trans('account.Profile') }}</a>
            </div>
        </div>
        <div class="check-card">
            <h3 class="title">
                @if($type=='object')
                    {{$item->name}}
                @else
                    Выбери параметры печати
                @endif
            </h3>
            <form class="form" name="form-card">
                @if($type=='poster')
                <p>
                    <label>Материал</label>
                    <select title="Материал" class="dropdown material-type">
                        <option value="0">Бумага 1</option>
                        <option value="1">Фотобумага</option>
                        <option value="2">Холст</option>
                    </select>
                </p>
                @endif
                <p>
                    <label>Размер</label>
                    <span><i>{{$item->width}}x{{$item->height}}@if(isset($item->depth))x{{$item->depth}}@endif мм</i></span>
                </p>
                @if($type=='object')
                    <p>
                        <label>Вес</label>
                        <span><i>@if(isset($item->weight)){{$item->weight}}@endif кг</i></span>
                    </p>
                @endif
                {{--
                <p>
                    <label>Багет</label>
                    <select title="Багет" class="dropdown">
                        <option value="0">Нет</option>
                        <option value="1">Белый мат</option>
                        <option value="2">Белый глянец</option>
                        <option value="3">Черный мат</option>
                        <option value="4">Черный глянец</option>
                    </select>
                </p>
                <p>
                    <label>Стекло</label>
                    <select title="Багет" class="dropdown">
                        <option value="1">Да</option>
                        <option value="0">Нет</option>
                    </select>
                </p>
                <div>
                    <p>
                        <label>Паспарту</label>
                        <select title="Багет" class="dropdown">
                            <option value="0">Нет</option>
                            <option value="1">1см</option>
                            <option value="2">2см</option>
                            <option value="3">3см</option>
                            <option value="4">4см</option>
                        </select>
                    </p>
                    <p class="pull-right">
                        <label>Цвет паспарту</label>
                        <select title="Багет" class="dropdown">
                            <option value="1">Белый</option>
                            <option value="2">Чёрный</option>
                            <option value="3">Зелёный</option>
                        </select>
                    </p>
                </div>
                --}}
            </form>
        </div>
        @if($type=='poster'||$type=='picture')
        <div class="item-colors">
            @foreach($item->colors as $color)
                <div class="{{($color->hex=='#ffffff')?'inh-gray-border':''}}" style="background-color: {{$color->hex}}"></div>
            @endforeach
        </div>
        @endif
        <div class="description {{$type=='object'?'object-descr':''}}">
            @if($type!='object')
            <h6>{{$item->name}}</h6>
            @endif
            <p>
                {{$item->description}}
            </p>


        </div>

        @if(count($item->tags))
        <div class="key-words">
            {{--<h6 class="keywords-title">Ключевые слова</h6>--}}
            <ul>
                @foreach($item->tags as $tag)
                    <li><a href="#" class="btn btn-regular">{{$tag->name}}</a></li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="buy-block">
        <div class="price">{{$item->price}}<span>USD</span></div>
        <div class="btn-buy pull-right">
            <a href="#" class="btn btn-green medium">Купить</a>
        </div>
    </div>
</section>
    
<section id="card-view">

    {{--
    <div class="like-it {{$item->liked?'liked':''}}">
        Like <i class="fa fa-heart" aria-hidden="true"></i>
    </div>
    <div class="zoom-icon" data-img="{{$item->id}}" data-type="{{$type}}">
        <img src="{{asset('/web/images/ui/zoom.svg')}}">
    </div>
    <div class="close close-product-overview">
        <img src="{{asset('/web/images/ui/close.svg')}}">
    </div>
    --}}

    <div class="card-left-block">

    </div>

    <div class="card-center-block">
        <div class="pic-wrap fade-item">
            <div class="image-item zoom-image product-frame" data-img="{{url('/file/'.$item->image_preview)}}" data-type="{{$type}}">
                {{--<img class="" id="product-image" src="{{url('/images/'.$type.'/preview/'.$item->id)}}">--}}
                <img id="product-image" src="{{url('/file/'.str_replace('.','_'.env('IMAGE_WIDTH_SHOW').'.', $item->image_preview))}}">
            </div>
        </div>
    </div>

    <div class="card-right-block">
        <div class="card-icon btn-icon-close">
            <img class="i-original" src="{{url('/web/images/ui/card/i-close.svg')}}"/>
            <img class="i-hover" src="{{url('/web/images/ui/card/i-close-hover.svg')}}"/>
        </div>
        <div class="card-icon btn-icon-zoom" data-img="{{url('/file/'.$item->image_preview)}}" data-type="{{$type}}">
            <img class="i-original" src="{{url('/web/images/ui/card/i-zoom.svg')}}"/>
            <img class="i-hover" src="{{url('/web/images/ui/card/i-zoom-hover.svg')}}"/>
        </div>
        <div class="card-icon btn-icon-like {{$item->liked?'it-liked':''}}">
            <img class="i-liked" src="{{url('/web/images/ui/card/i-liked.svg')}}"/>
            <img class="i-original" src="{{url('/web/images/ui/card/i-like.svg')}}"/>
            <img class="i-hover" src="{{url('/web/images/ui/card/i-like-hover.svg')}}"/>
        </div>

        @if($item->nextPrev['next']>0&&$item->nextPrev['prev']>0)
        <div class="card-icons-footer">
            <div class="card-icon show-next-prev-item btn-next-item" data-type="{{$type}}" data-target="{{$item->nextPrev['next']}}">
                <img class="i-original" src="{{url('/web/images/ui/card/i-go-right.svg')}}"/>
                <img class="i-hover" src="{{url('/web/images/ui/card/i-go-right-hover.svg')}}"/>
            </div>
            <div class="card-icon no-margin-bottom show-next-prev-item btn-prev-item" data-type="{{$type}}" data-target="{{$item->nextPrev['prev']}}">
                <img class="i-original" src="{{url('/web/images/ui/card/i-go-left.svg')}}"/>
                <img class="i-hover" src="{{url('/web/images/ui/card/i-go-left-hover.svg')}}"/>
            </div>
        </div>
        @endif

    </div>
</section>
</div>
<!--End Card product-->