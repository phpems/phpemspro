<div class="leftmenu">
    <div class="topbox">
        个人中心
    </div>
    <ul class="list-unstyled">
        <a href="index.php?user-app-user">
            <li{x2;if:$_route['method'] == 'user'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-user"></i>
                个人信息
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?user-app-lesson">
            <li{x2;if:$_route['method'] == 'lesson'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-play-circle"></i>
                我的课程
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?user-app-exam">
            <li{x2;if:$_route['method'] == 'exam'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-list-alt"></i>
                我的题库
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?user-app-orders">
            <li{x2;if:$_route['method'] == 'orders'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-credit-card"></i>
                我的订单
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        {x2;if:$_user['usergroupcode'] == 'webmaster'}
        <a href="index.php?core-master">
            <li>
                <i class="glyphicon glyphicon-cog"></i>
                后台管理
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        {x2;elseif:$_user['usergroupcode'] == 'teacher'}
        <a href="index.php?exam-teach">
            <li>
                <i class="glyphicon glyphicon-cog"></i>
                后台管理
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        {x2;endif}
    </ul>
</div>