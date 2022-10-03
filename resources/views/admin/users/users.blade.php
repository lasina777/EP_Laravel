@extends('welcome')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-6">
                @include('breadcrumb', $breadcrumbs)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">login</th>
                        <th scope="col">email</th>
                        <th scope="col">fullname</th>
                        <th scope="col">password</th>
                        <th scope="col">address</th>
                        <th scope="col">role</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->login}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->fullname}}</td>
                            <td>-</td>
                            <td>{{$user->address}}</td>
                            <td>{{$user->role}}</td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="7">В системе нет пользователей</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection
