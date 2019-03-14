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
                <div class="text-center">我的课程</div>
            </a>
            <a class="col-xs-2">
                <div class="text-center">
                    <i class="glyphicon glyphicon-option-horizontal"></i>
                </div>
            </a>
        </div>
        <div class="pages-content nofooter">
            <div class="pages-box nopadding">
                {x2;tree:$lessons,lesson,lid}
                <div class="page-ele{x2;if:v:lid == 1} margin{x2;endif}">
                    <a data-page="yes" data-title="{x2;$lesson['lessonname']}" href="index.php?lesson-mobile-lesson&lessonid={x2;v:lesson['lessonid']}" class="ajax">
                        <div class="col-xs-3" style="padding-top: 0.1rem;">
                            <img src="{x2;v:lesson['lessonthumb']}" class="img-circle" style="width: 86%;"/>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="title">{x2;v:lesson['lessonname']}</h5>
                            <p>
                                {x2;realsubstring:v:lesson['lessonintro'],72}
                            </p>
                            <p>到期时间：{x2;v:lesson['oplendtime']}</p>
                        </div>
                    </a>
                </div>
                {x2;endtree}
            </div>
        </div>
    </div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}