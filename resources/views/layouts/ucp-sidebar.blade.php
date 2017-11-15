
@if(!Auth::guest())
<div class="col-md-2 sidebar">
    <ul class="panel panel-default">
        <div class="panel-heading">帐号</div>
        <li><a href="#">信息修改</a></li>
    </ul>

    <ul class="panel panel-default">
        <div class="panel-heading">服务器</div>
        
        <li><a href="#">概览</a></li>
        <li><a href="{{route('ucp.server.index')}}">我的服务器</a></li>
        <li><a href="#">分析</a></li>
    </ul>
    <ul class="panel panel-default">
        <div class="panel-heading">工具</div>
        
        <li><a href="#">签名生成</a></li>
        <li><a href="{{route('ucp.api.query')}}">API</a></li>
    </ul>
</div>
@endif