<!--
https://www.webslesson.info/2018/01/insert-update-delete-in-mysql-table-laravel-tutorial.html
-->
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Управление квотами</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/css/main_dash.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/custom-filters.css') }}">
    <script type="text/javascript" src="{{asset('/js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/filters.js')}}"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<!--ТОП НАВБАР-->
<div class="topnav">
    <!--<a href="/depts">Авторизация</a>-->
    <a href="/roles">Роли</a>
    <a href="/depts">Подразделения</a>
    <a class="active" href="/quotas">Квоты на плановую госпитализацию</a>
    <a href="/listings">Плановые госпитализации</a>
</div>
<!--ТОП НАВБАР-->
@yield('sidebar')
<div class="container" style="margin-right:25%;margin-left: 15px;margin-top: 15px; padding-right:15px;">
    @yield('content')
</div>

</body>
</html>