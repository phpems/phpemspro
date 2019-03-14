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
                <div class="page-ele">
                    <ul class="listmenu">
                        {x2;tree:$catchildren,cat,cid}
                        <li>
                            <a href="index.php?lesson-mobile-category&catid={x2;v:cat['catid']}">
                                {x2;v:cat['catname']}
                                <i class="glyphicon glyphicon-menu-right pull-right"></i>
                            </a>
                        </li>
                        {x2;endtree}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}