@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/role/create" >新增角色</a>
    <table class="table table-bordered">
        <caption>{{$data['title']}}</caption>
        <thead >
        <td class="active">id</td>
        <td class="success">角色名称</td>
        <td class="danger">操作</td>
        </thead>
        @foreach ($data['roleList'] as $role)
            <tr class="success">
                <td class="active">{{$role->id}}</td>
                <td class="success">{{$role->name}}</td>
                <td class="danger"> <a href="/home/role/{{$role->id}}/edit" >编辑</a></td>
            </tr>
        @endforeach

    </table>
    <p>
    <div class="pull-right">   {{$data['roleList']->links()}}</div>
    </p>
@stop