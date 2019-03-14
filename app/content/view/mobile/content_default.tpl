{x2;if:!$_userhash}
{x2;include:header}
<div class="pages">
    {x2;endif}
    <div class="pages-tabs">
        <div class="pages-header">
            <a class="col-xs-2" href="javascript:history.back();">
                <div class="text-center">
                    <i class="glyphicon glyphicon glyphicon-menu-left"></i>
                </div>
            </a>
            <a class="col-xs-8 active">
                <div class="text-center">{x2;$cat['catname']}</div>
            </a>
            <a class="col-xs-2">
                <div class="text-center">
                    <i class="glyphicon glyphicon-option-horizontal"></i>
                </div>
            </a>
        </div>
        <div class="pages-content nofooter">
            <div class="pages-box">
                <div class="page-ele margin">
                    <h4 class="title text-center">{x2;$content['contenttitle']}</h4>
                    <hr />
                    <div class="news">
                        {x2;$content['contenttext']}
                    </div>
                    <p class="text-right">{x2;$content['contenttime']}</p>
                </div>
            </div>
        </div>
    </div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}