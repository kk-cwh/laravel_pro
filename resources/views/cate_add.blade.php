@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/cate" >分类列表</a>

        <caption>{{$data['title']}}</caption>
        <form class="form-horizontal" method="post" action="/home/cate">
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" placeholder="Name" name="name">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">添加</button>
                </div>
            </div>



        </form>



@stop