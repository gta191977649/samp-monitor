
<!DOCTYPE html>
<html xmlns="”http://www.w3.org/1999/xhtml”">
<head>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Language" content="zh-cn">
	<meta name="keywords" content="Easy-MP">
	<link rel="shortcut icon" href="favicon.ico">
	{{--
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	--}}
	<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- font-awesome -->
	<link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	
	<link rel="stylesheet" type="text/css" href="{{ asset('css/un.css') }}">
	<title>GTA SA-MP 服务器导航列表 - Powered by Project Sparrow</title>
</head>
<body>

<div id="header">
	<div class="wrapper">
		<h1>SAMP服务器列表</h1>
		
		<ul>
			<li><a href="/" title="主页">主页</a></li>
			<li class="current"><a href="{{ route('index') }}" title="所有运营中的服务器的列表">服务器</a>
            </li>
		    <li><a href="#" title="下载客户端">下载</a></li>
			<li><a href="#" title="关于我们">关于</a></li>
	  </ul>
	</div>
</div>

<div id="pagebody">
<div class="wrapper">
    @yield("main")
</div>
</div>
<footer class="footer">
	<div class="wrapper">
		<p>Powered by <strong><a href="https://project-sparrow.ml/blog">禾雀飛翔 | Episodes</a></strong></p>
        <p>主题创意来自于: GTAUN.NET 二次开发 By Episodes</p>
  	</div>
</footer>
    {{-- JS --}}
	<script src="{{ asset('js/app.js') }}"></script>
	
</body>
</html>