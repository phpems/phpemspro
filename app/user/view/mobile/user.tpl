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
                <div class="text-center">个人信息</div>
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
                    <form method="post" action="index.php?user-mobile-user">
                        {x2;tree:$forms,form,fid}
                        <div class="form-group border">
                            <label for="{x2;v:form['id']}" class="control-label col-xs-3">{x2;v:form['title']}</label>
                            <div class="col-xs-9">
                                {x2;v:form['html']}
                            </div>
                        </div>
                        {x2;endtree}
                        <div class="form-group">
                            <div class="controls">
                                <button class="btn btn-primary btn-block" type="submit">修改</button>
                                <input type="hidden" value="1" name="modifyuser"/>
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