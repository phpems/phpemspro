{x2;if:!$_userhash}
{x2;include:header}
<div class="pages">
    {x2;endif}
    {x2;if:$page <= 1}
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
        <div class="pages-content nofooter" data-pageurl="index.php?content-mobile-category&catid={x2;$cat['catid']}" data-scroll="yes">
            <div class="pages-box">
                {x2;endif}
                {x2;tree:$contents['data'],content,cid}
                <div class="page-ele{x2;if:v:cid == 1 && $page <= 1} margin{x2;endif}">
                    <a data-page="yes" data-title="{x2;$cat['catname']}" href="index.php?content-mobile-content&contentid={x2;v:content['contentid']}" class="ajax">
                        <h5 class="title">
                            {x2;v:content['contenttitle']}
                        </h5>
                        <div style="clear: both">
                            <p>
                                {x2;v:content['contentintro']}
                            </p>
                            <p class="text-right">
                                <span style="font-size: 0.1rem;">{x2;v:content['contenttime']}</span>
                            </p>
                        </div>
                    </a>
                </div>
                {x2;endtree}
                {x2;if:$page <= 1}
            </div>
        </div>
    </div>
    {x2;endif}
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}