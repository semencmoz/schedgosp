
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
        <div class="alert alert-success" style="background-color: #38c172;
        border: 1px; margin: 10px; padding: 5px; font-style: oblique;
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000,-1px 1px 0 #000, 1px 1px 0 #000;">
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
        <td>Название</td>
        <td>Тип роли</td>
        <td>Подразделение, привязанное к роли</td>
        <td>Действия с ролью</td>
        </thead>
        <tbody>
        @foreach ($allroles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td class="inner-table">{{ $role->role_type }}</td>
                <td class="inner-table">{{ $role->dep_id }}</td>
                <td ><a  href="{{action('rolesController@edit', $role->id)}}"><img src="" alt="редактировать"></a>
                    <form method="post" class="delete_form" action="{{action('rolesController@destroy', $role->id)}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <button type="submit">Удалить</button>
                    </form></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function(){
            $('.delete_form').on('submit', function(){
                if(confirm("Вы уверены, что хотите удалить эту роль?"))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            });
        });
    </script>
@endsection