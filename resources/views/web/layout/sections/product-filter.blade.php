<section id="sub-nav-section" class="filter-section">
    <nav class="nav nav-inverse">
        <ul class="nav-bar list-inline">
            <li>
                <select title="тип" class="dropdown filter-select" name="type" data-default="{{\Request::is('picture*')?'0':'1'}}">
                    <option value="0" {{\Request::is('picture*')?'selected':''}}>Картина</option>
                    <option value="1" {{\Request::is('poster*')?'selected':''}}>Принт</option>
                    <option value="1" {{\Request::is('object*')?'selected':''}}>Предмет</option>
                </select>
            </li>
            <li>
                <select title="тип" class="dropdown filter-select" name="favorite">
                    <option value="0">Избранные</option>
                    <option value="1">Все работы</option>
                </select>
            </li>
            @if(!\Request::is('object*'))
                <li>
                    <select title="тип" class="dropdown filter-select" name="style">
                        <option value="0">Все стили</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <select title="Принт" class="dropdown filter-select" name="orientation">
                        <option value="0">Все ориентации</option>
                        <option value="vertikalno">Вертикальная</option>
                        <option value="gorizontalno">Горизонтальная</option>
                        <option value="kvadrat">Квадратная</option>
                    </select>
                </li>
            @endif

            <li>
                <select title="Принт" class="dropdown filter-select" name="size">
                    <option value="0">Все размеры</option>
                    <option value="s">S - до 50 см</option>
                    <option value="m">M - от 50 до 95 см</option>
                    <option value="l">L - от 95 до 150 см</option>
                    <option value="xl">XL - более 150 см</option>
                </select>
            </li>
            @if(!\Request::is('object*'))
                <li class="color-palette-li mf-color-item">
                    <div class="mf-name" data-placeholder="Цвет">Цвет</div>
                    <div class="mf-dot"></div>
                    <div class="mf-border-fix"></div>
                    <div class="mf-content mf-content-fullwidth ">
                        <div class="mf-palette-box">
                            <div class="reset-palette">Сбросить</div>
                            <div class="mf-palette">
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                                <div class="mf-color-box"></div>
                            </div>
                            <div class="mf-color-gradient">
                                <span class="cielch-demo"></span>
                            </div>
                            <!--
                            <div class="mf-color-gradient">
                                <div class="mf-gradient-bg"></div>
                                <div class="gradient-checker"></div>
                            </div>-->
                            <input type="hidden" class="full-color-input hsl-color" data-color-format="hsl"/>
                            <input type="hidden" class="full-color-input rgb-color" data-color-format="rgb"/>
                        </div>
                    </div>
                </li>
            @endif
            <li>
                <select title="Принт" name="price" class="dropdown filter-select">
                    @if(\Request::is('poster*'))
                        <option value="0">Все цены</option>
                        <option value="do-10">До 10$</option>
                        <option value="10-20">10$ - 20$</option>
                        <option value="20-50">20$ - 50$</option>
                        <option value="50-100">50$ - 100$</option>
                        <option value="ot-100">От 100$</option>
                    @elseif(\Request::is('picture*'))
                        <option value="0">Все цены</option>
                        <option value="do-500">До 500$</option>
                        <option value="500-1000">500$ - 1 000$</option>
                        <option value="1000-2000">1 000$ - 2 000$</option>
                        <option value="2000-5000">2 000$ - 5 000$</option>
                        <option value="5000-10000">5 000$ - 10 000$</option>
                        <option value="ot-10000">От 10 000$</option>
                    @elseif(\Request::is('object*'))
                        <option value="0">Все цены</option>
                        <option value="do-50">До 50$</option>
                        <option value="50-100">50$ - 100$</option>
                        <option value="100-500">100$ - 500$</option>
                        <option value="500-1000">500$ - 1 000$</option>
                        <option value="1000-2000">1 000$ - 2 000$</option>
                        <option value="ot-2000">От 2 000$</option>
                    @endif
                </select>
            </li>
        </ul>

        <ul class="nav-bar pull-right list-inline reset-filter-block">
            <li><a href="#" class="reset-filter">Сбросить</a></li>
        </ul>
    </nav>
</section>