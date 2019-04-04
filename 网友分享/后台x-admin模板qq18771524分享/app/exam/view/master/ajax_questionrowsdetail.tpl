<table class="table table-hover table-bordered">
    {x2;if:$questionrows['qrpoints']}
	<tr>
		<td width="120">所属科目：</td>
		<td>{x2;$subject['subjectname']}</td>
	</tr>
	<tr>
		<td>章节知识点：</td>
		<td>
            {x2;tree:$questionrows['qrpoints'],point,pid}
            {x2;$sections[$points[v:point]['pointsection']]['sectionname']}：{x2;$points[v:point]['pointname']}；
            {x2;endtree}
		</td>
	</tr>
    {x2;endif}
	<tr>
		<td width="120">题帽：</td>
		<td>{x2;realhtml:$questionrows['qrquestion']}</td>
	</tr>
	<tr>
		<td>难度：</td>
		<td>{x2;if:$questionrows['qrlevel']==1}易{x2;elseif:$questionrows['qrlevel']==2}中{x2;elseif:$questionrows['qrlevel']==3}难{x2;endif}</td>
	</tr>
</table>
{x2;tree:$questionrows['data'],question,qid}
<table class="table table-hover table-bordered">
	<tr>
		<td colspan="2">第{x2;v:qid}题</td>
	</tr>
	<tr>
		<td width="120">标题：</td>
		<td>{x2;eval: echo html_entity_decode(v:question['question'])}</td>
	</tr>
	<tr>
		<td>备选项：</td>
		<td>
            {x2;realhtml:v:question['questionselect']}
		</td>
	</tr>
	<tr>
		<td>答案：</td>
		<td>{x2;realhtml: v:question['questionanswer']}</td>
	</tr>
	<tr>
		<td>解析：</td>
		<td>{x2;realhtml: v:question['questionintro']}</td>
	</tr>
</table>
{x2;endtree}