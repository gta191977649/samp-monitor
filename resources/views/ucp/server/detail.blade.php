@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-md-10">
        <h1>{{ $server->name }} - 详细信息</h1>
        <hr/>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">基本信息</div>
                    
                        <table class="table">
                            <tbody>
                              
                                <tr>
                                    <td>服务器名:</td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td>地址:</td>
                                    <td>{{$server->ip}}:{{$server->port}}</td>
                                </tr>
                                <tr>
                                    <td>Ping(基于本机房):</td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td>玩家:</td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td>平均玩家:</td>
                                    <td>暂不可用</td>
                                </tr>
                                <tr>
                                    <td>最大玩家记录:</td>
                                    <td>暂不可用</td>
                                </tr>
                                <tr>
                                    <td>游戏模式:</td>
                                    <td>{{$server->gamemode}}</td>
                                </tr>
                                <tr>
                                    <td>评价:</td>
                                    <td>{{$server->rate}}</td>
                                </tr>
                            </tbody>
                        </table>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">在线玩家</div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>

            


        </div>
    </div>
    
@endsection