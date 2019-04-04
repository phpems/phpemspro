<!doctype html>
<html  class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>PHPEMSPRO</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/public/admin/css/font.css">
    <link rel="stylesheet" href="/public/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript"src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.min.js"></script>
    <script src="/public/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/public/admin/js/xadmin.js"></script>
    <script type="text/javascript" src="/public/admin/js/cookie.js"></script>
    <script>
        // 是否开启刷新记忆tab功能
        // var is_remember = false;
    </script>
</head>
<body>
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="/">PHPEMSPRO</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a onclick="x_admin_show('百度','https://www.baidu.com')"><i class="iconfont">&#xe6ba;</i>百度</a></dd>
                <dd><a onclick="x_admin_add_to_tab('音乐','https://music.163.com/',true)"><i class="iconfont">&#xe6bc;</i>音乐</a></dd>
                <dd><a onclick="x_admin_add_to_tab('阿里云','https://www.aliyun.com',true)"><i class="iconfont">&#xe6ce;</i>阿里云</a></dd>
                <dd><a onclick="x_admin_add_to_tab('公众号','https://mp.weixin.qq.com/cgi-bin/loginpage',true)"><i class="iconfont">&#xe722;</i>公众号</a></dd>
                <dd><a onclick="x_admin_add_to_tab('百度站长','https://ziyuan.baidu.com/dashboard/index',true)"><i class="iconfont">&#xe6ae;</i>百度站长</a></dd>
                <dd><a onclick="x_admin_add_to_tab('360站长','http://zhanzhang.so.com/sitetool/site_manage',true)"><i class="iconfont">&#xe6ae;</i>360站长</a></dd>
            </dl>
          </li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;">{x2;$_user['username']}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('个人信息','/index.php?user-app-user')">个人信息</a></dd>
              <dd><a href="index.php?core-master-login-logout" class="ajax">退出登陆</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a href="/" target ="_blank">前台首页</a></li>
        </ul>
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    {x2;if:$_user['userid']}
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b8;</i>
                    <cite>用户管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li date-refresh="1">
                        <a _href="index.php?user-master-users">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员列表</cite>
                            
                        </a>
                    </li >
                    <li date-refresh="1">
                        <a _href="index.php?user-master-groups">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>用户组</cite>
                            
                        </a>
                    </li>
                    <li date-refresh="1">
                        <a _href="index.php?user-master-setting">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>模块设置</cite>
                            
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe723;</i>
                    <cite>题库管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="index.php?exam-master-exams">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>题库管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="index.php?exam-master-users">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>题库用户分析</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="index.php?exam-master-tools">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>题库系统工具</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="index.php?exam-master-setting">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>题库模块</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6b3;</i>
                    <cite>课程管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    {x2;tree:$les,cats,cid}
                    {x2;if:v:cats['nodes']}
                    <li>
                        <a _href="javascript:;">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>{x2;v:cats['text']}</cite>
                        </a>
                        <ul class="sub-menu">
                            {x2;tree:v:cats['nodes'],cat,lid}
                            <li>
                                <a _href="{x2;v:cat['href']}">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{x2;v:cat['text']}</cite>
                                </a>
                            </li >
                            {x2;endtree}
                        </ul>
                    </li >
                    {x2;else}
                    <li>
                        <a _href="{x2;v:cats['href']}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>{x2;v:cats['text']}</cite>
                        </a>
                    </li >
                    {x2;endif}
                    {x2;endtree}

                    <li>
                        <a _href="index.php?lesson-master-category">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>课程分类</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe6ce;</i>
                    <cite>内容管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    {x2;tree:$con,cats,cid}
                    {x2;if:v:cats['nodes']}
                    <li>
                        <a _href="javascript:;">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>{x2;v:cats['text']}</cite>
                        </a>
                        <ul class="sub-menu">
                            {x2;tree:v:cats['nodes'],cat,lid}
                            <li>
                                <a _href="{x2;v:cat['href']}">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{x2;v:cat['text']}</cite>
                                </a>
                            </li >
                            {x2;endtree}
                        </ul>
                    </li >
                    {x2;else}
                    <li>
                        <a _href="{x2;v:cats['href']}">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>{x2;v:cats['text']}</cite>
                        </a>
                    </li >
                    {x2;endif}
                    {x2;endtree}
                    <li>
                        <a _href="index.php?content-master-category">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>内容分类</cite>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe758;</i>
                    <cite>订单管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="index.php?finance-master-orders">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>订单管理</cite>
                        </a>
                    </li >
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe70c;</i>
                    <cite>数据库</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a _href="index.php?database-master-database">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>分库管理</cite>
                        </a>
                    </li >
                    <li>
                        <a _href="index.php?database-master-model">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>模型管理</cite>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
      </div>
    </div>
    {x2;endif}
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                <dl>
                    <dd data-type="this">关闭当前</dd>
                    <dd data-type="other">关闭其它</dd>
                    <dd data-type="all">关闭全部</dd>
                </dl>
          </div>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='index.php?core-master-index-welcome' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
          <div id="tab_show"></div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
</body>
</html>