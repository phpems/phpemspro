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
				{x2;if:$status['status']}
				<a class="col-xs-2 ajax" href="index.php?exam-mobile">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
				{x2;else}
				<a class="col-xs-2 ajax" href="index.php?exam-mobile-basic-open">
					<div class="text-center">
						<i class="glyphicon glyphicon-shopping-cart"></i>
					</div>
				</a>
				{x2;endif}
			</div>
			<div class="pages-content" data-refresh="yes">
				<div class="pages-box nopadding">
					<div class="page-ele">
						<div class="col-xs-1">
						</div>
						<div class="col-xs-10">
							<div style="width:3.85rem;height:2rem;" id="exam-charts"></div>
						</div>
						<div class="col-xs-1">
						</div>
					</div>
					<div class="page-ele">
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
				</div>
				<div class="pages-box">
					<div class="page-ele clear" style="overflow: hidden;">
						<div class="col-xs-6">
							<div class="cards">
								<a href="index.php?exam-mobile-point" class="ajax">
									<div class="col-xs-4" style="padding-top: 0.15rem;">
										<img src="public/static/images/exercise.png" style="width: 100%;"/>
									</div>
									<div class="col-xs-8">
										<h5 class="title">章节练习</h5>
										<p>
											海量题库 快速背题
										</p>
									</div>
								</a>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="cards">
								<a href="index.php?exam-mobile-exampaper" class="ajax">
									<div class="col-xs-4" style="padding-top: 0.15rem;">
										<img src="public/static/images/mokao.png" style="width: 100%;"/>
									</div>
									<div class="col-xs-8">
										<h5 class="title">模拟考试</h5>
										<p>
											模拟考试 随时检测
										</p>
									</div>
								</a>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="cards">
								<a href="index.php?exam-mobile-history" class="ajax">
									<div class="col-xs-4" style="padding-top: 0.15rem;">
										<img src="public/static/images/history.png" style="width: 100%;"/>
									</div>
									<div class="col-xs-8">
										<h5 class="title">考试记录</h5>
										<p>
											模考记录 温故知新
										</p>
									</div>
								</a>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="cards">
								<a href="index.php?exam-mobile-stats" class="ajax">
									<div class="col-xs-4" style="padding-top: 0.15rem;">
										<img src="public/static/images/stats.png" style="width: 100%;"/>
									</div>
									<div class="col-xs-8">
										<h5 class="title">统计分析</h5>
										<p>
											成绩统计 进度分析
										</p>
									</div>
								</a>
							</div>
						</div>
						{x2;if:$basic['basicbook']}
						<div class="col-xs-6">
							<div class="cards">
								<a data-page="yes" data-title="考试大纲" href="index.php?content-mobile-category&catid={x2;$basic['basicbook']}" class="ajax">
									<div class="col-xs-4" style="padding-top: 0.15rem;">
										<img src="public/static/images/dagang.png" style="width: 100%;"/>
									</div>
									<div class="col-xs-8">
										<h5 class="title">考试大纲</h5>
										<p>
											教材大纲 电子课件
										</p>
									</div>
								</a>
							</div>
						</div>
						{x2;endif}
						<div class="col-xs-6">
							<div class="cards">
								<a href="index.php?exam-mobile-clear" class="ajax">
									<div class="col-xs-4" style="padding-top: 0.15rem;">
										<img src="public/static/images/shanchu.png" style="width: 100%;"/>
									</div>
									<div class="col-xs-8">
										<h5 class="title">记录删除</h5>
										<p>
											清理记录 重新开始
										</p>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="pages-footer">
				<a class="col-xs-3 active navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-list-alt"></span><br />练习
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-remove-circle"></span><br />错题
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-heart"></span><br />收藏
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-pencil"></span><br />笔记
				</div></a>
			</div>
		</div>
		<div class="pages-tabs">
			<div class="pages-header">
				<a class="col-xs-2" href="javascript:history.back();"><div class="text-center">
					<i class="glyphicon glyphicon glyphicon-menu-left"></i>
				</div></a>
				<a class="col-xs-8 active">
					<div class="text-center">{x2;$basic['basic']}</div>
				</a>
                {x2;if:$status['status']}
				<a class="col-xs-2 ajax" href="index.php?exam-mobile">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
                {x2;else}
				<a class="col-xs-2 ajax" href="index.php?exam-mobile-basic-open">
					<div class="text-center">
						<i class="glyphicon glyphicon-shopping-cart"></i>
					</div>
				</a>
                {x2;endif}
			</div>
			<div class="pages-content">
				<div class="pages-box">
					<div class="page-ele margin">
						<ul class="listmenu">
                            {x2;tree:$basic['basicsections'],section,sid}
							<li class="small">
								<a class="ajax" data-page="yes" data-title="{x2;$sections[v:section]['sectionname']}" href="index.php?exam-mobile-favor-wrong&sectionid={x2;v:section}">
									<div class="col-xs-11">
										<p class="title">
                                            {x2;$sections[v:section]['sectionname']}
										</p>
										<div class="clear">
											共{x2;$wrong[v:section]}道错题
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
			<div class="pages-footer">
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-list-alt"></span><br />练习
				</div></a>
				<a class="col-xs-3 active navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-remove-circle"></span><br />错题
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-heart"></span><br />收藏
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-pencil"></span><br />笔记
				</div></a>
			</div>
		</div>
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
			<div class="pages-content">
				<div class="pages-box">
					<div class="page-ele margin">
						<ul class="listmenu">
                            {x2;tree:$basic['basicsections'],section,sid}
							<li class="small">
								<a class="ajax" data-page="yes" data-title="{x2;$sections[v:section]['sectionname']}" href="index.php?exam-mobile-favor-index&sectionid={x2;v:section}">
									<div class="col-xs-11">
										<p class="title">
                                            {x2;$sections[v:section]['sectionname']}
										</p>
										<div class="clear">
											共收藏{x2;$favor[v:section]}道试题
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
			<div class="pages-footer">
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-list-alt"></span><br />练习
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-remove-circle"></span><br />错题
				</div></a>
				<a class="col-xs-3 active navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-heart"></span><br />收藏
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-pencil"></span><br />笔记
				</div></a>
			</div>
		</div>
		<div class="pages-tabs">
			<div class="pages-header">
				<a class="col-xs-2" href="javascript:history.back();"><div class="text-center">
					<i class="glyphicon glyphicon glyphicon-menu-left"></i>
				</div></a>
				<a class="col-xs-8 active">
					<div class="text-center">{x2;$basic['basic']}</div>
				</a>
                {x2;if:$status['status']}
				<a class="col-xs-2 ajax" href="index.php?exam-mobile">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
                {x2;else}
				<a class="col-xs-2 ajax" href="index.php?exam-mobile-basic-open">
					<div class="text-center">
						<i class="glyphicon glyphicon-shopping-cart"></i>
					</div>
				</a>
                {x2;endif}
			</div>
			<div class="pages-content">
				<div class="pages-box">
					<div class="page-ele margin">
						<ul class="listmenu">
                            {x2;tree:$basic['basicsections'],section,sid}
							<li class="small">
								<a class="ajax" data-page="yes" data-title="{x2;$sections[v:section]['sectionname']}" href="index.php?exam-mobile-favor-note&sectionid={x2;v:section}">
									<div class="col-xs-11">
										<p class="title">
                                            {x2;$sections[v:section]['sectionname']}
										</p>
										<div class="clear">
											共{x2;$note[v:section]}道试题笔记
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
			<div class="pages-footer">
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-list-alt"></span><br />练习
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-remove-circle"></span><br />错题
				</div></a>
				<a class="col-xs-3 navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-heart"></span><br />收藏
				</div></a>
				<a class="col-xs-3 active navibutton"><div class="text-center">
					<span class="glyphicon glyphicon-pencil"></span><br />笔记
				</div></a>
			</div>
		</div>
		<script>
            $(function(){
                $('body').delegate('.pages-footer .navibutton','click',function(){
                    var _this = $(this);
                    var index = _this.index();
                    _this.parents('.pages').find('.pages-tabs').hide().eq(index).show();
                });
                var option = {
                    legend: {
                        orient: 'vertical',
                        x: 'left',
						bottom:0,
						show:true,
                        data:['正确率','学习进度']
                    },
                    series: [
                        {
                            type:'pie',
                            radius: ['30%', '45%'],
                            avoidLabelOverlap: false,
                            labelLine: {
                                normal: {
                                    show: false
                                }
                            },
                            silent:true,
                            data:[
                                {
                                    value:{x2;$allnumber['right']},
									name:'正确率',
									label: {
                                        position:'center',
                                        formatter:'{a|{x2;if:$allnumber['right']}{x2;eval: echo intval(100*$allnumber['right']/($allnumber['right']+$allnumber['wrong']))}{x2;else}0{x2;endif}%}',
                                        rich:{
                                            a:{
                                                fontSize:'16'
                                            }
                                        }
                                    },
                                    itemStyle:{
                                        color:'#D84C29'
                                    }
								},
                                {
                                    value:{x2;if:$allnumber['right']}{x2;$allnumber['wrong']}{x2;else}1{x2;endif},
									itemStyle:{
                                        color:'#F5F5F5'
                                    }
                                }
                            ]
                        },
                        {
                            type:'pie',
                            radius: ['65%', '80%'],
                            avoidLabelOverlap: false,
                            silent:true,
                            data:[
                                {
                                    value:{x2;eval: echo $allnumber['right']+$allnumber['wrong']},
									name:'学习进度',
									label: {
                                        position:'outside',
                                        align:'center',
                                        verticalAlign:'top',
                                        formatter:'{a|{x2;if:($allnumber['right']+$allnumber['wrong']) > 0}{x2;eval: echo intval(100*($allnumber['right']+$allnumber['wrong'])/$allnumber['all'])}{x2;else}0{x2;endif}%}',
                                        rich:{
                                            a:{
                                                fontSize:'16'
                                            }
                                        }
                                    },
                                    labelLine: {
                                        normal: {
                                            show: true
                                        }
                                    },
                                    itemStyle:{
                                        color:'#02756E'
                                    }
								},
                                {
                                    {x2;eval: v:n = $allnumber['all'] - $allnumber['right'] - $allnumber['wrong']}
                                    value:{x2;if:($allnumber['right'] + $allnumber['wrong']) > 0}{x2;v:n}{x2;else}1{x2;endif},
                                    labelLine: {
                                        normal: {
                                            show: false
                                        }
                                    },
									itemStyle:{
                                        color:'#F5F5F5'
                                    }
                                }
                            ]
                        }
                    ]
                };
                echarts.init($('#exam-charts')[0]).setOption(option);
            });
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}