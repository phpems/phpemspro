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
                <div class="text-center">找回密码</div>
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
                    <form method="post" action="index.php?user-mobile-login-findpassword">
                        <div class="form-group border">
                            <label class="control-label col-xs-3">手机号码</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="findphonenumber" name="args[userphone]" needle="needle" datatype="phonenumber" msg="您必须填写手机号" placeholder="请输入手机号"/>
                            </div>
                        </div>
                        <div class="form-group border">
                            <label class="control-label col-xs-3">验证码</label>
                            <div class="col-xs-5">
                                <input type="password" class="form-control" name="randcode" needle="needle" datatype="number" msg="您必须填写验证码" placeholder="请输入验证码"/>
                            </div>
                            <div class="col-xs-4 text-right">
                                <a id="sendfindphonecode">发送验证码</a>
                            </div>
                        </div>
                        <div class="form-group border">
                            <label class="control-label col-xs-3">密码</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="setfindpassword" name="args[userpassword]" needle="needle" datatype="password" msg="您必须填写登陆密码" placeholder="请输入登陆密码"/>
                            </div>
                        </div>
                        <div class="form-group border">
                            <label class="control-label col-xs-3">重复密码</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" equ="setfindpassword" name="args[reuserpassword]" needle="needle" datatype="password" msg="您必须填写登陆密码" placeholder="请输入登陆密码"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls">
                                <button class="btn btn-primary btn-block" type="submit">找回密码</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <a href="index.php?user-mobile-login" class="ajax" data-title="用户登录" data-page="yes">立即登录</a>
                                <input type="hidden" value="1" name="userfindpassword"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        if("undefined" != typeof pep.sendevent)clearInterval(pep.sendevent);
        pep.sendstatus = true;
        $('#sendfindphonecode').click(function(){
            var _this = $(this);
            if(pep.sendstatus)
            {
                $.getJSON('index.php?core-api-index-sendsms&action=findpassword&phonenumber='+$('#findphonenumber').val()+'&userhash='+Math.random(),function(data){
                    if(parseInt(data.statusCode) == 200)
                    {
                        _this.html('120秒重发');
                        sendstatus = false;
                        sendtime = 120;
                        sendevent = setInterval(function(){
                            if(sendtime > 0)
                            {
                                sendtime--;
                                _this.html(sendtime+'秒重发');
                            }
                            else
                            {
                                sendstatus = true;
                                _this.html('发送验证码');
                                clearInterval(sendevent);
                            }
                        },1000);
                    }
                    else
                    {
                        pep.mask.show('ajax',data);
                    }
                });
            }
        });
    </script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}