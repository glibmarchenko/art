<div class="{{ $order->paid ? ' active' : '' }}">Заморожено</div>

@if(!$order->reserved)
    <a href="{{route('admin.order.state.reserved',$order)}}">
        <div class="{{ $order->available ? ' active' : '' }}">Доступно</div>
    </a>

    <a href="{{route('admin.order.state.cancelled',$order)}}">
        <div class="{{ $order->available ? ' active' : '' }}">Не доступно</div>
    </a>
@endif

@if($order->reserved)
    <a href="{{route('admin.order.state.reserved',$order)}}">
        <div class="{{ $order->available ? ' active' : '' }}">Зарезервировано</div>
    </a>
@endif

<div data-toggle="modal" data-target="#exampleModal"
     onclick="document.getElementById('order_id').value= '{{$order->id}}'"
     class="{{ $order->shipped ? ' active' : '' }}">Отправлено
</div>
<a href="{{route('admin.order.state.completed',$order)}}">
    <div class="{{ $order->completed ? ' active' : '' }}">Готово</div>
</a>
