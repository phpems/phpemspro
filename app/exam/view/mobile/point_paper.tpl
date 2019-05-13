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
					<div class="text-center">{x2;$point['pointname']}</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content" data-callback="savedata">
				<form class="swiper-container" action="index.php?exam-mobile-point-save" method="post">
					<input type="hidden" name="pointid" value="{x2;$point['pointid']}"/>
					<input type="hidden" name="lastquestion" value="{x2;$lastquestion}" id="lastquestion"/>
					<div class="swiper-wrapper">
                        {x2;eval: v:totalnumber = count($questions) }
						{x2;eval:v:index = 0}
						{x2;tree:$questions,question,qid}
						<div class="pages-box{x2;if:v:qid <= 3} swiper-slide{x2;endif}" data-index="{x2;v:index}" data-questionid="{x2;v:question['questionid']}"{x2;if:$useranswer[v:question['questionid']]} data-useranswer="{x2;$useranswer[v:question['questionid']]}"{x2;endif} {x2;if:$questypes[v:question['questiontype']]['questsort']}data-sort="1" data-answer="A"{x2;else}data-sort="0" data-answer="{x2;v:question['questionanswer']}"{x2;endif}{x2;if:$favors[v:question['questionid']]} data-favor="1"{x2;endif}>
							{x2;eval:v:index++}
							<div class="page-ele radius margin">
								<h5 class="bigtitle col-xs-12">{x2;v:qid}/{x2;v:totalnumber} {x2;$questypes[v:question['questiontype']]['questype']}</h5>
								{x2;if:v:question['questionparent']}
								<div class="clear question">
									{x2;$parent[v:question['questionparent']]['qrquestion']}
								</div>
								{x2;endif}
								<div class="clear question">
                                    {x2;v:question['question']}
								</div>
								{x2;if:$setting['selectormodel']}
								<div class="clear question">
                                    {x2;if:$questypes[v:question['questiontype']]['questsort']}
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="A"><span class="selector">A</span>
										</label>
										<p>掌握</p>
									</div>
									<hr/>
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="B"><span class="selector">B</span>
										</label>
										<p>未掌握</p>
									</div>
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
                                    <hr/>
									<div class="text-center">
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
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="A"><span class="selector">A</span>
										</label>
										<p>掌握</p>
									</div>
									<hr/>
									<div style="clear: both">
										<label class="selectbox radio float">
											<input type="radio" name="question[{x2;v:question['questionid']}]" value="B"><span class="selector">B</span>
										</label>
										<p>未掌握</p>
									</div>
									{x2;else}
                                    {x2;if:in_array($questypes[v:question['questiontype']]['questchoice'],array(2,3))}
                                    {x2;v:question['questionselect']}
									<hr/>
									<div class="text-center">
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
							<div class="page-ele radius hide">
								<div class="clear question" style="font-size: 0.16rem">
									<div class="col-xs-6 text-center">
										习题编号<br/>
                                        {x2;v:question['questionid']}
									</div>
									<div class="col-xs-6 text-center">
										难度<br/>
                                        {x2;if:v:question['questionlevel'] == 1}易{x2;elseif:v:question['questionlevel'] == 2}中{x2;else}难{x2;endif}
									</div>
								</div>
							</div>
							{x2;else}
							<div class="page-ele radius hide">
								<div class="clear question" style="font-size: 0.16rem">
									<div class="col-xs-3 text-center">
										我的答案<br/>
										<span class="myanswer">-</span>
									</div>
									<div class="col-xs-3 text-center">
										正确答案<br/>
                                        {x2;v:question['questionanswer']}
									</div>
									<div class="col-xs-3 text-center">
										习题编号<br/>
										{x2;v:question['questionid']}
									</div>
									<div class="col-xs-3 text-center">
										难度<br/>
                                        {x2;if:v:question['questionlevel'] == 1}易{x2;elseif:v:question['questionlevel'] == 2}中{x2;else}难{x2;endif}
									</div>
								</div>
							</div>
							{x2;endif}
                            {x2;if:$questypes[v:question['questiontype']]['questsort']}
							<div class="page-ele radius hide">
								<h5 class="bigtitle col-xs-12">参考答案</h5>
								<div class="clear question">
                                    {x2;if:v:question['questionanswer']}
                                    {x2;v:question['questionanswer']}
                                    {x2;else}
									本题暂无参考答案
                                    {x2;endif}
								</div>
							</div>
                            {x2;endif}
							<div class="page-ele radius hide">
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
					</div>
				</form>
			</div>
			<div class="pages-content hide">
				<div class="pages-box">
					<div class="page-ele radius margin">
						<div class="clear question">
                            {x2;tree:$questions,question,qid}
							<label class="selectbox col-xs-2 questionindex" data-index="{x2;v:qid}">
								<span class="selector">{x2;v:qid}</span>
							</label>
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
						<span class="glyphicon glyphicon-cloud-upload"></span><br />纠错
					</div>
				</a>
			</div>
		</div>
		<script>
			var savedata = function(){
				$('.pages-content:first').find('form').submit();
			}
			$(function() {
                $('.pages-content:first').find('.pages-box').css("display","none");
                $('.pages-content:first').find('.swiper-slide').css("display","block");
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
                    "onSlideChangeStart": function (swiper) {
                        swiper.disableTouchControl();
                    },
                    "onSlideChangeEnd": function (swiper) {
                        var page = $('.swiper-slide').eq(swiper.activeIndex);
                        if(page.attr('data-favor') == 1)
						{
							$('.pages-footer a').eq(0).addClass('active');
						}
						else
						{
                            $('.pages-footer a').eq(0).removeClass('active');
						}
						$('#lastquestion').val(page.attr('data-index'));
                        var i = parseInt(page.attr('data-index'));
                        goslide(i);
                        swiper.enableTouchControl();
					}
				});
				$('.pages-footer:first a').eq(2).on('click',function(){
					$('.pages-content:first').toggleClass('hide');
                    $('.pages-content:last').toggleClass('hide');
                    $(this).toggleClass('active');
				});

                function goslide(number)
                {
                    var totalnumber = $('.pages-content:first').find('.pages-box').length;
                    if(number >= totalnumber)return false;
                    if(number>= 0) {
                        var pre = number - 1;
                        var next = number + 1;
                        $('.pages-content:first').find('.pages-box').removeClass('swiper-slide swiper-slide-prev swiper-slide-next swiper-slide-active');
                        $('.pages-content:first').find('.pages-box').eq(pre).addClass('swiper-slide');
                        $('.pages-content:first').find('.pages-box').eq(number).addClass('swiper-slide');
                        $('.pages-content:first').find('.pages-box').eq(next).addClass('swiper-slide');
                        $('.pages-content:first').find('.pages-box').css("display", "none");
                        $('.pages-content:first').find('.swiper-slide').css("display", "block");
                        mySwiper.updateSlidesSize();
                        mySwiper.updatePagination();
                        mySwiper.updateClasses();
                        if(number>=1)
                        mySwiper.slideTo(1,0);
                        else
						mySwiper.slideTo(0,0);
                    }
                }

				$('.questionindex').on('click',function(){
                    $('.pages-content:first').toggleClass('hide');
                    $('.pages-content:last').toggleClass('hide');
                    $('.pages-footer:first a').eq(2).toggleClass('active');
                    var i = parseInt($(this).attr('data-index'));
                    goslide(i-1);
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
					$('.questionindex').eq(parent.index()).find('.selector').addClass('selected');
				});
                $('.selectbox.checkbox .selector').on('click',function(){
                    var parent = $(this).parents('.pages-box:first');
                    var _this = $(this);
                    parent.find('.selector').removeClass('right').removeClass('wrong');
                    parent.find('.finishbtn').parent().removeClass('hide');
                });
                $('.selectbox.radio .selector').parent().siblings().on('click',function(){
					$(this).parent().find('.selector').trigger('click');
				});
                $('.selectbox.checkbox .selector').parent().siblings().on('click',function(){
                    $(this).parent().find('.selector').trigger('click');
                });
                $('.finishbtn').on('click',function(){
                    var parent = $(this).parents('.pages-box:first');
                    var _this = $(this);
                    if(parent.find('input:checked').length < 1)
                    {
                        pep.mask.show('tips',{'message':'请选择一个答案'});
                        return false;
                    }
                    $('.questionindex').eq(parent.index()).find('.selector').addClass('selected');
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
                $('.pages-footer a').eq(0).on('click',function(){
                    var index = pep.isTrueVar($('#lastquestion').val())?$('#lastquestion').val():0;
                    if($(this).hasClass('active'))
                    {
                        submitAjax({'url':'index.php?exam-mobile-ajax-cancelfavor&questionid='+$('.pages-box').eq(index).attr('data-questionid')});
                        $(this).removeClass('active');
                        $(mySwiper.slides[mySwiper.activeIndex]).attr('data-favor','0');
                    }
                    else
                    {
                        submitAjax({'url':'index.php?exam-mobile-ajax-favorquestion&questionid='+$('.pages-box').eq(index).attr('data-questionid')});
                        $(this).addClass('active');
                        $(mySwiper.slides[mySwiper.activeIndex]).attr('data-favor','1');
                    }
                });
                $('.pages-footer a').eq(1).on('click',function(){
                    var index = pep.isTrueVar($('#lastquestion').val())?$('#lastquestion').val():0;
                    submitAjax({'url':'index.php?exam-mobile-point-note&questionid='+$('.pages-box').eq(index).attr('data-questionid')});
                });
                $('.pages-footer a').eq(3).on('click',function(){
                    var index = pep.isTrueVar($('#lastquestion').val())?$('#lastquestion').val():0;
                    submitAjax({'url':'index.php?exam-mobile-point-errors&questionid='+$('.pages-box').eq(index).attr('data-questionid')});
                });
                $('.pages-box').each(function(){
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
                if(pep.isTrueVar($('#lastquestion').val())) {
                    goslide(parseInt($('#lastquestion').val()));
                }
			});
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}