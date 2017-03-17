@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/role" >角色列表</a>

        <caption>{{$data['title']}}</caption>
        <form class="form-horizontal" method="post" action="/home/role">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="name" name="name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">description</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" placeholder="description" name="description">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    @foreach ($data['accessList'] as $access)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="{{$access->id}}" name="accessId[]">
                                {{$access->title}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">添加</button>
                </div>
            </div>



        </form>



@stop