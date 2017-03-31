@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/product" >商品列表</a>

        <caption>{{$data['title']}}</caption>
        <form class="form-horizontal" method="post" action="/home/product" enctype="multipart/form-data">
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">商品名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" placeholder="Name" name="name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">商品价格</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="inputEmail3" placeholder="price" name="price">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">商品类别</label>
                <div class="col-sm-3  col-md-3 col-lg-2">

                    <select  class="form-control" name="cateId">
                        @foreach ($data['cateList'] as $cate)
                            <label>
                                    <option  value="{{$cate->id}}" > {{$cate->name}}</option>
                            </label>
                        @endforeach
                    </select >

                </div>
                </label>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">是否上架</label>
                <div class="col-sm-offset-2 col-sm-10">
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

                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputFile" class="col-sm-2 control-label">商品图片</label>
                <input type="file" id="exampleInputFile" name="images[]">
                <input type="file" id="exampleInputFile" name="images[]">
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">添加</button>
                </div>
            </div>



        </form>



@stop