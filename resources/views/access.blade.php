@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/access/create" >新增权限</a>
    <table class="table table-bordered">
        <caption>{{$data['title']}}</caption>
        <thead >
        <td class="active">ID</td>
        <td class="success">权限名称</td>
        <td class="success">权限URLs</td>
        <td class="danger">操作</td>
        </thead>
        @foreach ($data['accessList'] as $access)
            <tr class="success">
                <td class="active">{{$access->id}}</td>
                <td class="success">{{$access->title}}</td>
                <td class="success">{{$access->urls}}</td>
                <td class="danger"> <a href="/home/access/{{$access->id}}/edit" >编辑</a></td>
            </tr>
        @endforeach

    </table>
    <p>

    <div class="pull-right">    {{$data['accessList']->links()}}</div>
    </p>
@stop