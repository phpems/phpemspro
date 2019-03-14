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
					<div class="text-center">统计分析</div>
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
						<div style="width:100%;height:3rem;" class="exam-charts"></div>
					</div>
					<div class="page-ele">
						<h5 class="bigtitle">做题信息</h5>
						<div class="question">
							<div class="col-xs-3">
								<p class="text-center text-warning">{x2;$favor}题</p>
								<p class="text-center tiptext">收藏</p>
							</div>
							<div class="col-xs-3">
								<p class="text-center text-success">{x2;$note}题</p>
								<p class="text-center tiptext">笔记</p>
							</div>
							<div class="col-xs-3">
								<p class="text-center text-danger">{x2;eval: echo $allnumber['wrong']+$allnumber['right']}题</p>
								<p class="text-center tiptext">已做</p>
							</div>
							<div class="col-xs-3">
								<p class="text-center text-info">{x2;eval: echo $allnumber['all']}题</p>
								<p class="text-center tiptext">总题数</p>
							</div>
						</div>
                    </div>
				</div>
			</div>
		</div>
		<script>
			$(function(){
                var option = {
                    title:{
						'text':'考试趋势'
					},
                    xAxis: {
                        type: 'category',
                        data: [{x2;tree:$histories['data'],history,hid}{x2;eval: v:history['ehstarttime'] = date('m-d',strtotime(v:history['ehstarttime']));}{x2;if:v:key},'{x2;v:history['ehstarttime']}'{x2;else}'{x2;v:history['ehstarttime']}'{x2;endif}{x2;endtree}]
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                        data: [{x2;tree:$histories['data'],history,hid}{x2;if:v:key},{x2;eval:echo intval(v:history['ehscore'])}{x2;else}{x2;eval:echo intval(v:history['ehscore'])}{x2;endif}{x2;endtree}],
                        type: 'line'
                    }]
                };
                echarts.init($('.exam-charts:first')[0]).setOption(option);
			});
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}