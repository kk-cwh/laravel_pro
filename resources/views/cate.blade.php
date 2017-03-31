@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/cate/create" >新增分类</a>
    <table class="table table-bordered">
        <caption>{{$data['title']}}</caption>
        <thead >
        <td class="active">id</td>
        <td class="success">分类名称</td>
        <td class="danger">操作</td>
        </thead>
        @foreach ($data['cateList'] as $cate)
            <tr class="success">
                <td class="active">{{$cate->id}}</td>
                <td class="success">{{$cate->name}}</td>
                <td class="danger"> <a href="/home/cate/{{$cate->id}}/edit" >编辑</a></td>
            </tr>
        @endforeach

    </table>


    {{$data['cateList']->links()}}

@stop
