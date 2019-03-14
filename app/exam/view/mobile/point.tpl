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
					<div class="text-center">{x2;$basic['basic']}</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter" data-refresh="yes">
				<div class="pages-box">
					<div class="page-ele radius margin">
						<div class="col-xs-1" style="padding-top: 0.15rem;">
							<i class="glyphicon glyphicon-repeat"></i>
						</div>
						<div class="col-xs-8" style="padding-top: 0.15rem;">
                            {x2;if:$point}
							<marquee>上次做到《{x2;$point['pointname']}》第{x2;$index}题</marquee>
                            {x2;else}
							您尚未做题
                            {x2;endif}
						</div>
                        {x2;if:$point}
                        <div class="col-xs-3">
							<a href="index.php?exam-mobile-point-paper&pointid={x2;$point['pointid']}" data-page="yes" data-title="{x2;$point['pointname']}" class="btn btn-primary pull-right ajax" style="border-radius: 0.17rem;">继续做题</a>
						</div>
                        {x2;endif}
					</div>
					<div class="page-ele">
						<ul class="listmenu">
							{x2;tree:$basic['basicsections'],section,sid}
							<li class="small">
								<a class="ajax" data-page="yes" data-title="{x2;$sections[v:section]['sectionname']}" href="index.php?exam-mobile-point-points&sectionid={x2;v:section}">
									<div class="col-xs-11">
										<p class="title">
											{x2;$sections[v:section]['sectionname']}
										</p>
										<div class="clear">
											进度：{x2;$right[v:section]}/{x2;$numbers[v:section]} 正确率：{x2;$rate[v:section]}%
										</div>
									</div>
									<div class="col-xs-1">
										<i class="glyphicon glyphicon-menu-right pull-right"></i>
									</div>
								</a>
							</li>
							{x2;endtree}
						</ul>
					</div>
				</div>
			</div>
		</div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}