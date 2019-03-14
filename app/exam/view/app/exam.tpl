{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels">
			<div class="col-xs-2">
                {x2;include:menu}
			</div>
			<div class="col-xs-10 nopadding">
				<div class="panel panel-default pagebox border">
					<div class="panel-heading bold">
						考前押题
					</div>
					<div class="panel-body">
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
									<a style="margin-left: 2em;" class="btn btn-primary ajax pull-right" href="index.php?exam-app-exam-selectquestions&paperid={x2;v:paper['paperid']}">去做题</a>
								</span>
							</li>
                            {x2;endtree}
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>