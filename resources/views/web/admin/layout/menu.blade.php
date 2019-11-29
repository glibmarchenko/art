<!-- Main Sidebar start-->
<aside class="main-sidebar">

    <ul class="list-unstyled navigation mb-0">
        <li class="panel"><a href="{{ route('admin.dashboard') }}"
                             class="{{\Request::is('systems/dashboard*')?'active':''}}"><i class="ti-home"></i><span
                        class="sidebar-title">Главная</span></a></li>

        <li class="panel">
            <a role="button" data-toggle="collapse" data-parent=".navigation"
               href="#users" aria-expanded="{{\Request::is('systems/users*')?'true':'false'}}" aria-controls="users"
               class=" {{\Request::is('systems/users*')?'active':''}}">
                <i class="ti-user"></i><span class="sidebar-title">Пользователи</span>
            </a>
            <ul id="users" class="list-unstyled collapse {{\Request::is('systems/users*')?'in':''}}">
                <li><a href="{{ route('admin.users.common') }}"
                       class="{{\Request::is('systems/users/common*')?'active':''}}">Ценитель</a></li>
                <li><a href="{{ route('admin.users.artist') }}"
                       class="{{\Request::is('systems/users/artist*')?'active':''}}">Художник</a></li>
                <li><a href="{{ route('admin.users.gallery') }}"
                       class="{{\Request::is('systems/users/gallery*')?'active':''}}">Галерея</a></li>
            </ul>
        </li>

        <li class="panel">
            <a role="button" data-toggle="collapse" data-parent=".navigation"
               href="#items" aria-expanded="{{\Request::is('systems/items*')?'true':'false'}}" aria-controls="items"
               class=" {{\Request::is('systems/items*')?'active':''}}">
                <i class="ti-bookmark-alt"></i><span class="sidebar-title">Работы</span>
            </a>
            <ul id="items" class="list-unstyled collapse {{\Request::is('systems/items*')?'in':''}}">
                <li><a href="{{ route('admin.products.index','1') }}"
                       class="{{\Request::is('systems/items/posters*')?'active':''}}">Принты</a>
                </li>
                <li><a href="{{ route('admin.products.index','2') }}"
                       class="{{\Request::is('systems/items/pictures*')?'active':''}}">Картины</a>
                </li>
                <li><a href="{{ route('admin.products.index','3') }}"
                       class="{{\Request::is('systems/items/objects*')?'active':''}}">Предметы</a>
                </li>
            </ul>
        </li>

        <li class="panel">
            <a role="button" data-toggle="collapse" data-parent=".navigation"
               href="#orders" aria-expanded="{{\Request::is('systems/orders*')?'true':'false'}}" aria-controls="orders"
               class="{{\Request::is('systems/orders*')?'active':''}}">
                <i class="ti-shopping-cart-full"></i><span class="sidebar-title">Заказы</span>
            </a>
            <ul id="orders" class="list-unstyled collapse {{\Request::is('systems/orders*')?'in':''}}">
                <li><a href="{{route('admin.orders') }}"
                       class="{{\Request::is('systems/orders/new*')?'active':''}}">Принты</a>
                </li>
                <li><a href="{{route('admin.orders.pictures') }}"
                       class="{{\Request::is('systems/orders/in-progress*')?'active':''}}">Картины</a>
                </li>
                {{--<li><a href="{{ route('admin.orders.objects') }}"--}}
                       {{--class="{{\Request::is('systems/orders/completed*')?'active':''}}">Предметы</a>--}}
                {{--</li>--}}
            </ul>
        </li>


        <li class="panel"><a href="{{ route('admin.commissions') }}"
                             class="{{\Request::is('systems/commissions*')?'active':''}}"><i class="ti-medall"></i><span
                        class="sidebar-title">Коммиссии</span></a></li>

        <li class="panel">
            <a role="button" data-toggle="collapse" data-parent=".navigation"
               href="#finance" aria-expanded="{{\Request::is('systems/orders*')?'true':'false'}}"
               aria-controls="finance"
               class="{{\Request::is('systems/orders*')?'active':''}}">
                <i class="ti-money"></i><span class="sidebar-title">Финансы</span>
            </a>
            <ul id="finance" class="list-unstyled collapse {{\Request::is('systems/finance*')?'in':''}}">
                <li><a href="{{ route('admin.finance.settings') }}"
                       class="{{\Request::is('systems/finance/settings*')?'active':''}}">Настройки</a></li>
            </ul>
        </li>

        <li class="panel"><a href="{{ route('admin.delivery') }}"
                             class="{{\Request::is('systems/delivery*')?'active':''}}"><i class="ti-truck"></i><span
                        class="sidebar-title">Доставка</span></a></li>
        <li class="panel"><a href="{{ route('admin.printing') }}"
                             class="{{\Request::is('systems/printing*')?'active':''}}"><i class="ti-printer"></i><span
                        class="sidebar-title">Печать</span></a></li>

    </ul>

</aside>
