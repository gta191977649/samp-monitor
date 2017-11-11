
<!DOCTYPE html>
<html xmlns="”http://www.w3.org/1999/xhtml”">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Language" content="zh-cn">
	<meta name="keywords" content="Easy-MP">
	<link rel="shortcut icon" href="favicon.ico">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<title>Project Sparrow SAMP服務器列表</title>
</head>
<body>

<div id="header">
	<div class="wrapper">
		<h1>SAMP服务器列表</h1>
		<ul>
			<li><a href="index.php" title="主页">主页</a></li>
			<li class="current"><a href="{{ route('index') }}" title="所有运营中的服务器的列表">服务器</a>
            </li>
		    <li><a href="files.php" title="下载客户端">下载</a></li>
			<li><a href="forum.php" title="访问社区">社区</a></li>
			<li><a href="about.php" title="关于我们">关于</a></li>
	  </ul>
	</div>
</div>

<div id="pagebody">
<div class="wrapper">
    @yield("main")
</div>
</div>
<div id="footer">
	<div class="wrapper">
		<p>Powered by <strong><a href="http://www.crystalglass.tk">禾雀飛翔 | Episodes</a></strong></p>
        <p>Theme Designed By GTAUN.NET</p>
  	</div>
</div>
    {{-- JS --}}
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
   


</body>
</html>