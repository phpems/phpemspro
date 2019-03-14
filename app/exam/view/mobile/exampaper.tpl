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
				<div class="text-center">模拟考试</div>
			</a>
			<a class="col-xs-2">
				<div class="text-center">
					<i class="glyphicon glyphicon-option-horizontal"></i>
				</div>
			</a>
		</div>
		<div class="pages-content">
			<div class="pages-box">
                {x2;if:$papers}
				<div class="page-ele clear margin">
					{x2;tree:$papers,paper,pid}
					<div class="col-xs-6">
						<div class="cards">
							<a class="ajax" data-page="yes" data-title="{x2;v:paper['papername']}" href="index.php?exam-mobile-exampaper-selectquestions&paperid={x2;v:paper['paperid']}">
								<div class="text-center col-xs-12 clear">
									<img src="public/static/images/icon.jpg" class="img-circle" style="width: 48%;"/>
								</div>
								<div class="text-center clear">
									<h5 class="title range">{x2;substring:v:paper['papername'],63}</h5>
									<p>
										总分：{x2;v:paper['papersetting']['score']}分
									</p>
									<p>
										时间：{x2;v:paper['papersetting']['papertime']}分钟
									</p>
								</div>
							</a>
						</div>
					</div>
					{x2;endtree}
				</div>
				{x2;else}
				<div class="page-ele margin">
					<ul class="listmenu">
						<li>目前没有试卷</li>
					</ul>
				</div>
                {x2;endif}
			</div>
		</div>
	</div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}