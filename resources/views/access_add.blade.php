@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/access" >权限列表</a>

        <caption>{{$data['title']}}</caption>
        <form class="form-horizontal" method="post" action="/home/access">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">权限名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="权限名称" name="title">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">URLS</label>
                <div class="col-sm-10">
                    <input type="textarea" class="form-control" id="inputName" placeholder="urls" name="urls">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">添加</button>
                </div>
            </div>



        </form>



@stop