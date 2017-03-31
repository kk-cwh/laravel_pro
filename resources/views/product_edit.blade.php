@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/product">商品列表</a>

    <caption>{{$data['title']}}</caption>
    <form class="form-horizontal" action="/home/product/{{$data['product']->id}}" method="post">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 col-md-3 col-lg-2 control-label">商品名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="name" name="name"
                       value="{{$data['product']->name}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 col-md-3 col-lg-2 control-label">价格</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="inputEmail3" placeholder="Email" name="price"
                       value="{{$data['product']->price}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品类别</label>
            <div class="col-sm-3  col-md-3 col-lg-2">

                <select class="form-control" name="cateId">
                    @foreach ($data['cateList'] as $cate)
                        <label>
                            @if($cate->id==$data['product']->cateId)
                                <option value="{{$cate->id}}" selected> {{$cate->name}}</option>
                            @else
                                <option value="{{$cate->id}}"> {{$cate->name}}</option>
                            @endif

                        </label>
                    @endforeach
                </select>

            </div>

        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">是否上架</label>
            <div class="col-sm-offset-2 col-sm-10">
                @if($data['product']->onSale)
                    <div class="radio">
                        <label>
                            <input type="radio" value="1" name="onSale" checked>是
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" value="0" name="onSale">否
                        </label>
                    </div>
                @else
                    <div class="radio">
                        <label>
                            <input type="radio" value="1" name="onSale" >是
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" value="0" name="onSale" checked>否
                        </label>
                    </div>
                @endif
            </div>
        </div>
        @foreach ($data['albumList'] as $album)

            <img src="{{$album->urlStr}}" height="150" width="150" name="{{$album->id}}">

        @endforeach

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </div>
    </form>



@stop