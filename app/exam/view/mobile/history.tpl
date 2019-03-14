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
					<div class="text-center">考试记录</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter">
				<div class="pages-box">
					<div class="page-ele margin">
						<ul class="listmenu">
                            {x2;tree:$histories['data'],history,sid}
							<li class="small" style="position: relative">
								<a class="ajax" data-page="yes" data-title="{x2;v:history['ehexam']}" href="index.php?exam-mobile-history-detail&ehid={x2;v:history['ehid']}">
									<div class="col-xs-12">
										<p class="title">
                                            {x2;v:history['ehexam']}
										</p>
										<div class="clear">
											得分：{x2;eval: echo intval(v:history['ehscore'])} &nbsp;&nbsp; 考试时间：{x2;v:history['ehstarttime']}
                                        </div>
									</div>
									{x2;if:v:history['ehispass']}
									<img src="public/static/images/pass.png" style="width:1rem;position: absolute;right:0.15rem;"/>
									{x2;else}
									<img src="public/static/images/notpass.png" style="width:1rem;position: absolute;right:0.15rem;"/>
									{x2;endif}
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