@extends('layouts.app')

@section('content')
    <h1>服務器一覽</h1>

	
    @if(!$servers->count())
        <div class="panel panel-default">
        <div class="panel-heading">提示</div>
        <div class="panel-body">
            目前没数据!
        </div>
        </div>
    @else
    <div class="table-responsive">    
        <table class="table table-bordered border-radius">

        <tbody>
        <tr>
            <th>服务器</th>
            <th>地址</th>
            <th>模式</th>
            <th>玩家</th>
            <th>状态</th>
        </tr>
    @endif
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    @foreach($servers as $server)
	<tr id="App{{$server->id}}"  ng-controller="customersCtrl{{$server->id}}">
        <td><p><a href="{{route('server.detail',['id' => $server->id])}}"><img src="{{ asset('css/samp.gif') }}" alt="" border="0"> <% hostname.isValid ? "{{$server->hostname}}" : hostname  %>  </a></p></td>
	    <td>{{ $server->ip }}:{{ $server->port }}</td>
	    <td><% gamemode.isValid ? "{{$server->gamemode}}" : gamemode %></td>
	    <td><% players.isValid ? "超时" : players  %></td>
	    <td><% status %></td>
	</tr>
    <script>
        angular.module('statusQuery{{$server->id}}', [], function($interpolateProvider) {
            //解决该死的blade引擎和angularjs的syntax冲突
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        }).controller('customersCtrl{{$server->id}}', function($scope, $http) {
            $scope.hostname = "{{$server->name}}"; //使用数据库里存储的服务器名称
            $scope.gamemode ="{{$server->gamemode}}";

            $http.get("{{ route('api.info',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                
                if(response.data != "-1")
                {
                    $scope.players = response.data.players + "/" + response.data.maxplayers;
                    $scope.gamemode = response.data.gamemode;
                    $scope.hostname = response.data.hostname;
                    $scope.status = "在线";
                }
                else
                {
                    $scope.players = "超时" ;
                    $scope.gamemode = "{{$server->gamemode}}";
                    $scope.hostname = "{{$server->name}}"; //使用数据库里存储的服务器名称
                    $scope.status = "超时";
                
                }

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

	</tbody>
    </table>
    </div>
@endsection

