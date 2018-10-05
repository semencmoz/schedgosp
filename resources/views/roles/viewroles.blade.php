
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
                <td ><a  href="{{action('rolesController@edit', $role->id)}}"><img class="edtblt" src="/images/edit.png" alt="редактировать"></a>
                    <form method="post" class="delete_form" action="{{action('rolesController@destroy', $role->id)}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE" />
                        <input class="edtblt" type="image" src="/images/delete.png" alt="Submit">
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