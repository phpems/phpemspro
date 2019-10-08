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
				<div class="text-center">正式考试</div>
			</a>
			<a class="col-xs-2 ajax" href="index.php?exam-mobile-exam-history">
				<div class="text-center">
					<i class="glyphicon glyphicon-option-horizontal"></i>
				</div>
			</a>
		</div>
		<div class="pages-content">
			<div class="pages-box">
				<div class="page-ele margin">
					<h3 class="text-center">考试须知</h3>
					<p>
						考试须知
					</p>
				</div>
                {x2;if:$basic['basicexam']['opentime']['start'] > TIME}
				<div class="page-ele margin">
					<p class="alert alert-danger">
						考试将在{x2;date:$basic['basicexam']['opentime']['start'],'Y-m-d H:i:s'}开启，请稍候！
					</p>
				</div>
                {x2;else}
				{x2;if:$papers}
				<div class="page-ele clear margin">
                    {x2;if:$basic['basicexam']['selectrule']}
					<p class="text-center">
						<a class="btn btn-primary ajax btn-block" href="index.php?exam-mobile-exam-selectquestions">开始考试</a>
					</p>
                    {x2;else}
					{x2;tree:$papers,paper,pid}
					<div class="col-xs-6">
						<div class="cards">
							<a class="ajax" data-page="yes" data-title="{x2;v:paper['papername']}" href="index.php?exam-mobile-exam-selectquestions&paperid={x2;v:paper['paperid']}">
								<div class="text-center clear">
									<h5 class="title range">{x2;substring:v:paper['papername'],63}</h5>
									<p>
										总分：{x2;v:paper['papersetting']['score']}分 <br /> 时间：{x2;v:paper['papersetting']['papertime']}分钟
									</p>
									<p>
										<span class="btn btn-primary">开始考试</span>
									</p>
								</div>
							</a>
						</div>
					</div>
					{x2;endtree}
					{x2;endif}
				</div>
				{x2;else}
				<div class="page-ele margin">
					<ul class="listmenu">
						<li>目前没有试卷</li>
					</ul>
				</div>
                {x2;endif}
                {x2;endif}
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
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}