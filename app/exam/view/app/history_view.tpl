{x2;include:header}
<body>
<div class="container-fluid">
	<div class="row-fluid header">
		<div class="pep header">
			<div class="col-xs-4">
				<ul class="list-unstyled list-inline">
					<li><i class="glyphicon glyphicon-phone-alt" style="font-size: 16px"></i></li>
					<li>电话：13900139000</li>
				</ul>
			</div>
			<div class="col-xs-8 text-right">
				<ul class="list-unstyled list-inline">
					<li>立即登陆</li>
					<li>|</li>
					<li>快速注册</li>
					<li>|</li>
					<li>关于我们</li>
					<li>|</li>
					<li>帮助信息</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid nav">
		<div class="pep nav" style="position: relative">
			<div class="col-xs-3 title">
				<ul class="list-unstyled list-inline">
					<li class="nopadding"><img src="public/static/images/index_logo.jpg" /></li>
				</ul>
			</div>
            <div class="col-xs-7">
				<ul class="list-unstyled list-inline">
					<li class="title">{x2;$history['ehexam']}</li>
				</ul>
			</div>
			<div class="col-xs-2 text-right">
				<a class="btn btn-default" style="margin-top: 20px;" href="javascript:history.back();"><i class="glyphicon glyphicon-chevron-left"></i> 返回  </a>
			</div>
			<p class="score">{x2;eval: echo intval($history['ehscore'])}</p>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels" style="background: url('public/static/images/shuiyinbg.png')">
			<div class="col-xs-3" style="padding-left: 0px;">
				<div class="leftmenu swiper-container" style="background: none;overflow: hidden;" id="questionindex">
					<div class="swiper-wrapper" style="height: auto;">
                        {x2;eval:v:qtid = 0}
						{x2;tree:$history['ehsetting']['papersetting']['questypelite'],lite,lid}
                        {x2;eval:v:qtindex = 0}
                        {x2;eval:v:questype = v:key}
                        {x2;if:$history['ehquestion']['questions'][v:questype] || $history['ehquestion']['questionrows'][v:questype]}
						<div class="swiper-slide questionindex">
                            <p class="text-center title">{x2;$questypes[v:questype]['questype']}</p>
                            {x2;if:$history['ehquestion']['questions'][v:questype]}
                            {x2;tree:$history['ehquestion']['questions'][v:questype],question,qid}
                            {x2;eval:v:qtid++}
                            {x2;eval:v:qtindex++}
							<a id="sign_{x2;v:question['questionid']}" data-index="{x2;v:qtid}" rel="{x2;v:question['questionid']}" href="javascript:;" class="questionindexbutton btn {x2;if:$history['ehsetting']['papersetting']['questype'][v:question['questiontype']]['score'] == $history['ehscorelist'][v:question['questionid']]}btn-success{x2;else}btn-danger{x2;endif}">{x2;v:qid}</a>
                            {x2;if:v:qtindex % 40 == 0 && v:qtindex < $history['ehsetting']['papersetting']['questype'][v:questype]['number']}
						</div>
						<div class="swiper-slide questionindex">
							<p class="text-center title">{x2;$questypes[v:questype]['questype']}</p>
							{x2;endif}
                            {x2;endtree}
                            {x2;endif}


							{x2;if:$history['ehquestion']['questionrows'][v:questype]}
							{x2;tree:$history['ehquestion']['questionrows'][v:questype],questionrows,qrid}
							{x2;tree:v:questionrows['data'],question,qid}
							{x2;eval:v:qtid++}
							{x2;eval:v:qtindex++}
							<a id="sign_{x2;v:question['questionid']}" data-index="{x2;v:qtid}" rel="{x2;v:question['questionid']}" href="javascript:;" class="questionindexbutton btn{x2;if:$history['ehsetting']['papersetting']['questype'][v:questionrows['qrtype']]['score'] == $history['ehscorelist'][v:question['questionid']]}btn-success{x2;else}btn-danger{x2;endif}">{x2;v:qid}</a>
							{x2;if:v:qtindex % 40 == 0 && v:qtindex < $history['ehsetting']['papersetting']['questype'][v:questype]['number']}
						</div>
						<div class="swiper-slide questionindex">
							<p class="text-center title">{x2;$questypes[v:questype]['questype']}</p>
							{x2;endif}
							{x2;endtree}
							{x2;endtree}
							{x2;endif}
						</div>
                        {x2;endif}
                        {x2;endtree}
					</div>
					<div class="swiper-pagination"></div>
					{x2;eval: $allnumber = v:qtid}
				</div>
			</div>
			<div class="col-xs-9 nopadding" id="exampaper" style="position: relative">
				{x2;eval:v:qtid = 0}
                {x2;tree:$history['ehsetting']['papersetting']['questypelite'],lite,lid}
                {x2;eval:v:qtindex = 0}
                {x2;eval:v:questype = v:key}
                {x2;if:$history['ehquestion']['questions'][v:questype] || $history['ehquestion']['questionrows'][v:questype]}
                {x2;if:$history['ehquestion']['questions'][v:questype]}
                {x2;tree:$history['ehquestion']['questions'][v:questype],question,qid}
                {x2;eval:v:qtid++}
                {x2;eval:v:qtindex++}
				<div class="questionpanel" data-questionid="{x2;v:question['questionid']}">
					<div class="panel panel-default pagebox border" style="background: none;">
						<div class="panel-heading blod" style="background: none;">
							第{x2;v:qtindex}题 【{x2;$questypes[v:question['questiontype']]['questype']}】
							<a rel="{x2;v:question['questionid']}" class="favorbutton btn btn-default{x2;if:$favors[v:question['questionid']]} btn-primary{x2;endif} pull-right"><i class="glyphicon glyphicon-star-empty"></i> 收藏</a>
							<a class="btn btn-default pull-right" href="index.php?exam-app-point&questionid={x2;v:question['questionid']}&pointid={x2;eval: echo current(v:question['questionpoints'])}"><i class="glyphicon glyphicon-info-sign"></i> 详细</a>
                            {x2;if:v:qtid < $allnumber}
							<a data-toggle="tooltip" data-placement="bottom" title="也可以使用键盘右方向键切换" class="btn btn-default pull-right nextbutton"> 下一题 <i class="glyphicon glyphicon-chevron-right"></i></a>
							{x2;endif}
							{x2;if:v:qtid >1}
							<a data-toggle="tooltip" data-placement="bottom" title="也可以使用键盘左方向键切换" class="btn btn-default pull-right prevbutton"><i class="glyphicon glyphicon-chevron-left"></i> 上一题</a>
							{x2;endif}
						</div>
						<div class="panel-body">
							{x2;if:$parent['qrquestion']}
							<div class="panel-heading">
								{x2;realhtml:$parent['qrquestion']}
							</div>
							{x2;endif}
							<div class="panel-heading">
								{x2;realhtml:v:question['question']}
							</div>
							<div class="panel-body">
								{x2;if:$setting['selectormodel']}
								<div class="clear question">
									{x2;if:$questypes[v:question['questiontype']]['questsort']}
									<div style="clear: both">
										<textarea name="question[{x2;v:question['questionid']}]" class="pepeditor"></textarea>
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
										<textarea name="question[{x2;v:question['questionid']}]" class="pepeditor"></textarea>
									</div>
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
					</div>
					<div class="panel panel-default pagebox border" style="position: relative;background: none;">
						{x2;if:$history['ehsetting']['papersetting']['questype'][v:question['questiontype']]['score'] == $history['ehscorelist'][v:question['questionid']]}
						<img src="public/static/images/pcright.png" style="position: absolute;left:250px;top:10px;width:200px;"/>
						{x2;else}
						<img src="public/static/images/pcwrong.png" style="position: absolute;left:250px;top:10px;width:200px;"/>
						{x2;endif}
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							习题编号：{x2;v:question['questionid']}
						</div>
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							我的答案：<span class="text-warning myanswer">{x2;$history['ehuseranswer'][v:question['questionid']]}</span>
						</div>
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							参考答案：<span class="text-success">{x2;v:question['questionanswer']}</span>
						</div>
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							参考解析
						</div>
						<div class="panel-body">
							{x2;if:v:question['questionintro']}
							{x2;v:question['questionintro']}
							{x2;else}
							<p>暂无解析</p>
							{x2;endif}
						</div>
					</div>
				</div>
                {x2;endtree}
                {x2;endif}

                {x2;if:$history['ehquestion']['questionrows'][v:questype]}
                {x2;tree:$history['ehquestion']['questionrows'][v:questype],questionrows,qrid}
                {x2;tree:v:questionrows['data'],question,qid}
                {x2;eval:v:qtid++}
                {x2;eval:v:qtindex++}
				<div class="questionpanel" data-questionid="{x2;v:question['questionid']}">
					<div class="panel panel-default pagebox border" style="background: none;" data-questionid="{x2;v:question['questionid']}">
						<div class="panel-heading blod" style="background: none;">
							第{x2;v:qtindex}题 【{x2;$questypes[v:question['questiontype']]['questype']}】
							<a rel="{x2;v:question['questionid']}" class="favorbutton btn btn-default{x2;if:$favors[v:question['questionid']]} btn-primary{x2;endif} pull-right"><i class="glyphicon glyphicon-star-empty"></i> 收藏</a>
							<a class="btn btn-default pull-right" href="index.php?exam-app-point&questionid={x2;v:question['questionid']}&pointid={x2;eval: echo current(v:questionrows['qrpoints'])}"><i class="glyphicon glyphicon-info-sign"></i> 详细</a>
                            {x2;if:v:qtid < $allnumber}
							<a data-toggle="tooltip" data-placement="bottom" title="也可以使用键盘右方向键切换" class="btn btn-default pull-right nextbutton"> 下一题 <i class="glyphicon glyphicon-chevron-right"></i></a>
							{x2;endif}
							{x2;if:v:qtid >1}
							<a data-toggle="tooltip" data-placement="bottom" title="也可以使用键盘左方向键切换" class="btn btn-default pull-right prevbutton"><i class="glyphicon glyphicon-chevron-left"></i> 上一题</a>
							{x2;endif}
						</div>
						<div class="panel-body">
							<div class="panel-heading">
								{x2;realhtml:v:questionrows['qrquestion']}
							</div>
							<div class="panel-heading">
								{x2;realhtml:v:question['question']}
							</div>
							<div class="panel-body">
								{x2;if:$setting['selectormodel']}
								<div class="clear question">
									{x2;if:$questypes[v:question['questiontype']]['questsort']}
									<div style="clear: both">
										<textarea name="question[{x2;v:question['questionid']}]" class="pepeditor"></textarea>
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
										<textarea name="question[{x2;v:question['questionid']}]" class="pepeditor"></textarea>
									</div>
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
					</div>
					<div class="panel panel-default pagebox border" style="position: relative;background: none;">
                        {x2;if:$history['ehsetting']['papersetting']['questype'][v:questionrows['qrtype']]['score'] == $history['ehscorelist'][v:question['questionid']]}
						<img src="public/static/images/pcright.png" style="position: absolute;left:250px;top:10px;width:200px;"/>
                        {x2;else}
						<img src="public/static/images/pcwrong.png" style="position: absolute;left:250px;top:10px;width:200px;"/>
                        {x2;endif}
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							习题编号：{x2;v:question['questionid']}
						</div>
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							我的答案：<span class="text-warning myanswer">{x2;$history['ehuseranswer'][v:question['questionid']]}</span>
						</div>
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							参考答案：<span class="text-success">{x2;v:question['questionanswer']}</span>
						</div>
						<div class="panel-heading bold" style="font-weight: 800;background: none;">
							参考解析
						</div>
						<div class="panel-body">
                            {x2;if:v:question['questionintro']}
                            {x2;v:question['questionintro']}
                            {x2;else}
							<p>暂无解析</p>
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
</div>
{x2;include:footer}
<script>
    $(function () {
        var init = true;
        var index = 0;
        $('[data-toggle="tooltip"]').tooltip();
        var mySwiper = new Swiper('.swiper-container', {
            "pagination":".swiper-pagination",
            "paginationType" : 'fraction',
            'preventClicks':false,
            "loop": false,
            "autoplay": 0,
            "observer": true,
            "observeParents": true,
            prevButton:'.swiper-button-prev',
            nextButton:'.swiper-button-next'
        });
        $('.selectbox.radio .selector').parent().siblings().on('click',function(){
            $(this).parent().find('.selector').trigger('click');
        });
        $('.selectbox.checkbox .selector').parent().siblings().on('click',function(){
            $(this).parent().find('.selector').trigger('click');
        });
        $('#exampaper').find('.questionpanel').addClass('hide').eq(index).removeClass('hide');
        $('.favorbutton').on('click',function(){
            var _this = $(this);
            if($(this).hasClass('btn-primary'))
            {
                submitAjax({'url':'index.php?exam-app-ajax-cancelfavor&questionid='+_this.attr('rel')});
                $(this).removeClass('btn-primary');
            }
            else
            {
                submitAjax({'url':'index.php?exam-app-ajax-favorquestion&questionid='+_this.attr('rel')});
                $(this).addClass('btn-primary');
            }
        });
        function nextquestion()
		{
			if(index < ($('#exampaper').find('.questionpanel').length - 1))
			{
				index++;
                $('#exampaper').find('.questionpanel').addClass('hide').eq(index).removeClass('hide');
                var sindex = index + 1;
                mySwiper.slideTo($('#questionindex .questionindexbutton[data-index='+sindex+']').parents('.swiper-slide').index());
			}
		}
        function prevquestion()
        {
            if(index > 0)
            {
                index--;
                $('#exampaper').find('.questionpanel').addClass('hide').eq(index).removeClass('hide');
                var sindex = index + 1;
                mySwiper.slideTo($('#questionindex .questionindexbutton[data-index='+sindex+']').parents('.swiper-slide').index());
            }
        }
        $('.prevbutton').on('click',prevquestion);
    	$('.nextbutton').on('click',nextquestion);
    	$('.questionindexbutton').on('click',function(){
            _this = $(this);
            $('#exampaper').find('.questionpanel').addClass('hide');
            $('#exampaper').find('.questionpanel[data-questionid='+_this.attr('rel')+']').removeClass('hide');
            index = parseInt(_this.attr('data-index')-1);
            if(index < 1)index = 0;
        });
        $(document).keyup(function(e){
            var key =  e.which;
            if(key == 37){
                prevquestion();
            }
            else if(key == 39){
                nextquestion();
            }
        });
    })
</script>
</body>
</html>