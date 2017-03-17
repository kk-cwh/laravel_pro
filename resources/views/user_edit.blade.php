@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/user">用户列表</a>

    <caption>{{$data['title']}}</caption>
    <form class="form-horizontal" action="/home/user/{{$data['userInfo']->id}}" method="post">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="name" name="name"
                       value="{{$data['userInfo']->name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email"
                       value="{{$data['userInfo']->email}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                @foreach ($data['roles'] as $role)
                    <div class="checkbox">
                        <label>

                            @if( in_array($role->id,$data['userRoleIds']))
                                <input type="checkbox" value="{{$role->id}}" name="roleId[]" checked>
                            @else
                                <input type="checkbox" value="{{$role->id}}" name="roleId[]" >
                            @endif
                            {{$role->name}}
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