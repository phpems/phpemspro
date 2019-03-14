<div class="container-fluid">
    <div class="row-fluid header">
        <div class="pep header">
            <div class="col-xs-4">
                <ul class="list-unstyled list-inline">
                    <li><i class="glyphicon glyphicon-phone-alt" style="font-size: 16px"></i></li>
                    <li>电话：13900139000</li>
                </ul>
            </div>
            <div class="col-xs-8 text-right">
                <ul class="list-unstyled list-inline">
                    {x2;if:$_user['userid']}
                    <li>欢迎您，{x2;$_user['username']}！</li>
                    <li>|</li>
                    <li><a href="index.php?user-app">个人中心</a></li>
                    <li>|</li>
                    <li><a href="index.php?user-app-login-logout">退出</a></li>
                    {x2;else}
                    <li><a href="javascript:$.loginbox.show();">立即登陆</a></li>
                    <li>|</li>
                    <li><a href="index.php?user-app-login-findpassword">忘记密码</a></li>
                    <li>|</li>
                    <li><a href="index.php?user-app-login-register">快速注册</a></li>
                    {x2;endif}
                    <li>|</li>
                    <li>关于我们</li>
                    <li>|</li>
                    <li>帮助信息</li>
                </ul>
            </div>
        </div>
    </div>
</div>