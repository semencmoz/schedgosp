@extends('roles')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 aling="center">Создать роль</h3>
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
            <form method="post" action="{{url('roles')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Введите название роли" />
                </div>
                <div class="form-group">
                    <input type="text" name="role_type" class="form-control" placeholder="Введите тип роли" />
                </div>
                <div class="form-group">
                    <input type="number" name="dep_id" class="form-control" placeholder="id подразделения" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
@endsection