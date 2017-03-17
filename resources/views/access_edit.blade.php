@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/access">权限列表</a>

    <caption>{{$data['title']}}</caption>
    <form class="form-horizontal" action="/home/access/{{$data['accessInfo']->id}}" method="post">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">权限名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="权限名称" name="title"
                       value="{{$data['accessInfo']->title}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">URLS</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="urls" name="urls"
                       value="{{$data['accessInfo']->urls}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </div>
    </form>



@stop