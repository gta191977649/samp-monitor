@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        @if(Auth::guest())
            <div class="col-md-12"  id="sbmpDetail"  ng-controller="sbmpQueryController">
        @else
            <div class="col-md-10"  id="sbmpDetail"  ng-controller="sbmpQueryController">
        @endif
        <h1><% hostname.isValid ? "{{$server->hostname}}" : hostname %> - 详细信息</h1>
        <hr/>
        <div class="col-md-12" style="margin-bottom:10px;">
            <a href="samp://{{$server->ip}}:{{$server->port}}" class="btn btn-success"><i class="fa fa-gamepad" aria-hidden="true"></i>
        进去玩</a>
            <a href="http://ping.chinaz.com/{{$server->ip}}" target="_blank" class="btn btn-info"><i class="fa fa-globe" aria-hidden="true"></i>
        测试各地延迟</a>
        </div>
        
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">基本信息</div>
                    
                        <table class="table">
                            <tbody>
                              
                                <tr>
                                    <td>服务器名:</td>
                                    <td><% hostname.isValid ? "{{$server->hostname}}" : hostname %></td>
                                </tr>
                                <tr>
                                    <td>地址:</td>
                                    <td>{{$server->ip}}:{{$server->port}}
                                    <img src="https://ipfind.co/flag?ip={{$server->ip}}&auth=05a106a4-0d26-4a2f-8f1e-b606f7affa2d" width="25" height="25">
                                    </td>
                                </tr>
                                <tr>
                                    <td>状态:</td>
                                    <td><% status %></td>
                                </tr>
                                <tr>
                                    <td>Ping (基于本机房):</td>
                                    <td><% ping %></td>
                                </tr>
                                <tr>
                                    <td>Ping 平均(基于本机房):</td>
                                    <td>{{$server->status->count() ? round($server->status->avg('ping'))."ms" : "暂无统计"}}</td>
                                </tr>
                                <tr>
                                    <td>玩家:</td>
                                    <td><% players %></td>
                                </tr>
                                <tr>
                                    <td>平均玩家:</td>
                                    <td>{{$server->status->count() ? round($server->status->avg('player')) : "暂无统计"}}</td>
                                </tr>
                                <tr>
                                    <td>最大玩家记录:</td>
                                    <td>{{$server->status->count() ? $server->status->max('player') : "暂无统计"}}</td>
                                </tr>
                                <tr>
                                    <td>游戏模式:</td>
                                    <td><% gamemode.isValid ? "{{$server->gamemode}}" : gamemode %></td>
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

            @if($server->status->count())
            <!-- 统计图 玩家数 -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">统计 - 玩家 <span class="label label-success">{{$server->status()->select('created_at')->orderBy('created_at', 'desc')->first()->created_at->format('Y-m-d')}}</span></div>
                    @if($server->status->count())
                        <canvas id="sbmpPlayers" width="100%" height="20"></canvas>
                    @else
                        <h3 class="text-center" ng-if="!playerlist.length">暂无数据</h3>
                    @endif
                </div>
            </div>
            
            <!-- 统计图 Ping -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">统计 - Ping <span class="label label-success">{{$server->status()->select('created_at')->orderBy('created_at', 'desc')->first()->created_at->format('Y-m-d')}}</span></div>
                    @if($server->status->count())
                        <canvas id="sbmpPing" width="100%" height="20"></canvas>
                    @else
                        <h3 class="text-center" ng-if="!playerlist.length">暂无数据</h3>
                    @endif
                </div>
            </div>
            @else
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">统计</span></div>
                    <h3 class="text-center" ng-if="!playerlist.length">暂无数据</h3>
                </div>
            </div>
            @endif
        </div>
    </div>
  
@endsection

@section('js')
    <!-- JS -->
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    <script>    
        angular.module('statusQuery', [], function($interpolateProvider) {
            //解决该死的blade引擎和angularjs的syntax冲突
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        }).controller('sbmpQueryController', function($scope, $http,$interval) {
            $scope.hostname = "{{$server->name}}"; //使用数据库里存储的服务器名称
            $scope.gamemode ="{{$server->gamemode}}";
            
            $scope.getData = function(){ 
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

                //获取延迟
                $http.get("{{ route('api.ping',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                    if(response.data != -1)
                    {
                        $scope.ping = response.data + "ms";
                    }
                    else
                    {
                        $scope.ping = "超时";
                    }
                   

                }, function myError(response) {
                    $scope.ping = "超时";
                });

                //获取玩家列表
                $http.get("{{ route('api.player.list',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                    if(response.data != -1) $scope.playerlist = response.data;
                    else $scope.playerlist = 0;
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
    <!--图表的JS -->
    <!--图表 玩家 -->
    <!-- SELECT * FROM `status` WHERE DATE(`created_at`)=CURDATE() -->
    <script>
        var ctx = document.getElementById("sbmpPlayers").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($server->status()->whereDate('created_at', DB::raw('CURDATE()'))->get() as $s)
                        "{{$s->created_at->format('g:i A')}}",
                    @endforeach
                ],
                datasets: [{
                    label: '玩家数',
                    data: [
                        @foreach ($server->status()->whereDate('created_at', DB::raw('CURDATE()'))->get() as $s)
                        {{$s->player}},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(41, 128, 185,0)',
                    ],
                    borderColor: [
                        'rgba(41, 128, 185,255)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
    <!--图表 Ping -->
    <script>
        var ctx = document.getElementById("sbmpPing").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($server->status()->whereDate('created_at', DB::raw('CURDATE()'))->get() as $s)
                        "{{$s->created_at->format('g:i A')}}",
                    @endforeach
                ],
                datasets: [{
                    label: '延迟',
                    data: [
                        @foreach ($server->status()->whereDate('created_at', DB::raw('CURDATE()'))->get() as $s)
                        {{$s->ping}},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(41, 128, 185,0)',
                    ],
                    borderColor: [
                        'rgba(41, 128, 185,255)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
@endsection