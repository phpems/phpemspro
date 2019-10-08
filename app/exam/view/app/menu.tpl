<div class="leftmenu">
    <div class="topbox">
        功能导航
    </div>
    <ul class="list-unstyled">
        <a href="index.php?exam-app-basic">
            <li{x2;if:$_route['method'] == 'basic'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-th-list"></i>
                章节练习
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?exam-app-favor">
            <li{x2;if:$_route['method'] == 'favor'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-asterisk"></i>
                错题收藏
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?exam-app-exampaper">
            <li{x2;if:$_route['method'] == 'exampaper'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-list-alt"></i>
                模拟试卷
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?exam-app-history">
            <li{x2;if:$_route['method'] == 'history'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-time"></i>
                考试记录
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?exam-app-stats">
            <li{x2;if:$_route['method'] == 'stats'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-signal"></i>
                统计分析
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        <a href="index.php?exam-app-clear">
            <li{x2;if:$_route['method'] == 'clear'} class="active"{x2;endif}>
                <i class="glyphicon glyphicon-ban-circle"></i>
                记录删除
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        {x2;if:$basic['basicbook']}
        <a href="index.php?content-app-category&catid={x2;$basic['basicbook']}" target="_blank">
            <li>
                <i class="glyphicon glyphicon-print"></i>
                考试指南
                <i class="glyphicon glyphicon-menu-right pull-right"></i>
            </li>
        </a>
        {x2;endif}
    </ul>
</div>