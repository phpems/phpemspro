{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels">
			<div class="col-xs-12 nopadding">
				<div class="panel panel-default pagebox border">
					<div class="panel-heading bold">
						正式考试
						<a class="btn btn-primary pull-right" href="index.php?exam-app-exam-history">考试记录</a>
					</div>
					<div class="panel-body">
						<h2 class="text-center">考试须知</h2>
						<div class="pagebox padding">
							<p>
								考试须知
							</p>
						</div>
						{x2;if:$basic['basicexam']['opentime']['start'] > TIME}
						<p class="alert alert-danger">
							考试将在{x2;date:$basic['basicexam']['opentime']['start'],'Y-m-d H:i:s'}开启，请稍候！
						</p>
						{x2;else}
						{x2;if:$basic['basicexam']['selectrule']}
						<p class="text-center">
							<a class="btn btn-primary ajax" href="index.php?exam-app-exam-selectquestions">开始考试</a>
						</p>
						{x2;else}
						<ul class="list-group">
                            {x2;tree:$papers,paper,sid}
							<li class="list-group-item">
								<a class="ajax" href="index.php?exam-app-exam-selectquestions&paperid={x2;v:paper['paperid']}">
                                    {x2;v:paper['papername']}
								</a>
								<span class="pull-right">
									<span class="intros">总分：{x2;v:paper['papersetting']['score']}分</span>
									<span class="intros">时间：{x2;v:paper['papersetting']['papertime']}分钟</span>
									<span class="intros">及格分：{x2;v:paper['papersetting']['passscore']}分</span>
									<a style="margin-left: 2em;" class="btn btn-primary ajax pull-right" href="index.php?exam-app-exam-selectquestions&paperid={x2;v:paper['paperid']}">开始考试</a>
								</span>
							</li>
                            {x2;endtree}
						</ul>
						{x2;endif}
						{x2;endif}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;if:$basic['basicexam']['opentime']['start'] > TIME}
<script>
	setTimeout(function(){
		window.location.reload();
	},60)
</script>
{x2;endif}
{x2;include:footer}
</body>
</html>