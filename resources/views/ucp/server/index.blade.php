@extends('layouts.app')

@section('content')
    
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-md-10">
        
        <h1>我的服务器</h1>
        <hr/>
    
        <a style="margin-bottom:15px;" href="{{route('ucp.server.add')}}" class="btn btn-primary">添加服务器</a>
    
    @if(!$servers->count())
        <div class="panel panel-default">
        <div class="panel-heading">提示</div>
        <div class="panel-body">
            目前没数据!
        </div>
        </div>
    @else
        <table id="dataTable" class="table table-bordered border-radius">

        <tbody>
        <tr>
            <th>服务器</th>
            <th>地址</th>
            <th>模式</th>
            <th>玩家</th>
            <th>状态</th>
            <th>公开<a href="#" data-toggle="tooltip" data-placement="top" title="你可以设置你的服务器是否推送在首页上于其他人共享">?</a></th>
            <th>管理</th>
        </tr>
    @endif
    <script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
    <script src="http://apps.bdimg.com/libs/angular-route/1.3.13/angular-route.js"></script>
    @foreach($servers as $server)
	<tr id="App{{$server->id}}"  ng-controller="customersCtrl{{$server->id}}">
        <td><p><a href="{{ route('ucp.server.detail',['id'=> $server->id]) }}"><img src="{{ asset('css/samp.gif') }}" alt="" border="0"> <% hostname %>  </a></p></td>
	    <td>{{ $server->ip }}:{{ $server->port }}</td>
	    <td><% gamemode %></td>
	    <td><% players %></td>
	    <td><% status %></td>
	    <td>{{ $server->hide ? "非公开" : "公开"}}</td>
	    <td>
             <a class="text-primary" href="{{route('ucp.server.edit',['id' => $server->id])}}"><i class="fa fa-pencil" aria-hidden="true"></i>修改</a>
            <a class="text-danger" href="{{route('ucp.server.del',['id' => $server->id])}}"><i class="fa fa-trash" aria-hidden="true"></i>删除</a>
        </td>
	</tr>
    <script>
        angular.module('statusQuery{{$server->id}}', [], function($interpolateProvider) {
            //解决该死的blade引擎和angularjs的syntax冲突
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        }).controller('customersCtrl{{$server->id}}', function($scope, $http) {
            $http.get("{{ route('api.info',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                $scope.players = response.data.players + "/" + response.data.maxplayers;
                $scope.gamemode = response.data.gamemode;
                $scope.hostname = response.data.hostname;
                $scope.status = "在线";

            }, function myError(response) {
                $scope.players = "获取失败";
                $scope.gamemode = "{{$server->gamemode}}";
                $scope.hostname = "{{$server->name}}"; //使用数据库里存储的服务器名称
                $scope.status = "超时";
                
            });
            
        });
        angular.bootstrap(document.getElementById("App{{$server->id}}"), ['statusQuery{{$server->id}}']);

        
    </script>

    @endforeach

	</tbody></table>

            
        </div>
    </div>
   
    
@endsection

@section('js')


@endsection