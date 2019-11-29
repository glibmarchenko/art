<div class="{{ $order->paid ? ' active' : '' }}">Оплачено</div>

<a href="{{route('admin.order.state.prepared',$order)}}">
    <div class="{{ $order->prepared ? ' active' : '' }}">Подготовлено</div>
</a>

<a href="{{route('admin.order.state.produced',$order)}}">
    <div class="{{ $order->produced ? ' active' : '' }}">Напечатано</div>
</a>

<a href="{{route('admin.order.state.packed',$order)}}">
    <div class="{{ $order->packed ? ' active' : '' }}">Упаковано</div>
</a>

<div data-toggle="modal" data-target="#exampleModal"
     onclick="document.getElementById('order_id').value= '{{$order->id}}'"
     class="{{ $order->shipped ? ' active' : '' }}">Отправлено
</div>
<a href="{{route('admin.order.state.completed',$order)}}">
    <div class="{{ $order->completed ? ' active' : '' }}">Готово</div>
</a>

<br>

<a href="{{route('admin.order.delete',$order)}}">
    <div class="danger">Удалить</div>
</a>

