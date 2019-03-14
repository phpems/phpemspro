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
					<div class="text-center">{x2;$history['ehexam']}</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content">
				<div class="swiper-container">
					<input type="hidden" id="lastquestion" name="lastquestion" />
					<div class="swiper-wrapper">
						{x2;tree:$history['ehsetting']['papersetting']['questypelite'],lite,lid}
						{x2;eval:v:questype = v:key}
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
                                {x2;if:$setting['selectormodel']}
								<div class="clear question">
                                    {x2;if:$questypes[v:question['questiontype']]['questsort']}

									{x2;else}
                                    {x2;if:$questypes[v:question['questiontype']]['questchoice'] == 4}
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="A"><span class="selector">A</span>
										</label>
										<p>对</p>
									</div>
									<hr/>
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="B"><span class="selector">B</span>
										</label>
										<p>错</p>
									</div>
                                    {x2;else}
                                    {x2;eval:v:question['questionselect'] = \strings::parseSelector(v:question['questionselect'])}
                                    {x2;tree:v:question['questionselect'],selector,sid}
                                    {x2;if:$questypes[v:question['questiontype']]['questchoice'] == 1}
                                    {x2;if:v:key}<hr/>{x2;endif}
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="{x2;v:selector[0]}"><span class="selector">{x2;v:selector[0]}</span>
										</label>
                                        {x2;v:selector[1]}
									</div>
                                    {x2;elseif:$questypes[v:question['questiontype']]['questchoice'] == 2 || $questypes[v:question['questiontype']]['questchoice'] == 3}
                                    {x2;if:v:key}<hr/>{x2;endif}
									<div style="clear: both">
										<label class="selectbox checkbox float">
											<input type="checkbox" name="question[{x2;v:question['questionid']}][]" value="{x2;v:selector[0]}"><span class="selector">{x2;v:selector[0]}</span>
										</label>
                                        {x2;v:selector[1]}
									</div>
                                    {x2;endif}
                                    {x2;if:v:sid >= v:question['questionselectnumber']}
                                    {x2;eval:break}
                                    {x2;endif}
                                    {x2;endtree}
                                    {x2;endif}
                                    {x2;endif}
								</div>
                                {x2;else}
								<div class="clear question">
                                    {x2;tree:$setting['selectortype'],selector,sid}
                                    {x2;if:$questypes[v:question['questiontype']]['questchoice'] == 1}
                                    {x2;eval:v:question['questionselect'] = str_replace('[['.v:selector.']]','<label class="selectbox radio"><input type="radio" value="'.v:selector.'" name="question['.v:question['questionid'].']"><span class="selector">'.v:selector.'</span></label>',v:question['questionselect'])}
                                    {x2;elseif:$questypes[v:question['questiontype']]['questchoice'] == 2 || $questypes[v:question['questiontype']]['questchoice'] == 3}
                                    {x2;eval:v:question['questionselect'] = str_replace('[['.v:selector.']]','<label class="selectbox checkbox"><input type="checkbox" value="'.v:selector.'" name="question['.v:question['questionid'].'][]"><span class="selector">'.v:selector.'</span></label>',v:question['questionselect'])}
                                    {x2;endif}
                                    {x2;if:v:sid >= v:question['questionselectnumber']}
                                    {x2;eval:break}
                                    {x2;endif}
                                    {x2;endtree}
                                    {x2;if:$questypes[v:question['questiontype']]['questsort']}
									<textarea class="form-control" rows="5" name="question[{x2;v:question['questionid']}]"></textarea>
                                    {x2;else}
                                    {x2;if:in_array($questypes[v:question['questiontype']]['questchoice'],array(1,2,3))}
                                    {x2;v:question['questionselect']}
                                    {x2;elseif:$questypes[v:question['questiontype']]['questchoice'] == 4}
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="A"><span class="selector">A</span>
										</label>
										<p>对</p>
									</div>
									<hr/>
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="B"><span class="selector">B</span>
										</label>
										<p>错</p>
									</div>
                                    {x2;else}
                                    {x2;endif}
                                    {x2;endif}
								</div>
                                {x2;endif}
							</div>
                            {x2;if:$questypes[v:question['questiontype']]['questsort']}
							<div class="page-ele radius">
								<h5 class="bigtitle col-xs-12">我的答案</h5>
								<div>
                                    {x2;$history['ehuseranswer'][v:question['questionid']]}
								</div>
							</div>
							{x2;endif}
							<div class="page-ele radius">
								<h5 class="bigtitle col-xs-12">参考答案</h5>
								<div class="clear question">
									{x2;v:question['questionanswer']}
								</div>
							</div>
							<div class="page-ele radius">
								<h5 class="bigtitle col-xs-12">解析</h5>
								<div class="clear question">
                                    {x2;if:v:question['questionintro']}
                                    {x2;v:question['questionintro']}
                                    {x2;else}
									本题暂无解析
                                    {x2;endif}
								</div>
							</div>
						</div>

						{x2;endtree}
						{x2;endif}
                        {x2;if:$history['ehquestion']['questionrows'][v:questype]}
						{x2;tree:$history['ehquestion']['questionrows'][v:questype],questionrows,qrid}
						{x2;tree:v:questionrows['data'],question,qid}
                        {x2;eval:v:innerquestionindex ++;}

						<div class="pages-box swiper-slide" data-questionid="{x2;v:question['questionid']}"{x2;if:$history['ehuseranswer'][v:question['questionid']] && !$questypes[v:question['questiontype']]['questsort']} data-useranswer="{x2;$history['ehuseranswer'][v:question['questionid']]}"{x2;endif} {x2;if:$questypes[v:question['questiontype']]['questsort']}data-sort="1" data-answer="A"{x2;else}data-sort="0" data-answer="{x2;v:question['questionanswer']}"{x2;endif}{x2;if:$favors[v:question['questionid']]} data-favor="1"{x2;endif}>
							<div class="page-ele radius margin">
								<h5 class="bigtitle col-xs-12">{x2;v:qid}/{x2;$history['ehsetting']['papersetting']['questype'][v:questype]['number']} {x2;$questypes[v:questionrows['qrtype']]['questype']}（{x2;$questypes[v:question['questiontype']]['questype']}）</h5>
                                <div class="clear question">
                                    {x2;v:questionrows['qrquestion']}
								</div>
								<div class="clear question">
                                    {x2;v:question['question']}
								</div>
                                {x2;if:$setting['selectormodel']}
								<div class="clear question">
                                    {x2;if:$questypes[v:question['questiontype']]['questsort']}
                                    {x2;else}
                                    {x2;if:$questypes[v:question['questiontype']]['questchoice'] == 4}
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="A"><span class="selector">A</span>
										</label>
										<p>对</p>
									</div>
									<hr/>
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="B"><span class="selector">B</span>
										</label>
										<p>错</p>
									</div>
                                    {x2;else}
                                    {x2;eval:v:question['questionselect'] = \strings::parseSelector(v:question['questionselect'])}
                                    {x2;tree:v:question['questionselect'],selector,sid}
                                    {x2;if:$questypes[v:question['questiontype']]['questchoice'] == 1}
                                    {x2;if:v:key}<hr/>{x2;endif}
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="{x2;v:selector[0]}"><span class="selector">{x2;v:selector[0]}</span>
										</label>
                                        {x2;v:selector[1]}
									</div>
                                    {x2;elseif:$questypes[v:question['questiontype']]['questchoice'] == 2 || $questypes[v:question['questiontype']]['questchoice'] == 3}
                                    {x2;if:v:key}<hr/>{x2;endif}
									<div style="clear: both">
										<label class="selectbox checkbox float">
											<input type="checkbox" name="question[{x2;v:question['questionid']}][]" value="{x2;v:selector[0]}"><span class="selector">{x2;v:selector[0]}</span>
										</label>
                                        {x2;v:selector[1]}
									</div>
                                    {x2;endif}
                                    {x2;if:v:sid >= v:question['questionselectnumber']}
                                    {x2;eval:break}
                                    {x2;endif}
                                    {x2;endtree}
                                    {x2;endif}
                                    {x2;endif}
                                    {x2;if:in_array($questypes[v:question['questiontype']]['questchoice'],array(2,3))}
									<div class="text-center hide">
										<a class="btn btn-primary finishbtn">回答完毕</a>
									</div>
                                    {x2;endif}
								</div>
                                {x2;else}
								<div class="clear question">
                                    {x2;tree:$setting['selectortype'],selector,sid}
                                    {x2;if:$questypes[v:question['questiontype']]['questchoice'] == 1}
                                    {x2;eval:v:question['questionselect'] = str_replace('[['.v:selector.']]','<label class="selectbox radio"><input type="radio" value="'.v:selector.'" name="question['.v:question['questionid'].']"><span class="selector">'.v:selector.'</span></label>',v:question['questionselect'])}
                                    {x2;elseif:$questypes[v:question['questiontype']]['questchoice'] == 2 || $questypes[v:question['questiontype']]['questchoice'] == 3}
                                    {x2;eval:v:question['questionselect'] = str_replace('[['.v:selector.']]','<label class="selectbox checkbox"><input type="checkbox" value="'.v:selector.'" name="question['.v:question['questionid'].'][]"><span class="selector">'.v:selector.'</span></label>',v:question['questionselect'])}
                                    {x2;endif}
                                    {x2;if:v:sid >= v:question['questionselectnumber']}
                                    {x2;eval:break}
                                    {x2;endif}
                                    {x2;endtree}
                                    {x2;if:$questypes[v:question['questiontype']]['questsort']}
									<div style="clear: both">
										<h5 class="bigtitle">我的答案</h5>
										<div>
											{x2;$history['ehuseranswer'][v:question['questionid']]}
										</div>
									</div>
                                    {x2;else}
                                    {x2;if:in_array($questypes[v:question['questiontype']]['questchoice'],array(2,3))}
                                    {x2;v:question['questionselect']}
									<div class="text-center hide">
										<a class="btn btn-primary finishbtn">回答完毕</a>
									</div>
                                    {x2;elseif:$questypes[v:question['questiontype']]['questchoice'] == 1}
                                    {x2;v:question['questionselect']}
                                    {x2;elseif:$questypes[v:question['questiontype']]['questchoice'] == 4}
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="A"><span class="selector">A</span>
										</label>
										<p>对</p>
									</div>
									<hr/>
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="B"><span class="selector">B</span>
										</label>
										<p>错</p>
									</div>
                                    {x2;else}
                                    {x2;endif}
                                    {x2;endif}
								</div>
                                {x2;endif}
							</div>
                            {x2;if:$questypes[v:question['questiontype']]['questsort']}
							<div class="page-ele radius">
								<h5 class="bigtitle col-xs-12">我的答案</h5>
								<div>
                                    {x2;$history['ehuseranswer'][v:question['questionid']]}
								</div>
							</div>
                            {x2;endif}
							<div class="page-ele radius">
								<h5 class="bigtitle col-xs-12">参考答案</h5>
								<div class="clear question">
                                    {x2;v:question['questionanswer']}
								</div>
							</div>
							<div class="page-ele radius">
								<h5 class="bigtitle col-xs-12">解析</h5>
								<div class="clear question">
                                    {x2;if:v:question['questionintro']}
                                    {x2;v:question['questionintro']}
                                    {x2;else}
									本题暂无解析
                                    {x2;endif}
								</div>
							</div>
						</div>

						{x2;endtree}
						{x2;endtree}
                        {x2;endif}
						{x2;endif}
						{x2;endtree}
					</div>
				</div>
			</div>
			<div class="pages-content hide">
				<div class="pages-box">
					<div class="page-ele radius margin">
						<div class="clear question">
                            {x2;eval:v:qtid = 0}
							{x2;tree:$history['ehsetting']['papersetting']['questypelite'],lite,lid}
                            {x2;eval:v:qtindex = 0}
                            {x2;eval:v:questype = v:key}
                            {x2;if:$history['ehquestion']['questions'][v:questype] || $history['ehquestion']['questionrows'][v:questype]}
							<h5 class="bigtitle col-xs-12">{x2;$questypes[v:questype]['questype']}</h5>
                            {x2;if:$history['ehquestion']['questions'][v:questype]}
							{x2;tree:$history['ehquestion']['questions'][v:questype],question,qid}
                            {x2;eval:v:qtid++}
                            {x2;eval:v:qtindex++}
							<label class="selectbox col-xs-2 questionindex" data-index="{x2;v:qtid}" data-questionid="{x2;v:question['questionid']}">
								<span class="selector{x2;if:$history['ehscorelist'][v:question['questionid']] != $history['ehsetting']['papersetting']['questype'][v:questype]['score']} sign{x2;endif}">{x2;v:qtindex}</span>
							</label>
                            {x2;endtree}
							{x2;endif}
                            {x2;if:$history['ehquestion']['questionrows'][v:questype]}
                            {x2;tree:$history['ehquestion']['questionrows'][v:questype],questionrows,qrid}
							{x2;tree:v:questionrows['data'],question,qid}
                            {x2;eval:v:qtid++}
                            {x2;eval:v:qtindex++}
							<label class="selectbox col-xs-2 questionindex" data-index="{x2;v:qtid}" data-questionid="{x2;v:question['questionid']}">
								<span class="selector{x2;if:$history['ehscorelist'][v:question['questionid']] != $history['ehsetting']['papersetting']['questype'][v:questype]['score']} sign{x2;endif}">{x2;v:qtindex}</span>
							</label>
                            {x2;endtree}
                            {x2;endtree}
							{x2;endif}
							{x2;endif}
                            {x2;endtree}
						</div>
					</div>
				</div>
			</div>
			<div class="pages-footer">
				<a class="col-xs-3">
					<div class="text-center">
						<span class="glyphicon glyphicon-heart"></span><br />收藏
					</div>
				</a>
				<a class="col-xs-3">
					<div class="text-center">
						<span class="glyphicon glyphicon-pencil"></span><br />笔记
					</div>
				</a>
				<a class="col-xs-3">
					<div class="text-center">
						<span class="glyphicon glyphicon-list-alt"></span><br />题卡
					</div>
				</a>
				<a class="col-xs-3">
					<div class="text-center">
						<span class="glyphicon glyphicon-equalizer"></span><br />计算器
					</div>
				</a>
			</div>
		</div>
		<script>
            $(function() {
                var mySwiper = new Swiper('.swiper-container', {
                    'preventClicks':false,
                    "loop": false,
                    "autoplay": 0,
                    "observer": true,
                    "observeParents": true,
                    'onInit':function(swiper){
                        var page = $(swiper.slides[swiper.activeIndex]);
                        if(page.attr('data-favor') == 1)
                        {
                            $('.pages-footer a').eq(0).addClass('active');
                        }
                        else
                        {
                            $('.pages-footer a').eq(0).removeClass('active');
                        }
                    },
                    "onSlideChangeEnd": function (swiper) {
                        var page = $(swiper.slides[swiper.activeIndex]);
                        if(page.attr('data-favor') == 1)
                        {
                            $('.pages-footer a').eq(0).addClass('active');
                        }
                        else
                        {
                            $('.pages-footer a').eq(0).removeClass('active');
                        }
                        $('#lastquestion').val(swiper.activeIndex);
                    }
                });
                $('.pages-footer:first a').eq(2).on('click',function(){
                    $('.pages-content:first').toggleClass('hide');
                    $('.pages-content:last').toggleClass('hide');
                    $(this).toggleClass('active');
                });
                $('.questionindex').on('click',function(){
                    $('.pages-content:first').toggleClass('hide');
                    $('.pages-content:last').toggleClass('hide');
                    $('.pages-footer:first a').eq(2).toggleClass('active');
                    mySwiper.slideTo($(this).attr('data-index') - 1,0);
                });
                $('.selectbox.radio .selector').on('click',function(){
                    var parent = $(this).parents('.pages-box:first');
                    var _this = $(this);
                    _this.removeClass('right').removeClass('wrong');
                    parent.find('.page-ele').removeClass('hide');
                    parent.find('.myanswer').html(_this.parent().find('input:first').val());
                    if(_this.parent().find('input:first').val() == parent.attr('data-answer'))
                    {
                        _this.addClass('right');
                    }
                    else
                    {
                        _this.addClass('wrong');
                    }
                });
                $('.selectbox.checkbox .selector').on('click',function(){
                    var parent = $(this).parents('.pages-box:first');
                    var _this = $(this);
                    parent.find('.selector').removeClass('right').removeClass('wrong');
                });
                $('.finishbtn').on('click',function(){
                    var parent = $(this).parents('.pages-box:first');
                    var _this = $(this);
                    if(parent.find('input:checked').length < 1)
                    {
                        pep.mask.show('tips',{'message':'请选择一个答案'});
                        return false;
                    }
                    parent.find('.selector').removeClass('right').removeClass('wrong');
                    $(this).parent().addClass('hide');
                    var answer = '';
                    parent.find('input:checked').each(function(){
                        answer += $(this).val();
                        if(parent.attr('data-answer').indexOf($(this).val()) >= 0)
                        {
                            $(this).parent().find('.selector').addClass('right');
                        }
                        else
                        {
                            $(this).parent().find('.selector').addClass('wrong');
                        }
                    });
                    parent.find('.page-ele').removeClass('hide');
                    parent.find('.myanswer').html(answer);
                });
                $('.swiper-slide').each(function(){
                    var _this = $(this);
                    if(pep.isTrueVar(_this.attr('data-useranswer')))
                    {
                        if(_this.attr('data-useranswer').length == 1)
                        {
                            _this.find('input[value="'+_this.attr('data-useranswer')+'"]').parent().find('.selector').trigger('click');
                        }
                        else
                        {
                            var tmp = _this.attr('data-useranswer').split('');
                            for(x in tmp)
                            {
                                _this.find('input[value="'+tmp[x]+'"]').parent().find('.selector').trigger('click');
                            }
                        }
                        _this.find('.finishbtn').trigger('click');
                    }
                });
                $('.pages-footer a').eq(0).on('click',function(){
                    var index = pep.isTrueVar($('#lastquestion').val())?$('#lastquestion').val():0;
                    if($(this).hasClass('active'))
                    {
                        submitAjax({'url':'index.php?exam-mobile-ajax-cancelfavor&questionid='+$(mySwiper.slides[index]).attr('data-questionid')});
                        $(this).removeClass('active');
                        $(mySwiper.slides[index]).attr('data-favor','0');
                    }
                    else
                    {
                        submitAjax({'url':'index.php?exam-mobile-ajax-favorquestion&questionid='+$(mySwiper.slides[index]).attr('data-questionid')});
                        $(this).addClass('active');
                        $(mySwiper.slides[index]).attr('data-favor','1');
                    }
                });
                $('.pages-footer a').eq(1).on('click',function(){
                    var index = pep.isTrueVar($('#lastquestion').val())?$('#lastquestion').val():0;
                    submitAjax({'url':'index.php?exam-mobile-point-note&questionid='+$(mySwiper.slides[index]).attr('data-questionid')});
                });
                $('.selectbox.radio .selector').unbind();
                $('.selectbox.checkbox .selector').unbind();
                $('.selectbox.radio .selector').on('click',function(){return false;});
                $('.selectbox.checkbox .selector').on('click',function(){return false;});
            });
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}