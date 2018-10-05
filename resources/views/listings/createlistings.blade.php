@extends('listings')

@section('sidebar')
    <!--Правый сайдбар-->
    <div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
        <h5 class="w3-bar-item">Действия</h5>
        <a href="/depts" class="w3-bar-item w3-button w3-hover-green">Вернуться к списку госпитализаций</a>
    </div>
    <!--Правый сайдбар-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 aling="center">Создать плановую госпитализацию</h3>
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
        <!--другая форма тип-->


            <form method="post" action="{{url('listings')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="dep_id">Выберите подразделение, в которое планируется госпитализация</label>
                    <select name="dep_id">
                        @foreach ($alldepts as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="patient_name" class="form-control" placeholder="Введите имя пациента" />
                </div>

                <div class="form-group">
                    <input type="tel" id="phone" name="phone"
                           placeholder="8 901-23-45-678"
                           pattern="[0-9]{1} [0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3}"
                           required />
                </div>

                <div class="form-group">
                    <label for="date_start">Дата планируемой госпитализации</label>
                    <input type="date" name="in_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
@endsection