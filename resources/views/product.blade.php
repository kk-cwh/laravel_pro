@extends('layout.layout')
@section('content')
    <a type="button" class="btn btn-success pull-right" href="/home/product/create" >新增商品</a>
    <table class="table table-bordered">
        <caption>{{$data['title']}}</caption>
        <thead >
        <td class="active">id</td>
        <td class="success">商品名称</td>
        <td class="success">类别</td>
        <td class="success">商品价格</td>
        <td class="success">是否上架</td>
        <td class="danger">操作</td>
        </thead>
        @foreach ($data['productList'] as $product)
            <tr class="success">
                <td class="active">{{$product->id}}</td>
                <td class="success">{{$product->name}}</td>
                <td class="success">{{$product->cateName}}</td>
                <td class="success">{{$product->price}}</td>
                <td class="success">{{$product->onSale ? 'yes':'no'}}</td>
                <td class="danger"> <a href="/home/product/{{$product->id}}/edit" >编辑</a></td>
            </tr>
        @endforeach

    </table>
    <div class="pull-right">  {{$data['productList']->links()}} </div>


@stop