@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-md-10">
        <h1>修改服务器: {{$server->name}}</h1>
        <hr/>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('ucp.server.update',['id'=>$server->id]) }}" method = "post">
            {{ csrf_field() }}

            <div class="form-group">
                <label>地址:</label>
                <input name= "ip" type="text" class="form-control" id="ip" value="{{$server->ip}}" required>
            </div>
            <div class="form-group">
                <label>端口:</label>
                <input name= "port" type="number" class="form-control" id="port" value="{{$server->port}}" required>
            </div>
            <div class="form-group">
                <label>名称(当离线时使用):</label>
                <input name= "hostname" type="text" class="form-control" id="text" value="{{$server->name}}" required>
            </div>
            <div class="form-group">
                <label>模式(分类使用):</label>
                <input name= "gamemode" type="text" class="form-control" id="text" value="{{$server->gamemode}}" required>
            </div>
            <div class="form-group">
                <label>介绍(可选):</label>
                <textarea name= "description" type="text" class="form-control" id="text">
                {{$server->description}}
                </textarea>
            </div>
            
            
            <label>非公开:</label>
            @if($server->hide) <input type="checkbox" id="hide_ck" checked>
            @else <input type="checkbox" id="hide_ck">
            @endif

            

            <input type="hidden" name="hide" id="ck_cache" value="{{$server->hide}}"required>
           

            <button type="submit" class="btn btn-primary">添加</button>
        </form>

        </div>
    </div>
    
@endsection
