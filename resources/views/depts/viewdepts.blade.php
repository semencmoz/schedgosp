@extends('depts')

@section('sidebar')
    <!--Правый сайдбар-->
    <div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
        <h5 class="w3-bar-item">Действия</h5>
        <a href="/depts/create" class="w3-bar-item w3-button w3-hover-green">Добавить новое подразделение</a>
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

    <h1>Список подразделений</h1>
    <table class="comicGreen">
        <thead>
        <td>Название Подразделения</td>
        <td>Действия с подразделением</td>
        </thead>
        <tbody>
        @foreach ($alldepts as $dept)
            <tr>
                <td>{{ $dept->name }}</td>
                <td ><a  href="{{action('deptsController@edit', $dept->id)}}"><img src="" alt="редактировать"></a>
                    <form method="post" class="delete_form" action="{{action('deptsController@destroy', $dept->id)}}">
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
                if(confirm("Вы уверены, что хотите удалить подразделение?"))
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