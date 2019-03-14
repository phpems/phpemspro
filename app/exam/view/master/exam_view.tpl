{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
    <div class="row-fluid">
        <div class="pep">
            <div class="col-xs-2 leftmenu">
                {x2;include:menu}
            </div>
            <div class="col-xs-10" id="datacontent">
                {x2;endif}
                <ol class="breadcrumb">
                    <li><a href="index.php?{x2;$_route['app']}-master">{x2;$apps[$_route['app']]['appname']}</a></li>
                    <li><a href="index.php?{x2;$_route['app']}-master-exams">考试管理</a></li>
                    <li><a href="index.php?{x2;$_route['app']}-master-exams-basics&subjectid={x2;$subject['subjectid']}">{x2;$subject['subjectname']}</a></li>
                    <li><a href="index.php?{x2;$_route['app']}-master-exams-basics-decide&basicid={x2;$basic['basicid']}">{x2;$basic['basic']}</a></li>
                    <li class="active">阅卷</li>
                </ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        《{x2;$history['ehexam']}》
                    </div>
                    <div class="panel-body">
                        <h2 class="text-center">{x2;$history['ehscore']}</h2>
                        {x2;eval: v:oid = 0}
                        {x2;tree:$questypes,quest,qid}
                        {x2;eval: v:oid++}
                        {x2;if:$history['ehquestion']['questions'][v:quest['questcode']] || $history['ehquestion']['questionrows'][v:quest['questcode']]}
                        <h4>{x2;v:quest['questype']}</h4>
                        {x2;eval: v:tid = 0}
                        {x2;tree:$history['ehquestion']['questions'][v:quest['questcode']],question,qnid}
                        {x2;eval: v:tid++}
                        <table class="table table-hover table-bordered">
                            <tr class="info">
                                <td style="width:120px;">第{x2;v:tid}题</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>标题：</td>
                                <td>{x2;realhtml:v:question['question']}</td>
                            </tr>
                            <tr>
                                <td>标准答案：</td>
                                <td>{x2;realhtml:v:question['questionanswer']}</td>
                            </tr>
                            <tr>
                                <td>考生答案：</td>
                                <td>{x2;realhtml:$history['ehuseranswer'][v:question['questionid']]}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="form-inline">得分：{x2;$history['ehscorelist'][v:question['questionid']]} <span>提示：本题共{x2;$history['ehsetting']['papersetting']['questype'][v:quest['questcode']]['score']}分。</span></td>
                            </tr>
                        </table>
                        {x2;endtree}
                        {x2;tree:$history['ehquestion']['questionrows'][v:quest['questcode']],rowsquestion,qrid}
                        {x2;eval: v:tid++}
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <table class="table table-bordered">
                                        <tr class="info">
                                            <td>第{x2;v:tid}题</td>
                                        </tr>
                                        <tr>
                                            <td>{x2;realhtml:v:rowsquestion['qrquestion']}</td>
                                        </tr>
                                    </table>
                                    {x2;tree:v:rowsquestion['data'],question,cqid}
                                    <table class="table table-hover table-bordered" width="96%">
                                        <tr class="info">
                                            <td style="width:120px;">第{x2;v:cqid}小题</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>标题：</td>
                                            <td>{x2;eval: echo strip_tags(html_entity_decode(v:question['question']))}</td>
                                        </tr>
                                        <tr>
                                            <td>标准答案：</td>
                                            <td>{x2;realhtml:v:question['questionanswer']}</td>
                                        </tr>
                                        <tr>
                                            <td>考生答案：</td>
                                            <td>{x2;realhtml:$history['ehuseranswer'][v:question['questionid']]}&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="form-inline">得分：{x2;$history['ehscorelist'][v:question['questionid']]} <span>提示：本题共{x2;$history['ehsetting']['papersetting']['questype'][v:quest['questcode']]['score']}分。</span></td>
                                        </tr>
                                    </table>
                                    {x2;endtree}
                                </td>
                            </tr>
                        </table>
                        {x2;endtree}
                        {x2;endif}
                        {x2;endtree}
                    </div>
                </div>
            </div>
            {x2;if:!$userhash}
        </div>
    </div>
</div>
{x2;include:footer}
</body>
</html>
{x2;endif}