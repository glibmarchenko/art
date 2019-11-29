<h4>#{{$order->uid}}</h4>
<small>{{$order->created_at->format('d-m-Y')}}</small>
@if($order->delivery_id !== '00000000000')
    <br>
    <small>{{$order->delivery_id}}</small>
@endif
<br>
<br>
<h5>Адресс</h5>
{{$order->delivery_country}}
{{$order->delivery_city}}
{{$order->delivery_street}}
{{$order->delivery_house}}
<br>
{{$order->delivery_name}}               {{$order->delivery_phone}}
<br>
<br>
@if($order->delivery_description)
    <h5>Примечание</h5>
    <small>{{$order->delivery_description}}</small>
@endif
