<section id="sub-nav-section" class="filter-section">
    <nav class="nav nav-inverse">
        <ul class="nav-bar list-inline">
            <li>
                <select title="тип" class="dropdown filter-select" name="type" data-default="{{\Request::is('picture*')?'0':'1'}}">
                    <option value="0" {{\Request::is('picture*')?'selected':''}}>Картина</option>
                    <option value="1" {{\Request::is('poster*')?'selected':''}}>Принт</option>
                    <option value="1" {{\Request::is('object*')?'selected':''}}>Предмет</option>
                    <option value="1" {{\Request::is('gallery*')?'selected':''}}>Галерея</option>
                </select>
            </li>
            <li>
                <select title="тип" class="dropdown filter-select" name="country" data-default="0">
                    <option value="0">Все страны</option>
                    <option value="1">Украина</option>
                    <option value="2">Британия</option>
                    <option value="3">Китай</option>

                </select>
            </li>

        </ul>
    </nav>
</section>