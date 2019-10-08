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
					<div class="text-center">{x2;$paper['name']}</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content" data-callback="savedata" data-nocache="yes">
				<form class="swiper-container" action="index.php?exam-mobile-exam-save" method="post">
					<input type="hidden" name="token" value="{x2;$paper['token']}">
					<div class="swiper-wrapper">
						{x2;tree:$paper['setting']['papersetting']['questypelite'],lite,lid}
						{x2;eval:v:questype = v:key}
						{x2;eval:v:questypeindex = 0;}
                        {x2;eval:v:innerquestionindex = 0;}
						{x2;if:$paper['question']['questions'][v:questype] || $paper['question']['questionrows'][v:questype]}
                        {x2;eval:v:questypeindex++;}
						{x2;if:$paper['question']['questions'][v:questype]}
						{x2;if:$basic['basicexam']['changesequence']}
                        {x2;eval: shuffle($paper['question']['questions'][v:questype]);}
						{x2;endif}
						{x2;tree:$paper['question']['questions'][v:questype],question,qid}
                        {x2;eval:v:innerquestionindex ++;}

						<div class="pages-box swiper-slide" data-questionid="{x2;v:question['questionid']}"{x2;if:$useranswer[v:question['questionid']]} data-useranswer="{x2;$useranswer[v:question['questionid']]}"{x2;endif} {x2;if:$questypes[v:question['questiontype']]['questsort']}data-sort="1" data-answer="A"{x2;else}data-sort="0" data-answer="{x2;v:question['questionanswer']}"{x2;endif}{x2;if:$favors[v:question['questionid']]} data-favor="1"{x2;endif}>
							<div class="page-ele radius margin">
								<h5 class="bigtitle col-xs-12">{x2;v:qid}/{x2;$paper['setting']['papersetting']['questype'][v:questype]['number']} {x2;$questypes[v:question['questiontype']]['questype']}</h5>
								<div class="clear question">
                                    {x2;v:question['question']}
								</div>
                                {x2;if:$setting['selectormodel']}
								<div class="clear question">
                                    {x2;if:$questypes[v:question['questiontype']]['questsort']}
									<textarea class="form-control" rows="5" name="question[{x2;v:question['questionid']}]"></textarea>
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
						</div>

						{x2;endtree}
						{x2;endif}
                        {x2;if:$paper['question']['questionrows'][v:questype]}
                        {x2;if:$basic['basicexam']['changesequence']}
                        {x2;eval: shuffle($paper['question']['questionrows'][v:questype]);}
                        {x2;endif}
						{x2;tree:$paper['question']['questionrows'][v:questype],questionrows,qrid}
						{x2;tree:v:questionrows['data'],question,qid}
                        {x2;eval:v:innerquestionindex ++;}

						<div class="pages-box swiper-slide" data-questionid="{x2;v:question['questionid']}"{x2;if:$useranswer[v:question['questionid']]} data-useranswer="{x2;$useranswer[v:question['questionid']]}"{x2;endif} {x2;if:$questypes[v:question['questiontype']]['questsort']}data-sort="1" data-answer="A"{x2;else}data-sort="0" data-answer="{x2;v:question['questionanswer']}"{x2;endif}{x2;if:$favors[v:question['questionid']]} data-favor="1"{x2;endif}>
							<div class="page-ele radius margin">
								<h5 class="bigtitle col-xs-12">{x2;v:qid}/{x2;$paper['setting']['papersetting']['questype'][v:questype]['number']} {x2;$questypes[v:questionrows['qrtype']]['questype']}（{x2;$questypes[v:question['questiontype']]['questype']}）</h5>
                                <div class="clear question">
                                    {x2;v:questionrows['qrquestion']}
								</div>
								<div class="clear question">
                                    {x2;v:question['question']}
								</div>
                                {x2;if:$setting['selectormodel']}
								<div class="clear question">
                                    {x2;if:$questypes[v:question['questiontype']]['questsort']}
									<textarea class="form-control" rows="5" name="question[{x2;v:question['questionid']}]"></textarea>
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
						</div>

						{x2;endtree}
						{x2;endtree}
                        {x2;endif}
						{x2;endif}
						{x2;endif}
					</div>
				</form>
			</div>
			<div class="pages-content hide">
				<div class="pages-box">
					<div class="page-ele radius margin">
						<div class="clear question">
                            {x2;eval:v:qtid = 0}
							{x2;tree:$paper['setting']['papersetting']['questypelite'],lite,lid}
                            {x2;eval:v:qtindex = 0}
                            {x2;eval:v:questype = v:key}
                            {x2;if:$paper['question']['questions'][v:questype] || $paper['question']['questionrows'][v:questype]}
							<h5 class="bigtitle col-xs-12">{x2;$questypes[v:questype]['questype']}</h5>
                            {x2;if:$paper['question']['questions'][v:questype]}
							{x2;tree:$paper['question']['questions'][v:questype],question,qid}
                            {x2;eval:v:qtid++}
                            {x2;eval:v:qtindex++}
							<label class="selectbox col-xs-2 questionindex" data-index="{x2;v:qtid}" data-questionid="{x2;v:question['questionid']}">
								<span class="selector">{x2;v:qid}</span>
							</label>
                            {x2;endtree}
							{x2;endif}
                            {x2;if:$paper['question']['questionrows'][v:questype]}
                            {x2;tree:$paper['question']['questionrows'][v:questype],questionrows,qrid}
							{x2;tree:v:questionrows['data'],question,qid}
                            {x2;eval:v:qtid++}
                            {x2;eval:v:qtindex++}
							<label class="selectbox col-xs-2 questionindex" data-index="{x2;v:qtid}" data-questionid="{x2;v:question['questionid']}">
								<span class="selector">{x2;v:qrid}.{x2;v:qid}</span>
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
				<a class="col-xs-4">
					<div class="text-center" style="font-size: 0.24rem;line-height: 0.36rem;">
						<span id="exampaper-timer_h">00</span>:<span id="exampaper-timer_m">00</span>:<span id="exampaper-timer_s">00</span>
					</div>
				</a>
				<a class="col-xs-4" style="padding: 0.025rem;">
					<div class="text-center">
						<span class="btn btn-primary subpaperbtn">交卷</span>
					</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<span class="glyphicon glyphicon-list-alt"></span><br />题卡
					</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<span class="glyphicon glyphicon-equalizer"></span><br />标记
					</div>
				</a>
			</div>
		</div>
		<script>
			var savedata = function(){
				pep.mask.show('tips',{message:'请先交卷'});
                history.pushState({id:'index.php?exam-mobile-exam-paper'},'{x2;$paper['name']}','index.php?exam-mobile-exam-paper');
			}
			$(function() {
				var clock = null;
			    var mySwiper = new Swiper('.swiper-container', {
					'preventClicks':false,
					"loop": false,
					"autoplay": 0,
					"observer": true,
					"observeParents": true,
                    'onInit':function(swiper){
                        var page = $(swiper.slides[swiper.activeIndex]);
                        if(page.attr('data-sign') == 1)
                        {
                            $('.pages-footer a').eq(3).addClass('active');
                        }
                        else
                        {
                            $('.pages-footer a').eq(3).removeClass('active');
                        }
                        $('.pages-content:first').attr('data-index',swiper.activeIndex);
                    },
                    "onSlideChangeEnd": function (swiper) {
                        var page = $(swiper.slides[swiper.activeIndex]);
                        if(page.attr('data-sign') == 1)
                        {
                            $('.pages-footer a').eq(3).addClass('active');
                        }
                        else
                        {
                            $('.pages-footer a').eq(3).removeClass('active');
                        }
                        $('.pages-content:first').attr('data-index',swiper.activeIndex);
                    }
				});
                $('.pages-footer:first a').eq(1).on('click',function(){
                    pep.mask.show('confirm',{'message':'确定交卷吗？'},function(){
                        $('.pages-content:first').find('form').submit();
					});
                });
				$('.pages-footer:first a').eq(2).on('click',function(){
					$('.pages-content:first').toggleClass('hide');
                    $('.pages-content:last').toggleClass('hide');
                    $(this).toggleClass('active');
				});
                $('.pages-footer:first a').eq(3).on('click',function(){
                    var parent = $(mySwiper.slides[$('.pages-content:first').attr('data-index')]);
                    var _this = $(this);
                    $.pp = parent;
                    $('.questionindex').eq($('.pages-content:first').attr('data-index')).find('.selector').toggleClass('sign');
                    _this.toggleClass('active');
                    if(parent.attr('data-sign') == '1')
					{
                        parent.attr('data-sign','0');
					}
					else
					{
                        parent.attr('data-sign','1');
					}
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
					$('.questionindex').eq(parent.index()).find('.selector').addClass('selected');
				});
                $('.selectbox.checkbox .selector').on('click',function(){
                    var parent = $(this).parents('.pages-box:first');
                    var _this = $(this);
                    $('.questionindex').eq(parent.index()).find('.selector').addClass('selected');
                });
                $('.selectbox.radio .selector').parent().siblings().on('click',function(){
					$(this).parent().find('.selector').trigger('click');
				});
                $('.selectbox.checkbox .selector').parent().siblings().on('click',function(){
                    $(this).parent().find('.selector').trigger('click');
                });
                $.get('index.php?exam-mobile-exam-lefttime&rand'+Math.random(),function(data){
                    var setting = {
                        time:{x2;$paper['time']},
                        hbox:$("#exampaper-timer_h"),
                        mbox:$("#exampaper-timer_m"),
                        sbox:$("#exampaper-timer_s"),
                        finish:function(){
                            $('.pages-content:first').find('form').submit();
                        }
                    }
                    setting.lefttime = parseInt(data);
                    clock = countdown(setting);
                });
                setInterval(saveanswer,271000);
                pep.clock.countdown = setInterval(function(){
                    $.get('index.php?exam-mobile-exam-lefttime&rand'+Math.random(),function(data){
                        clock(data);
                    });
                },179000);
			});
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}