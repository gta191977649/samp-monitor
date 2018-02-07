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
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">信息提供者</div>
                <div class="panel-body">    
                    <div class="media">
                        <div class="media-left media-top">
                            <a href="#">
                                <img class="media-object" src="{{$server->user->avator()}}" alt="...">
                            </a>
                        </div>

                        <div class="media-body">
                            <h3 class="media-heading">{{$server->user->name}}</h3>
                            <p>
                            UID: {{$server->user->id}}
                            <br/>
                            <i class="fa fa-envelope-o"></i> <a href="mailto:{{$server->user->email}}">{{$server->user->email}}</a> 
                            </p>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        服务器介绍
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        @if($server->description)
                            {!! $server->description !!}
                        @else
                            <p class="text-center text-muted">
                                <i class="fa fa-info-circle"></i>
                                没有找到相关介绍
                            </p>
                        @endif
                    </div>
                </div>
            </div>
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
                                    <td>{{gethostbyname($server->ip)}}:{{$server->port}}
                                    <img src="https://ipfind.co/flag?ip={{gethostbyname($server->ip)}}&auth=05a106a4-0d26-4a2f-8f1e-b606f7affa2d" width="25" height="25">
                                    </td>
                                </tr>
                                <tr>
                                    <td>网站:</td>
                                    <td ng-bind-html = "weburl"></td>
                                </tr>
                                <tr>
                                    <td>地图版本:</td>
                                    <td><% mapversion %></td>
                                </tr>
                                <tr>
                                    <td>SAMP版本:</td>
                                    <td><% version %></td>
                                </tr>
                                <tr>
                                    <td>状态:</td>
                                    <td><% status %></td>
                                </tr>
                                <tr>
                                    <td>实时 Ping: <i class="fa fa-question-circle-o text-primary" data-toggle="tooltip" data-placement="top" title="实时获得到的延迟 (基于本机房)"></i></td>
                                    <td><% ping %></td>
                                </tr>
                                <tr>
                                    <td>Ping 平均:  <i class="fa fa-question-circle-o text-primary" data-toggle="tooltip" data-placement="top" title="此服务器本周的平均延迟 (基于本机房)"></i></td>
                                    <td>{{$server->status->count() ? round($server->thisWeek->avg('ping'))."ms" : "暂无统计"}}</td>
                        
                                </tr>
                                <tr>
                                    <td>玩家:</td>
                                    <td><% players %></td>
                                </tr>
                                <tr>
                                    <td>平均玩家:</td>
                                    <td>{{$server->status->count() ? round($server->thisWeek->avg('player')) : "暂无统计"}}</td>
                                </tr>
                                <tr>
                                    <td>历史最大玩家记录:</td>
                                    <td>{{$server->status->count() ? $server->status->max('player') : "暂无统计"}}
                                        @if($server->status->count())
                                        <span class="label label-success">
                                            {{$server->status()->select('created_at')->orderBy('player', 'desc')->first()->created_at->format('Y-m-d H:m:s')}}
                                        </span>
                                        @endif
                                    </td>
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
            <div id="app">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">统计 - 玩家 <span class="label label-success">{{$server->status()->select('created_at')->orderBy('created_at', 'desc')->first()->created_at->format('Y-m-d')}}</span></div>
                        
                        <div class="panel-body">
                                
                        @if($server->status->count())
                            
                                <player-record :id="{{$server->id}}"></player-record>
                        
                        @else
                            <h3 class="text-center" ng-if="!playerlist.length">暂无数据</h3>
                        @endif
                        </div>
                    </div>
                </div>
            
                
                <!-- 统计图 Ping -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">统计 - Ping <span class="label label-success">{{$server->status()->select('created_at')->orderBy('created_at', 'desc')->first()->created_at->format('Y-m-d')}}</span></div>
                        <div class="panel-body">
                            @if($server->status->count())
                                <server-ping :id="{{$server->id}}"></server-ping>
                            
                            @else
                                <h3 class="text-center" ng-if="!playerlist.length">暂无数据</h3>
                            @endif
                        </div>
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
    </div>
  
@endsection

@section('js')
    <!-- JS -->

    <script>    
        angular.module('statusQuery', [], function($interpolateProvider) {
            //解决该死的blade引擎和angularjs的syntax冲突
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        }).controller('sbmpQueryController', function($scope, $http,$interval,$sce) {
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

                //获取Rules
                $http.get("{{ route('api.rules',['ip' => $server->ip, 'port' => $server->port]) }}").then(function mySuccess(response) {
                    if(response.data != "-1")
                    {
                        $scope.version = response.data.version;
                        $scope.mapversion = response.data.mapname;
                        $scope.weburl = $sce.trustAsHtml("<a href='http://" + response.data.weburl + "' target='_blank'>" +response.data.weburl + "</a>");  
                             
                    }
                    else
                    {
                        $scope.version = "超时";
                        $scope.mapversion = "超时";
                        $scope.weburl = $sce.trustAsHtml("超时");                  
                    }

                }, function myError(response) {
                    $scope.version = "超时";
                    $scope.mapversion = "超时";
                    $scope.weburl = "超时";
                    
                    
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