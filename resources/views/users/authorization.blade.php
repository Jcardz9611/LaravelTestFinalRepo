@extends('layouts.app')
@section('content')
<table class="table table-sm">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        
            
            @foreach($users as $user)
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{route('users.authForm', $user->id)}}" class="btn btn-warning">Authorization & role</a>
            </td>
            @endforeach
         
    </tbody>
</table>
@endsection