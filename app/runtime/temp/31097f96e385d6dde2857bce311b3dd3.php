<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"D:\www\fishmall\public/../app/admin/index\view\index\login.html";i:1490624576;}*/ ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>狂野钓鱼 - 登录</title>

    <link rel="shortcut icon" href="/favicon.ico">
    <link href="../../../../../public/static/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="../../../../../public/static/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="../../../../../public/static/css/animate.min.css" rel="stylesheet">
    <link href="../../../../../public/static/css/style.min.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
    <script>if (window.top !== window.self) {
        window.top.location = window.location;
    }</script>
    <style type="text/css">
        .ad {
            display: none !important;
            display: none
        }</style>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
        	
        	<div class="">
        		<img src="../../../../../public/static/images/logo.png" width="300"/>
        	</div>

            <!--<h1 class="logo-name">H+</h1>-->

        </div>
        <h3>欢迎使用后台管理系统</h3>

        <form class="m-t" role="form" action="/admin/" method="post" id="login">
            <div class="form-group">
                <input type="text" name="mobile" class="form-control" placeholder="用户名/手机号">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
        </form>
    </div>
</div>
<script src="../../../../../public/static/js/jquery.min.js?v=2.1.4"></script>
<script src="../../../../../public/static/js/bootstrap.min.js?v=3.3.6"></script>
<script src="../../../../../public/static/js/jquery.validate.min.js"></script>
<script src="../../../../../public/static/js/messages_zh.min.js"></script>

<script type="text/javascript">
	$(function(){
		$('#login').validate({
			rules:{
				mobile:{
					isMobile:true,
					required:true
				},
				password:{
					required:true
				}
			},
			massages:{
				mobile:{
					isMobile:"手机格式有误",
					required:"必填"
				},
				password:{
					required:"必填"
				}
			}
		});
	})
</script>
</body>

</html>
