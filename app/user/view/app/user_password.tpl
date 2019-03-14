{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
    <div class="row-fluid panels">
        <div class="pep panels">
            <div class="col-xs-2">
                {x2;include:menu}
            </div>
            <div class="col-xs-10 nopadding">
                <div class="panel panel-default pagebox border">
                    <div class="panel-heading bold">
                        <a class="btn btn-default" href="index.php?user-app-user"><i class="glyphicon glyphicon-star-empty"></i> 个人信息</a>
                        <a class="btn btn-primary" href="index.php?user-app-user-password"><i class="glyphicon glyphicon-lock"></i> 修改密码</a>
                    </div>
                    <div class="panel-body">
                        <form action="index.php?user-app-user-password" method="post" class="form-horizontal" style="margin-top: 40px;">
                            <div class="form-group">
                                <label for="userphone" class="control-label col-sm-2">旧密码：</label>
                                <div class="col-sm-9">
                                    <input class="form-control normalinput" needle="needle" msg="请填写手机号码" type="password" name="oldpassword" value="" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="useremail" class="control-label col-sm-2">新密码：</label>
                                <div class="col-sm-9">
                                    <input class="form-control normalinput" needle="needle" msg="请填写新密码" id="newpassword" type="password" name="newpassword" value="" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usersex" class="control-label col-sm-2">重复密码：</label>
                                <div class="col-sm-9">
                                    <input class="form-control normalinput" needle="needle" msg="请重复填写密码" equ="newpassword" type="password" value="" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 40px;">
                                <label for="groupid" class="control-label col-sm-2"></label>
                                <div class="col-sm-4">
                                    <button class="btn btn-primary" type="submit">修改密码</button>
                                    <input type="hidden" name="modifypassword" value="1"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{x2;include:footer}
</body>
</html>