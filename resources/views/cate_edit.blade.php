@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/cate">分类列表</a>

    <caption>{{$data['title']}}</caption>
    <form class="form-horizontal" action="/home/cate/{{$data['cate']->id}}" method="post">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="name" name="name"
                       value="{{$data['cate']->name}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </div>
    </form>



@stop