@extends('listings')

@section('sidebar')
    <!--Правый сайдбар-->
    <div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
        <h5 class="w3-bar-item">Действия</h5>
        <a href="/listings/create" class="w3-bar-item w3-button w3-hover-green">Создать плановую госпитализацию</a>
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

    <h1>Список записей</h1>
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
        <td>Имя пациента</td>
        <td>Телефон</td>
        <td>Дата поступления</td>
        </thead>
        <tbody id="clearableListings">
        @foreach ($alllistings as $listing)
            <tr>
                <td>{{ $listing->dep_id }}</td>
                <td>{{ $listing->patient_name }}</td>
                <td>{{ $listing->phone }}</td>
                <td>{{ date("d.m.y", strtotime($listing->in_date)) }}</td>
                <td ><a  href="{{action('listingsController@edit', $listing->id)}}"><img src="" alt="редактировать"></a>
                    <form method="post" class="delete_form" action="{{action('listingsController@destroy', $listing->id)}}">
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
                if(confirm("Вы уверены, что хотите удалить госпитализацию?"))
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