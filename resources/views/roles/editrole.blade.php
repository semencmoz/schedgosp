@extends('roles')

@section('sidebar')
    <!--Правый сайдбар-->
    <div class="w3-sidebar w3-bar-block w3-border" style="width:25%;right:0">
        <h5 class="w3-bar-item">Действия</h5>
        <a href="/roles" class="w3-bar-item w3-button w3-hover-green">Вернуться к списку ролей</a>
    </div>
    <!--Правый сайдбар-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 aling="center">Изменить роль</h3>
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
            <form method="post" action="{{action('rolesController@update', $id)}}">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH"/>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" value="{{$role->name}}" placeholder="Введите название роли" />
                </div>
                <div class="form-group">
                    <input type="text" name="role_type" class="form-control" value="{{$role->role_type}}" placeholder="Введите тип роли" />
                </div>
                <div class="form-group">
                    <label for="dep_id">Выберите подразделение, которому будет прикреплена роль</label>
                    <select name="dep_id">
                        @foreach ($alldepts as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
@endsection