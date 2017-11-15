@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-md-10">
        <h1>API</h1>
        <hr/>

        <h2>概览</h2>
        <p>你可以通过本站提供的API来获取你SBMP的状态在你自己的网站上</p>

        <h2>基本信息查询<small>JSON</small></h2>
        <p>这包含你服务器的hostname,gamemode,player,map等基本信息。</p>
        <p>使用方法:</p>
        <blockquote class="blockquote">
            <p>方法:GET</p>
            <code>
                {{URL::to('/')}}/api/samp/info/{ip}/port/{port}
            </code>
            <p><code>{ip}</code> 为你服务器的地址(支持域名),<code>{port}</code> 为你服务器的端口。</p>
            <p>返回值:</p>
            <p>如果获取状态成功则返回一条<code>json</code>(包含你服务器基本信息), 如果超时则返回 <code>-1</code></p>
        </blockquote>

        <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#demo1">演示DEMO</a>
                <span class="pull-right panel-collapse-clickable" data-toggle="collapse" href="#demo1">
                    <i class="glyphicon glyphicon-chevron-down"></i>
                </span>
            </h4>
        </div>
        <div id="demo1" class="panel-collapse panel-collapse collapse">
            <div class="panel-body">
                <div ng-app="demo_queryInfo" ng-controller="ctrl_queryInfo">
                    <div>
                        <div class="form-group">
                            <label>你的服务器IP:</label>
                            <input class="form-control" type="text" ng-model="request.ip" placeholder="你的服务器IP"> 
                        </div>
                        <div class="form-group">
                            <label>端口:</label>
                            <input class="form-control" type="text" ng-model="request.port" placeholder="端口">
                        </div>
                        <div class="form-group">
                            <label>API代码(自动生成):</label>
                            <input class="form-control" type="text" placeholder="自动生成"  value="<% getUrl %>">
                        </div>
                        <a class="btn btn-default" ng-click="queryInfo()">获取基本状态</a>
                    
                        
                    </div>
                    <p>返回JSON:</p>
                    <textarea class="form-control" ><% results %></textarea>
                </div>
            </div>
        </div>
        </div>

       
        <h2>简单在线玩家查询<small>JSON</small></h2>
        <p>只返回简单的一条信息格式为:目前玩家数/最大玩家数</p>

        <blockquote class="blockquote">
            <p>方法:GET</p>
            <code>
                {{URL::to('/')}}/api/samp/player/{ip}/port/{port}
            </code>
            <p><code>{ip}</code> 为你服务器的地址(支持域名),<code>{port}</code> 为你服务器的端口。</p>
            <p>返回值:</p>
            <p>如果获取状态成功则返回一条<code>json</code>(包含player和maxplayers), 如果超时则返回 <code>-1</code></p>
        </blockquote>

        <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" href="#demo2">演示DEMO</a>
                <span class="pull-right panel-collapse-clickable" data-toggle="collapse" href="#demo2">
                    <i class="glyphicon glyphicon-chevron-down"></i>
                </span>
            </h4>
        </div>
        <div id="demo2" class="panel-collapse panel-collapse collapse">
            <div class="panel-body">
                <div id="demo_queryInfo2" ng-app="demo_queryInfo2" ng-controller="ctrl_queryInfo2">
                <div>
                    <div class="form-group">
                        <label>你的服务器IP:</label>
                        <input class="form-control" type="text" ng-model="request.ip" placeholder="你的服务器IP"> 
                    </div>
                    <div class="form-group">
                        <label>端口:</label>
                        <input class="form-control" type="text" ng-model="request.port" placeholder="端口">
                    </div>
                    <div class="form-group">
                        <label>API代码(自动生成):</label>
                        <input class="form-control" type="text" placeholder="自动生成"  value="<% getUrl %>">
                    </div>
                    <a class="btn btn-default" ng-click="queryInfo()">获取基本状态</a>
                
                    
                </div>
                <p>返回JSON:</p>
                <textarea class="form-control" ><% results %></textarea>
                </div>
            </div>
        </div>
        </div>




    </div>
@endsection

@section('js')
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    <script>
        var demo1 = angular.module('demo_queryInfo', [], function($interpolateProvider) {
            //解决该死的blade引擎和angularjs的syntax冲突
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });

        demo1.controller('ctrl_queryInfo', function($scope,$http) {
          
            $scope.queryInfo = function() {
                /*alert($scope.request.ip+":"+$scope.request.port);*/
                $scope.getUrl = "{{URL::to('/')}}/api/samp/info/"+$scope.request.ip + "/port/" + $scope.request.port;
                $http({
                    method : "GET",
                    url : $scope.getUrl,
                    /*
                    params: {
                        "ip" :  $scope.request.ip,
                        "port" :  $scope.request.port
                    }
                    */
                }).then(function mySuccess(response) {
                    $scope.results = response.data;
                }, function myError(response) {
                    $scope.results = response.statusText;
                });
            };
        });
    </script>

    <script>
        var demo1 = angular.module('demo_queryInfo2', [], function($interpolateProvider) {
            //解决该死的blade引擎和angularjs的syntax冲突
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });

        demo1.controller('ctrl_queryInfo2', function($scope,$http) {
          
            $scope.queryInfo = function() {
                /*alert($scope.request.ip+":"+$scope.request.port);*/
                $scope.getUrl = "{{URL::to('/')}}/api/samp/player/"+$scope.request.ip + "/port/" + $scope.request.port;
                $http({
                    method : "GET",
                    url : $scope.getUrl,
                    /*
                    params: {
                        "ip" :  $scope.request.ip,
                        "port" :  $scope.request.port
                    }
                    */
                }).then(function mySuccess(response) {
                    $scope.results = response.data;
                }, function myError(response) {
                    $scope.results = response.statusText;
                });
            };

        });
        angular.bootstrap(document.getElementById("demo_queryInfo2"), ['demo_queryInfo2']);
    </script>
 
@endsection