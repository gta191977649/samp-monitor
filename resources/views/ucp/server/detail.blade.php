@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-md-10"  id="sbmpDetail"  ng-controller="sbmpQueryController">
        <h1><% hostname %> - 详细信息</h1>
        <hr/>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">基本信息</div>
                    
                        <table class="table">
                            <tbody>
                              
                                <tr>
                                    <td>服务器名:</td>
                                    <td><% hostname %></td>
                                </tr>
                                <tr>
                                    <td>地址:</td>
                                    <td>{{$server->ip}}:{{$server->port}}</td>
                                </tr>
                                <tr>
                                    <td>状态:</td>
                                    <td><% status %></td>
                                </tr>
                                <tr>
                                    <td>Ping(基于本机房):</td>
                                    <td><% ping %></td>
                                </tr>
                                <tr>
                                    <td>玩家:</td>
                                    <td><% players %></td>
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
                                    <td><% gamemode %></td>
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
                    <table class="table">
                        <tbody>
                            <h3 class="text-center" ng-if="!playerlist.length">暂无玩家</h3>
                            <tr ng-if="playerlist.length">
                                <th>ID</th>
                                <th>昵称</th>
                                <th>分数</th>
                                <th>延迟</th>
                            </tr>
                            <tr ng-repeat="p in playerlist">
                                <td><% p.playerid %></td>
                                <td><% p.nickname %></td>
                                <td><% p.score %></td>
                                <td><% p.ping %></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            


        </div>
    </div>
    <!-- JS -->
    <script src="http://cdn.static.runoob.com/libs/angular.js/1.4.6/angular.min.js"></script>
    <script src="http://apps.bdimg.com/libs/angular-route/1.3.13/angular-route.js"></script>
    <script>    
        angular.module('statusQuery', [], function($interpolateProvider) {
            //解决该死的blade引擎和angularjs的syntax冲突
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        }).controller('sbmpQueryController', function($scope, $http,$interval) {
            
            
            $scope.getData = function(){ 
                $http.get("{{ route('api.info',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                    $scope.players = response.data.players  + "/" + response.data.maxplayers;
                    $scope.gamemode = response.data.gamemode;
                    $scope.hostname = response.data.hostname;
                    $scope.status = "在线";

                }, function myError(response) {
                    $scope.players = "获取失败";
                    $scope.gamemode = "{{$server->gamemode}}";
                    $scope.hostname = "{{$server->name}}"; //使用数据库里存储的服务器名称
                    $scope.status = "超时";
                    
                });

                //获取延迟
                $http.get("{{ route('api.ping',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                    $scope.ping = response.data + "ms";
                }, function myError(response) {
                    $scope.ping = "超时";
                });

                //获取玩家列表
                $http.get("{{ route('api.player.list',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                    $scope.playerlist = response.data;
                }, function myError(response) {
                    $scope.playerlist = "超时";
                });

            };
            $scope.getData();
            
            //实施刷新(不稳定)
            /*
            $interval(function() {
              $scope.getData();
            }, 1000);
            */

        });
        angular.bootstrap(document.getElementById("sbmpDetail"), ['statusQuery']);
        
    </script>


@endsection