@extends('layout.layout')
@section('content')
    <table class="table table-bordered">
        <caption>{{$data['title']}}</caption>
        <tr class="active">
            <td class="active">...</td>
            <td class="success">...</td>
            <td class="warning">...</td>
            <td class="danger">...</td>
            <td class="info">...</td>
        </tr>
        <tr class="success">
            <td class="active">...</td>
            <td class="success">...</td>
            <td class="warning">...</td>
            <td class="danger">...</td>
            <td class="info">...</td>
        </tr>
        <tr class="warning">
            <td class="active">...</td>
            <td class="success">...</td>
            <td class="warning">...</td>
            <td class="danger">...</td>
            <td class="info">...</td>
        </tr>


    </table>
    <p>
        <image height="20" src="http://localhost:8000/home/" width="80">换一张</image>
        {{$data['content']}}
    </p>
@stop
