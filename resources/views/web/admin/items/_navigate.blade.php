<ul class="nav nav-pills mb-15">
    <li class="{{ \Request::is('systems/items/product/'.$type.'/filter/status/1*')  ? 'active' : '' }}">
        <a href="{{ route('admin.products.filter', ['type' => $type, 'status' => 1]) }}">Модерация</a>
    </li>
    <li class="{{ \Request::is('systems/items/product/'.$type.'/filter/status/3*') ? 'active' : '' }}">
        <a href="{{ route('admin.products.filter',  ['type' => $type, 'status' => 3]) }}">Профиль</a>
    </li>
    <li class="{{ \Request::is('systems/items/product/'.$type.'/filter/status/4*') ? 'active' : '' }}">
        <a href="{{ route('admin.products.filter',  ['type' => $type, 'status' => 4]) }}">Каталог</a>
    </li>
    <li class="{{ \Request::is('systems/items/product/'.$type.'/filter/status/5*') ? 'active' : '' }}">
        <a href="{{ route('admin.products.filter',  ['type' => $type, 'status' => 5]) }}">Топ</a>
    </li>
    <li class="{{ \Request::is('systems/items/product/'.$type.'/filter/status/2*') ? 'active' : '' }}">
        <a href="{{ route('admin.products.filter',  ['type' => $type, 'status' => 2]) }}">Отклоненные</a>
    </li>

    @if( $type == 2 )
        <li class="{{ \Request::is('systems/items/product/2/not_for_sale*') ? 'active' : '' }}">
            <a href="{{ route('admin.products.not_for_sale', $type) }}">Не для продажи</a>
        </li>

        <li class="{{ \Request::is('systems/items/product/2/sold*') ? 'active' : '' }}">
            <a href="{{ route('admin.products.sold', $type) }}">Проданные</a>
        </li>
    @endif

</ul>
