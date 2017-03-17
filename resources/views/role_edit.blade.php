@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/role">角色列表</a>

    <caption>{{$data['title']}}</caption>
    <form class="form-horizontal" action="/home/role/{{$data['roleInfo']->id}}" method="post">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="name" name="name"
                       value="{{$data['roleInfo']->name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">description</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="description" name="description"
                       value="{{$data['roleInfo']->description}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                @foreach ($data['accessList'] as $access)
                    <div class="checkbox">
                        <label>

                            @if( in_array($access->id,$data['roleAccessIds']))
                                <input type="checkbox" value="{{$access->id}}" name="accessId[]" checked>
                            @else
                                <input type="checkbox" value="{{$access->id}}" name="accessId[]" >
                            @endif
                            {{$access->title}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </div>
    </form>



@stop