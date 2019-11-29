<html>
<head>
    <style>
        div {
            text-align: center;
            font-family: Verdana;
            color: #23232D;
            text-align: center;
            padding: 26px 15px;
        }

        .title {
            font-size: 21px;
        }

        .link {
            font-size: 16px;
        }
    </style>
</head>

<body>
<div class="title">
    <h1>Получен новый заказ</h1>
    <p>Клиент: {{$order->buyer->full_name}}</p>
    @foreach ($order->products as $item)
        <div>
            <small>#{{$item->id}}</small>
            <h4 style="margin-bottom:5px;">{{$item->name}}</h4>
            <a href="{{$item->author->profile_url}}"
               target="_blank">{{$item->author->name}} {{$item->author->surname}}</a>
            <br>
            <br>
        </div>
    @endforeach
</div>

</body>
</html>
