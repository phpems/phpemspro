{x2;if:!$_userhash}
{x2;include:header}
<div class="pages">
    {x2;endif}
		<div class="pages-tabs">
			<div class="pages-header">
				<a class="col-xs-2" href="javascript:history.back();"><div class="text-center">
						<i class="glyphicon glyphicon glyphicon-menu-left"></i>
					</div></a>
				<a class="col-xs-8 active">
					<div class="text-center">{x2;$history['ehexam']}</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter" data-refresh="yes">
				<div class="pages-box">
					<div class="page-ele">
						<div class="col-xs-6">{x2;eval: echo intval($history['ehscore'])}</div>
						<div class="col-xs-6">
							<h4 class="title">{x2;$history['ehexam']}</h4>
							<p>总分：{x2;$history['ehsetting']['papersetting']['score']}分</p>
							<p>合格分数：{x2;$history['ehsetting']['papersetting']['passscore']}分</p>
						</div>
						<hr />
						<div class="text-center">
							<span class="btn btn-primary" style="border-radius: 0.17rem;padding-left:0.2rem;padding-right:0.2rem;">查看详细</span>
						</div>
					</div>
					<div class="page-ele">
						<h5 class="bigtitle">得分分析</h5>
						<div class="question">
							<table class="table table-bordered">
								<tr class="info">
									<th>题型</th>
									<th>题数</th>
									<th>分数</th>
									<th>答对数</th>
									<th>得分</th>
								</tr>
                                {x2;tree:$number,num,nid}
                                {x2;if:v:num}
								<tr>
									<td class="table_td">{x2;$questypes[v:key]['questype']}</td>
									<td class="table_td">{x2;v:num}</td>
									<td class="table_td">{x2;eval: echo number_format(v:num*$history['ehsetting']['papersetting']['questype'][v:key]['score'],1)}</td>
									<td class="table_td">{x2;$right[v:key]}</td>
									<td class="table_td">{x2;eval: echo number_format($score[v:key],1)}</td>
								</tr>
                                {x2;endif}
                                {x2;endtree}
							</table>
						</div>
					</div>
                    <div class="page-ele">
                        {x2;if:$history['ehispass']}
                        <p class="title col-xs-12 text-center text-success">恭喜您通过了本次考试</p>
                        {x2;else}
                        <p class="title col-xs-12 text-center text-danger">很遗憾，您未通过本次考试</p>
                        {x2;endif}
                    </div>
				</div>
			</div>
		</div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}