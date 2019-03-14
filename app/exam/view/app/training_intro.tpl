{x2;include:header}
<body>
{x2;include:top}
<div class="container-fluid">
	<div class="row-fluid nav">
		<div class="pep nav">
			<div class="col-xs-4 title">
				<ul class="list-unstyled list-inline">
					<li class="nopadding"><img src="public/static/images/index_logo.jpg" /></li>
				</ul>
			</div>
			<div class="col-xs-8 menu">
				<ul class="list-unstyled list-inline">
					<li><a href="index.php">首页</a></li>
                    {x2;tree:$navtrainings,training,trid}
					<li><a href="index.php?exam-app-index-training&trid={x2;v:training['trid']}">{x2;v:training['trname']}</a></li>
                    {x2;endtree}
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels">
			<div class="col-xs-12 nopadding">
				<div class="panel panel-default pagebox border">
					<div class="panel-heading bold">
                        <a href="index.php?exam"> 模拟考试</a>
					</div>
					<div class="panel-body">
						<h2 class="text-center">{x2;$training['trname']}</h2>
						<p class="text-center intros">{x2;$training['trintro']}</p>
						<hr />
						<div class="contenttext">
                            {x2;$training['trtext']}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>