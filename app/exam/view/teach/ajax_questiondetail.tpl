				<table class="table table-hover table-bordered">
					{x2;if:$question['questionpoints']}
					<tr>
			          <td width="120">科目：</td>
			          <td>{x2;$subject['subjectname']}&nbsp;</td>
			        </tr>
			        <tr>
			          <td>章节知识点：</td>
			          <td>
						  {x2;tree:$question['questionpoints'],point,pid}
                          {x2;$sections[$points[v:point]['pointsection']]['sectionname']}：{x2;$points[v:point]['pointname']}；
						  {x2;endtree}
					  </td>
			        </tr>
			        {x2;endif}
			        <tr>
			          <td width="120">标题：</td>
			          <td>{x2;realhtml:$question['question']}</td>
			        </tr>
			        <tr>
			        	<td>备选项：</td>
			        	<td>
			          		{x2;realhtml:$question['questionselect']}
						</td>
			        </tr>
			        <tr>
			          <td>答案：</td>
			          <td>{x2;realhtml:$question['questionanswer']}</td>
			        </tr>
			        <tr>
			          <td>解析：</td>
			          <td>{x2;realhtml:$question['questionintro']}&nbsp;</td>
			        </tr>
			        <tr>
			          <td>难度：</td>
			          <td>{x2;if:$question['questionlevel']==1}易{x2;elseif:$question['questionlevel']==2}中{x2;elseif:$question['questionlevel']==3}难{x2;endif}&nbsp;</td>
			        </tr>
				</table>