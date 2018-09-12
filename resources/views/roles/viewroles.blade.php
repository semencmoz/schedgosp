@extends('roles')

@section('content')

    @if($success)
        <div class="alert alert-success">
            <p>{{$success}}</p>
        </div>
    @endif
    <h1>Все созданные до этого роли</h1>
    <table>
        <thead>
        <td>Название</td>
        <td>Тип роли</td>
        <td>Подразделение, привязанное к роли</td>
        </thead>
        <tbody>
        @foreach ($allroles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td class="inner-table">{{ $role->role_type }}</td>
                <td class="inner-table">{{ $role->dep_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection