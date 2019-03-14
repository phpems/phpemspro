{x2;if:!$_userhash}
{x2;include:header}
<div class="pages">
    {x2;endif}
    <div class="pages-tabs">
        <div class="pages-header">
            <a class="col-xs-2" href="javascript:history.back();"><div class="text-center">
                    <i class="glyphicon glyphicon-menu-left"></i>
                </div></a>
            <a class="col-xs-8 active">
                <div class="text-center">修改密码</div>
            </a>
            <a class="col-xs-2">
                <div class="text-center">
                    <i class="glyphicon glyphicon-option-horizontal"></i>
                </div>
            </a>
        </div>
        <div class="pages-content nofooter">
            <div class="pages-box">
                <div class="page-ele clear">
                    <div class="text-center">
                        <img src="public/static/images/icon.jpg" class="img-circle" style="width: 1.05rem;margin-top: 0.25rem;"/>
                    </div>
                </div>
                <div class="page-form">
                    <form method="post" action="index.php?user-mobile-user-password">
                        <div class="form-group border">
                            <label class="control-label col-xs-3">旧密码</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" name="oldpassword" needle="needle" datatype="password" msg="请输入旧密码" placeholder="请输入旧密码"/>
                            </div>
                        </div>
                        <div class="form-group border">
                            <label class="control-label col-xs-3">新密码</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" name="newpassword" id="newpassword" needle="needle" datatype="password" msg="请输入新密码" placeholder="请输入新密码"/>
                            </div>
                        </div>
                        <div class="form-group border">
                            <label class="control-label col-xs-3">重复密码</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" equ="newpassword" name="reuserpassword" needle="needle" datatype="password" msg="两次输入密码必须一致" placeholder="请再次输入新密码"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls">
                                <button class="btn btn-primary btn-block" type="submit">修改密码</button>
                                <input type="hidden" value="1" name="modifypassword"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}