@extends('layouts.app')

@section('content')
    <div class="row">
        @include('layouts.ucp-sidebar')
        <div class="col-md-10">
        <h1>API</h1>
        <hr/>
        <h2>概览</h2>
        <p>你可以通过本站提供的API来获取你SBMP的状态在你自己的网站上</p>
        <h2>服务器信息查询 <small>JSON</small></h2>
        <p>调用方法:</p>
        <blockquote class="blockquote">
            <code>
                {{URL::to('/')}}/api/samp/info/{ip}/port/{port}
            </code>
        </blockquote>
        <p><code>{ip}</code> 为你服务器的地址(支持域名),<code>{port}</code> 为你服务器的端口。</p>
        <p>在线演示:</p>
        <div ng-app="demo_queryInfo" ng-controller="ctrl_queryInfo">
            <form class="form-inline" ng-submit="queryInfo()" action="#">
                <div class="form-group">
                    <input class="form-control" type="text" ng-model="request.ip" placeholder="IP"> 
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" ng-model="request.port" placeholder="端口">
                </div>
                
                <input class="btn btn-default" type="submit" value="测试">
               
            </form>

            <div>
                结果:(<% status %>)
                <ul>
               
                <li ng-repeat="user in results">
                   
                </li>
                </ul>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular-route.js') }}"></script>
    <script>
      
    </script>
@endsection