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
                    <li><a href="index.php?{x2;$_route['app']}-teach">教师管理</a></li>
                    <li><a href="index.php?{x2;$_route['app']}-teach-exams">考试管理</a></li>
                    <li><a href="index.php?{x2;$_route['app']}-teach-exams-basics&subjectid={x2;$subject['subjectid']}">{x2;$subject['subjectname']}</a></li>
                    <li class="active">{x2;$basic['basic']}</li>
                </ol>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        试题正确率分析
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr class="info">
                                <th width="60">ID</th>
                                <th>试题名称</th>
                                <th width="80">A</th>
                                <th width="80">B</th>
                                <th width="80">C</th>
                                <th width="80">D</th>
                                <th width="80">正确次数</th>
                                <th width="80">出现次数</th>
                                <th width="80">正确率</th>
                                <!--
                                <th width="80">详情</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            {x2;tree:$stats['data'],stat,sid}
                            <tr>
                                <td>
                                    {x2;v:stat['id']}
                                </td>
                                <td>
                                    {x2;realhtml:v:stat['title']}
                                </td>
                                <td>
                                    {x2;eval: echo round(100 * v:stat['A']/v:stat['number'],2)}%
                                </td>
                                <td>
                                    {x2;eval: echo round(100 * v:stat['B']/v:stat['number'],2)}%
                                </td>
                                <td>
                                    {x2;eval: echo round(100 * v:stat['C']/v:stat['number'],2)}%
                                </td>
                                <td>
                                    {x2;eval: echo round(100 * v:stat['D']/v:stat['number'],2)}%
                                </td>
                                <td>
                                    {x2;eval: echo intval(v:stat['right'])}
                                </td>
                                <td>
                                    {x2;v:stat['number']}
                                </td>
                                <td>
                                    {x2;eval: echo round(100 * v:stat['right']/v:stat['number'],2)}%
                                </td>
                                <!--
                                <td>
                                    <a href="index.php?exam-teach-basic-historyquestionbyuser&questionid={x2;v:stat['id']}&basicid={x2;$basicid}{x2;$u}">查看</a>
                                </td>
                                -->
                            </tr>
                            {x2;endtree}
                            </tbody>
                        </table>
                        <ul class="pagination pull-right">
                            {x2;$stats['pages']}
                        </ul>
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