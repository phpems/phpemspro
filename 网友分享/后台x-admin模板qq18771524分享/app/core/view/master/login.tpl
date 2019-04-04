<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/public/dmin/css/font.css">
	<link rel="stylesheet" href="/public/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/public/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/public/admin/js/xadmin.js"></script>
    <script type="text/javascript" src="/public/admin/js/cookie.js"></script>
</head>
<body class="login-bg">
    <div class="login layui-anim layui-anim-up">
        <div class="message">管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" action="index.php?core-master-login" class="layui-form" >
            <input name="args[username]" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="args[userpassword]" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="savepassword" lay-skin="primary" type="checkbox" title="记住密码" value="1"> 
            <hr class="hr15">
            <input type="hidden" name="userlogin" value="1"/>
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>
</body>
</html>