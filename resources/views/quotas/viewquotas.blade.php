@extends('quotas')

@section('sidebar')
    <!--Правый сайдбар-->
    <div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
        <h5 class="w3-bar-item">Действия</h5>
        <a href="/quotas/create" class="w3-bar-item w3-button w3-hover-green">Создать квоту</a>
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

    <h1>Квоты</h1>
    <div id="filters">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <select id="deptid" name="dep_id">
            @foreach ($alldepts as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
            @endforeach
        </select>
        <div id="calendar1-wrapper1"></div>

    </div>

    <script type="application/javascript" defer="defer">
        $(document).ready(initDatePicker());
    </script>
    <table class="comicGreen">
        <thead>
        <td>Подразделение</td>
        <td>Количество мест</td>
        <td>Количество мест занято</td>
        <td>Дата</td>
        <td>Действия с квотой</td>
        </thead>
        <tbody id="clearableQuotas">
        @foreach ($allquotas as $quota)
            <tr>
                <td>{{ $quota->dep_id }}</td>
                <td>{{ $quota->qtty }}</td>
                <td>{{ $quota->qttyused }}</td>
                <td>{{ date("d.m.y", strtotime($quota->date)) }}</td>
                <td ><a  href="{{action('quotasController@edit', $quota->id)}}"><img class="edtblt" src="/images/edit.png" alt="редактировать"></a>
                    <form method="post" class="delete_form" action="{{action('quotasController@destroy', $quota->id)}}">
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
                if(confirm("Вы уверены, что хотите удалить квоту?"))
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