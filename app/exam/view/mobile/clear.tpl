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
			<div class="pages-content nofooter">
				<div class="pages-box">
					<div class="page-ele margin">
						<ul class="listmenu">
                            <li class="small">
								<a class="ajax" href="index.php?exam-mobile-clear-process">
									<div class="col-xs-11">
										<p class="title">
                                            清理练习进度
										</p>
										<div class="clear">
											清除上次做到的试题位置
										</div>
									</div>
									<div class="col-xs-1">
										<i class="glyphicon glyphicon-trash pull-right"></i>
									</div>
								</a>
							</li>
							<li class="small">
								<a class="ajax" href="index.php?exam-mobile-clear-answers">
									<div class="col-xs-11">
										<p class="title">
                                            清理已做试题
										</p>
										<div class="clear">
											清除章节练习的做题记录和答案
										</div>
									</div>
									<div class="col-xs-1">
										<i class="glyphicon glyphicon-trash pull-right"></i>
									</div>
								</a>
							</li>
							<li class="small">
								<a class="ajax" href="index.php?exam-mobile-clear-favors">
									<div class="col-xs-11">
										<p class="title">
                                            清理所有收藏
										</p>
										<div class="clear">
											删除本科目所有收藏的试题
										</div>
									</div>
									<div class="col-xs-1">
										<i class="glyphicon glyphicon-trash pull-right"></i>
									</div>
								</a>
							</li>
							<li class="small">
								<a class="ajax" href="index.php?exam-mobile-clear-notes">
									<div class="col-xs-11">
										<p class="title">
                                            清理所有笔记
										</p>
										<div class="clear">
											删除本科目所有笔记
										</div>
									</div>
									<div class="col-xs-1">
										<i class="glyphicon glyphicon-trash pull-right"></i>
									</div>
								</a>
							</li>
                        </ul>
					</div>
				</div>
			</div>
		</div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}