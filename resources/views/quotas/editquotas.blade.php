@extends('quotas')

@section('sidebar')
    <!--Правый сайдбар-->
    <div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
        <h5 class="w3-bar-item">Действия</h5>
        <a href="/depts" class="w3-bar-item w3-button w3-hover-green">Вернуться к списку квот</a>
    </div>
    <!--Правый сайдбар-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 aling="center">Изменить квоты</h3>
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
            <form method="post" action="{{action('quotasController@update', $id)}}">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH"/>
                <div class="form-group">
                    <label for="dep_id">Выберите подразделение, которому будет назначена квота</label>
                    <select name="dep_id">
                        @foreach ($alldepts as $dept)
                            <option value="{{ $dept->id }}"
                                @if ($dept->name == $quota->dep_id)
                                     selected="selected"
                                @endif
                            >{{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" name="qtty" class="form-control" placeholder="Введите количество" value="{{$quota->qtty}}"/>
                </div>

                <div class="form-group">
                    <label for="date_start">Дата</label>
                    <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d',strtotime($quota->date)); ?>" />
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
@endsection