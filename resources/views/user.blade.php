@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/user/create" >新增用户</a>
    <table class="table table-bordered">
        <caption>{{$data['title']}}</caption>
        <thead >
        <td class="active">id</td>
        <td class="success">用户名</td>
        <td class="warning">邮箱</td>
        <td class="danger">操作</td>
        </thead>
        @foreach ($data['userList'] as $user)
            <tr class="success">
                <td class="active">{{$user->id}}</td>
                <td class="success">{{$user->name}}</td>
                <td class="warning">{{$user->email}}</td>
                <td class="danger"> <a href="/home/user/{{$user->id}}/edit" >编辑</a></td>
            </tr>
        @endforeach

    </table>
    <p>

    </p>
@stop