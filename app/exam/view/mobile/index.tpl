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
                <div class="text-center">我的题库</div>
            </a>
            <a class="col-xs-2">
                <div class="text-center">
                    <i class="glyphicon glyphicon-option-horizontal"></i>
                </div>
            </a>
        </div>
        <div class="pages-content">
            <div class="pages-box">
                {x2;tree:$trainings,training,tid}
                {x2;if:$usetraining[v:training['trid']]}
                <div class="page-ele contin margin">
                    <h4 class="bigtitle">{x2;v:training['trname']}</h4>
                </div>
                {x2;tree:$subjects[v:training['trid']],subject,sid}
                {x2;tree:$basics[v:subject['subjectid']],basic,bid}
                <div class="page-ele contin">
                    <a data-page="yes" data-title="{x2;v:basic['basic']}" href="index.php?exam-mobile-ajax-setcurrentbasic&subjectid={x2;v:subject['subjectid']}&basicid={x2;v:basic['basicid']}" class="ajax">
                        <div class="col-xs-3" style="padding-top: 0.1rem;">
                            <img src="{x2;v:basic['basicthumb']}" class="img-circle" style="width: 100%;"/>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="title">{x2;v:basic['basic']}</h5>
                            <p>
                                {x2;v:basic['basicdescribe']}
                            </p>
                            <p>
                                到期时间:{x2;v:basic['obendtime']}
                            </p>
                        </div>
                    </a>
                </div>
                {x2;endtree}
                {x2;endtree}
                {x2;endif}
                {x2;endtree}
            </div>
        </div>
    </div>
    <script>
        $(function(){
            //
        });
    </script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}