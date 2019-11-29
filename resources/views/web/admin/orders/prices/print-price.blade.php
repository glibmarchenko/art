@foreach ($order->products as $item)
    <div class="price-table-cell">
        <div class="content prices">
            <p>Печать - {{($item->prices->print_without_platform)}}
                <small>EUR</small>
            </p>
            <p>Автор - {{$item->prices->author}}
                <small>EUR</small>
            </p>
            <p>Платформа - {{$item->prices->platform_with_print }}
                <small>EUR</small>
            </p>
            <p>Доставка - {{$item->prices->delivery}}
                <small>EUR</small>
            </p>
            <p>Упаковка - {{$item->prices->packing}}
                <small>EUR</small>
            </p>
            <p class="bold">Итого
                - {{$item->prices->total}}
                <small>EUR</small>
            </p>
        </div>
    </div>
@endforeach
