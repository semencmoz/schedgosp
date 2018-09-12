@extends('depts')

@section('sidebar')
<!--Правый сайдбар-->
<div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
    <h5 class="w3-bar-item">Действия</h5>
    <a href="/depts" class="w3-bar-item w3-button w3-hover-green">Вернуться к списку подразделений</a>
</div>
<!--Правый сайдбар-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 aling="center">Создать подразделение</h3>
            <br />
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{url('depts')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Введите название подразделение" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
@endsection