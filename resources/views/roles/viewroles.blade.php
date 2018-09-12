@extends('roles')

@section('sidebar')
    <!--Правый сайдбар-->
    <div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
        <h5 class="w3-bar-item">Действия</h5>
        <a href="/roles/create" class="w3-bar-item w3-button w3-hover-green">Добавить новую роль</a>
    </div>
    <!--Правый сайдбар-->
@endsection

@section('content')

    @if(isset($success))
        <div class="alert alert-success">
            <p>{{$success}}</p>
        </div>
    @endif
    <style>
        table.comicGreen {
            font-family: Georgia, serif;
            border: 2px solid #4F7849;
            background-color: #EEEEEE;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }
        table.comicGreen td, table.comicGreen th {
            border: 1px solid #4F7849;
            padding: 3px 2px;
        }
        table.comicGreen tbody td {
            font-size: 19px;
            font-weight: bold;
            color: #4F7849;
        }
        table.comicGreen tr:nth-child(even) {
            background: #CEE0CC;
        }
        table.comicGreen tfoot {
            font-size: 21px;
            font-weight: bold;
            color: #FFFFFF;
            background: #4F7849;
            background: -moz-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
            background: -webkit-linear-gradient(top, #7b9a76 0%, #60855b 66%, #4F7849 100%);
            background: linear-gradient(to bottom, #7b9a76 0%, #60855b 66%, #4F7849 100%);
            border-top: 1px solid #444444;
        }
        table.comicGreen tfoot td {
            font-size: 21px;
        }
    </style>
    <h1>Список созданных ролей</h1>
    <table class="comicGreen">
        <thead>
        <td>id</td>
        <td>Название</td>
        <td>Тип роли</td>
        <td>Подразделение, привязанное к роли</td>
        </thead>
        <tbody>
        @foreach ($allroles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td class="inner-table">{{ $role->role_type }}</td>
                <td class="inner-table">{{ $role->dep_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection