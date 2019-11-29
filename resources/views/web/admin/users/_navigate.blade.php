<ul class="nav nav-pills mb-15 admin-navigate-bar">
    <li class="bg-status-red {{ (\Request::is('systems/users/'.$type) || \Request::is('systems/users/'.$type.'/new*') ) ? 'active' : '' }}" data-class="bg-box-red">
        <a href="{{ route('admin.users.'.$type, 'new') }}" >Новые</a>
    </li>
    <li class="bg-status-green {{ \Request::is('systems/users/'.$type.'/accepted*') ? 'active' : '' }}" data-class="bg-box-green">
        <a href="{{ route('admin.users.'.$type, 'accepted') }}" >Проверенные</a>
    </li>
    <li class="bg-status-black {{ \Request::is('systems/users/'.$type.'/rejected*') ? 'active' : '' }}" data-class="bg-box-black">
        <a href="{{ route('admin.users.'.$type, 'rejected') }}">Отклонены</a>
    </li>
</ul>
