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
					<div class="text-center">{x2;$history['name']}</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content" data-nocache="yes">
				<form class="swiper-container" action="index.php?exam-mobile-history-decide" class="form-horizontal">
					<input type="hidden" name="ehid" value="{x2;$history['ehid']}" />
					<input type="hidden" name="makedecide" value="1" />
					<div class="swiper-wrapper">
						{x2;tree:$history['ehsetting']['papersetting']['questypelite'],lite,lid}
						{x2;eval:v:questype = v:key}
						{x2;if:$needdecide[v:questype]}
						{x2;eval:v:questypeindex = 0;}
                        {x2;eval:v:innerquestionindex = 0;}
						{x2;if:$history['ehquestion']['questions'][v:questype] || $history['ehquestion']['questionrows'][v:questype]}
                        {x2;eval:v:questypeindex++;}
						{x2;if:$history['ehquestion']['questions'][v:questype]}
						{x2;tree:$history['ehquestion']['questions'][v:questype],question,qid}
                        {x2;eval:v:innerquestionindex ++;}

						<div class="pages-box swiper-slide" data-questionid="{x2;v:question['questionid']}"{x2;if:$history['ehuseranswer'][v:question['questionid']] && !$questypes[v:question['questiontype']]['questsort']} data-useranswer="{x2;$history['ehuseranswer'][v:question['questionid']]}"{x2;endif} {x2;if:$questypes[v:question['questiontype']]['questsort']}data-sort="1" data-answer="A"{x2;else}data-sort="0" data-answer="{x2;v:question['questionanswer']}"{x2;endif}{x2;if:$favors[v:question['questionid']]} data-favor="1"{x2;endif}>
							<div class="page-ele radius margin">
								<h5 class="bigtitle col-xs-12">{x2;v:qid}/{x2;$history['ehsetting']['papersetting']['questype'][v:questype]['number']} {x2;$questypes[v:question['questiontype']]['questype']}</h5>
								<div class="clear question">
                                    {x2;v:question['question']}
								</div>
								<div class="clear question">
									<div style="clear: both">
										<h5 class="bigtitle">我的答案</h5>
										<div class="col-xs-12">
                                            {x2;$history['ehuseranswer'][v:question['questionid']]}
										</div>
										<h5 class="bigtitle">参考答案</h5>
										<div class="col-xs-12">
                                            {x2;v:question['questionanswer']}
										</div>
									</div>
								</div>
							</div>
							<div class="page-ele radius">
								<div class="question form-group">
									<div class="form-inline text-center">
										评分：<input needle="needle" msg="请输入评分" size="4" class="form-control" name="score[{x2;v:question['questionid']}]" value="" />（满分{x2;$history['ehsetting']['papersetting']['questype'][v:questype]['score']}分）
									</div>
								</div>
							</div>
						</div>

						{x2;endtree}
						{x2;endif}
                        {x2;if:$history['ehquestion']['questionrows'][v:questype]}
						{x2;tree:$history['ehquestion']['questionrows'][v:questype],questionrows,qrid}
						{x2;tree:v:questionrows['data'],question,qid}
                        {x2;eval:v:innerquestionindex ++;}

						{x2;if:$questypes[v:question['questiontype']]['questsort']}
						<div class="pages-box swiper-slide" data-questionid="{x2;v:question['questionid']}"{x2;if:$history['ehuseranswer'][v:question['questionid']] && !$questypes[v:question['questiontype']]['questsort']} data-useranswer="{x2;$history['ehuseranswer'][v:question['questionid']]}"{x2;endif} {x2;if:$questypes[v:question['questiontype']]['questsort']}data-sort="1" data-answer="A"{x2;else}data-sort="0" data-answer="{x2;v:question['questionanswer']}"{x2;endif}{x2;if:$favors[v:question['questionid']]} data-favor="1"{x2;endif}>
							<div class="page-ele radius margin">
								<h5 class="bigtitle col-xs-12">{x2;v:qid}/{x2;$history['ehsetting']['papersetting']['questype'][v:questype]['number']} {x2;$questypes[v:question['questiontype']]['questype']}</h5>
                                <div class="clear question">
                                    {x2;v:questionrows['qrquestion']}
								</div>
								<div class="clear question">
                                    {x2;v:question['question']}
								</div>
								<div class="clear question">
									<div style="clear: both">
										<h5 class="bigtitle">我的答案</h5>
										<div class="col-xs-12">
                                            {x2;$history['ehuseranswer'][v:question['questionid']]}
										</div>
										<h5 class="bigtitle">参考答案</h5>
										<div class="col-xs-12">
                                            {x2;v:question['questionanswer']}
										</div>
									</div>
								</div>
							</div>
							<div class="page-ele radius">
								<div class="question form-group">
									<div class="form-inline text-center">
										评分：<input needle="needle" msg="请输入评分" size="4" class="form-control" name="score[{x2;v:question['questionid']}]" value="" />（满分{x2;$history['ehsetting']['papersetting']['questype'][v:questype]['score']}分）
									</div>
								</div>
							</div>
						</div>
						{x2;endif}

						{x2;endtree}
						{x2;endtree}
                        {x2;endif}
						{x2;endif}
						{x2;endif}
                        {x2;endtree}
					</div>
				</form>
			</div>
			<div class="pages-footer">
				<a class="col-xs-4"></a>
				<a class="col-xs-4" style="padding: 0.025rem;">
					<div class="text-center">
						<span class="btn btn-primary subpaperbtn">评分结束</span>
					</div>
				</a>
				<a class="col-xs-4"></a>
			</div>
		</div>
		<script>
            $(function() {
                var mySwiper = new Swiper('.swiper-container', {
                    'preventClicks':false,
                    "loop": false,
                    "autoplay": 0,
                    "observer": true,
                    "observeParents": true
                });
                $('.subpaperbtn').on('click',function(){
					$('.pages-content:first').find('form').submit();
                });
            });
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}