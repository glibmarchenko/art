<html>
<head>
<style>
    div{
        text-align: center;
        font-family: Verdana;
        color: #23232D;
        text-align: center;
        padding: 26px 15px;
    }
    .title{
        font-size: 21px;
    }
    .link{
        font-size: 16px;
    }
</style>
</head>

<body>
    <div class="title">
        Поздравляем, вы успешно зарегистрированы на сервисе ArtDealer.
    </div>
    <div class="link">
        Перейдите по ссылке:<br><a href="{{route('user.activate',$token)}}">{{url('/')}}</a>
    </div>

</body>
</html>
