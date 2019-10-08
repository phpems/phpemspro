{x2;include:header}
<body>
<div class="container-fluid">
	<div class="row-fluid nav">
		<div class="pep nav">
			<div class="col-xs-3 title">
				<ul class="list-unstyled list-inline">
					<li class="nopadding"><img src="public/static/images/index_logo.jpg" /></li>
				</ul>
			</div>
			<div class="col-xs-6">
				<ul class="list-unstyled list-inline">
					<li class="title">{x2;$paper['name']}</li>
				</ul>
			</div>
			<div class="col-xs-3">
				<ul class="list-unstyled list-inline pull-right">
					<li class="title" style="padding-left: 0px;padding-right: 0px;">
						<button type="button" class="btn btn-primary" style="margin-top: 20px;"><i class="glyphicon glyphicon-edit"></i> 计算器</button>
					</li>
					<li class="title" style="padding-right: 0px;">
						<button type="button" onclick="javascript:$('#submodal').modal();" class="btn btn-primary" style="margin-top: 20px;"><i class="glyphicon glyphicon-print"></i> 交卷</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels" style="background: url('public/static/images/shuiyinbg.png')">
			<div class="col-xs-3" style="padding-left: 0px;">
				<p class="pagebox">
					<a class="btn btn-danger btn-block" style="font-size: 20px;padding:15px;font-weight: 600;"><span id="timer_h">00</span>：<span id="timer_m">00</span>：<span id="timer_s">00</span></a>
				</p>
				<div class="leftmenu" style="background: none;overflow: hidden;" id="questionindex">
					<div class="" style="height: auto;">
                        {x2;eval:v:qtid = 0}
                        {x2;tree:$paper['setting']['papersetting']['questypelite'],lite,lid}
                        {x2;eval:v:qtindex = 0}
                        {x2;eval:v:questype = v:key}
                        {x2;if:$paper['question']['questions'][v:questype] || $paper['question']['questionrows'][v:questype]}
						<div class="questionindex" style="height: auto;padding:15px 10px 5px 10px;">
							<p class="text-center title" style="font-size: 16px;margin-bottom: 10px;line-height: 36px;">{x2;$questypes[v:questype]['questype']}</p>
                            {x2;if:$paper['question']['questions'][v:questype]}
                            {x2;if:$basic['basicexam']['changesequence']}
                            {x2;eval: shuffle($paper['question']['questions'][v:questype]);}
                            {x2;endif}
                            {x2;tree:$paper['question']['questions'][v:questype],question,qid}
                            {x2;eval:v:qtid++}
                            {x2;eval:v:qtindex++}
							<a style="width: 30px;height: 30px;line-height: 30px;" id="sign_{x2;v:question['questionid']}" data-index="{x2;v:qtid}" rel="{x2;v:question['questionid']}" href="javascript:;" class="questionindexbutton btn{x2;if:v:qid == $number} btn-primary{x2;else}{x2;if:$useranswer[v:question['questionid']]}{x2;if:$useranswer[v:question['questionid']]['status'] == 'right'} btn-success{x2;else} btn-danger{x2;endif}{x2;else} btn-default{x2;endif}{x2;endif}">{x2;v:qid}</a>
                            {x2;endtree}
                            {x2;endif}

                            {x2;if:$paper['question']['questionrows'][v:questype]}
                            {x2;if:$basic['basicexam']['changesequence']}
                            {x2;eval: shuffle($paper['question']['questionrows'][v:questype]);}
                            {x2;endif}
                            {x2;tree:$paper['question']['questionrows'][v:questype],questionrows,qrid}
                            {x2;tree:v:questionrows['data'],question,qid}
                            {x2;eval:v:qtid++}
                            {x2;eval:v:qtindex++}
							<a style="width: 30px;height: 30px;line-height: 30px;" id="sign_{x2;v:question['questionid']}" data-index="{x2;v:qtid}" rel="{x2;v:question['questionid']}" href="javascript:;" class="questionindexbutton btn{x2;if:v:qid == $number} btn-primary{x2;else}{x2;if:$useranswer[v:question['questionid']]}{x2;if:$useranswer[v:question['questionid']]['status'] == 'right'} btn-success{x2;else} btn-danger{x2;endif}{x2;else} btn-default{x2;endif}{x2;endif}">{x2;v:qid}</a>
                            {x2;endtree}
                            {x2;endtree}
                            {x2;endif}
						</div>
                        {x2;endif}
                        {x2;endtree}
					</div>
                    {x2;eval: $allnumber = v:qtid}
				</div>
			</div>
			<form class="col-xs-9 nopadding" id="exampaper" action="index.php?exam-app-exam-save" method="post">
                <input type="hidden" name="token" value="{x2;$paper['token']}">
                {x2;eval:v:qtid = 0}
                {x2;tree:$paper['setting']['papersetting']['questypelite'],lite,lid}
                {x2;eval:v:qtindex = 0}
                {x2;eval:v:questype = v:key}
                {x2;if:$paper['question']['questions'][v:questype] || $paper['question']['questionrows'][v:questype]}
                {x2;if:$paper['question']['questions'][v:questype]}
                {x2;tree:$paper['question']['questions'][v:questype],question,qid}
                {x2;eval:v:qtid++}
                {x2;eval:v:qtindex++}
				<div class="panel panel-default pagebox border" style="background: none;" data-questionid="{x2;v:question['questionid']}">
					<div class="panel-heading blod" style="background: none;">
						第{x2;v:qtindex}题 【{x2;$questypes[v:question['questiontype']]['questype']}】
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
                {x2;endtree}
                {x2;endif}

                {x2;if:$paper['question']['questionrows'][v:questype]}
                {x2;tree:$paper['question']['questionrows'][v:questype],questionrows,qrid}
                {x2;tree:v:questionrows['data'],question,qid}
                {x2;eval:v:qtid++}
                {x2;eval:v:qtindex++}
				<div class="panel panel-default pagebox border" style="background: none;" data-questionid="{x2;v:question['questionid']}">
					<div class="panel-heading blod" style="background: none;">
						第{x2;v:qtindex}题 【{x2;$questypes[v:question['questiontype']]['questype']}】
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
                {x2;endtree}
                {x2;endtree}
                {x2;endif}

                {x2;endif}
                {x2;endtree}
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="submodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">交卷</h4>
			</div>
			<div class="modal-body">
				<p>共有试题 <span class="allquestionnumber text-info">50</span> 题，已做 <span class="yesdonumber text-warning">0</span> 题。您确认要交卷吗？</p>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="javascript:submitPaper();" class="btn btn-primary">确定交卷</button>
				<button aria-hidden="true" class="btn" type="button" data-dismiss="modal">再检查一下</button>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
<script>
    $(function () {
        var init = true;
        var index = 0;
        var clock = null;
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
        $('#exampaper').find('.panel').addClass('hide').eq(index).removeClass('hide');
        $.get('index.php?exam-app-exam-lefttime&rand'+Math.random(),function(data){
            var setting = {
                time:{x2;$paper['time']},
                hbox:$("#timer_h"),
                mbox:$("#timer_m"),
                sbox:$("#timer_s"),
                finish:function(){
                    //$('#exampaper').submit();
                }
            }
            setting.lefttime = parseInt(data);
            clock = countdown(setting);
        });
        function nextquestion()
        {
            if(index < ($('#exampaper').find('.panel').length - 1))
            {
                index++;
                $('#exampaper').find('.panel').addClass('hide').eq(index).removeClass('hide');
                var sindex = index + 1;
                mySwiper.slideTo($('#questionindex .questionindexbutton[data-index='+sindex+']').parents('.swiper-slide').index());
            }
        }
        function prevquestion()
        {
            if(index > 0)
            {
                index--;
                $('#exampaper').find('.panel').addClass('hide').eq(index).removeClass('hide');
                var sindex = index + 1;
                mySwiper.slideTo($('#questionindex .questionindexbutton[data-index='+sindex+']').parents('.swiper-slide').index());
            }
        }
        $('.prevbutton').on('click',prevquestion);
        $('.nextbutton').on('click',nextquestion);
        $('.questionindexbutton').on('click',function(){
            _this = $(this);
            $('#exampaper').find('.panel').addClass('hide');
            $('#exampaper').find('.panel[data-questionid='+_this.attr('rel')+']').removeClass('hide');
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
        setInterval(saveanswer,271000);
        setInterval(function(){
            $.get('index.php?exam-app-exam-lefttime&rand'+Math.random(),function(data){
                clock(data);
            });
        },179000);
        initData = $.parseJSON(storage.getItem('questions'));
        {x2;if:$useranswer}
        if(!initData)
        {
            initData = $.parseJSON('{x2;$useranswer}');
        }
        {x2;endif}
        if(initData){
            for(var p in initData){
                if(p!='set')
                    formData[p]=initData[p];
            }

            var textarea = $('#exampaper textarea');
            $.each(textarea,function(){
                var _this = $(this);
                if(initData[_this.attr('name')])
                {
                    _this.val(initData[_this.attr('name')].value);
                    CKEDITOR.instances[_this.attr('id')].setData(initData[_this.attr('name')].value);
                    if(initData[_this.attr('name')].value && initData[_this.attr('name')].value != '')
                        batmark(_this.parents('.panel:first').attr('data-questionid'),initData[_this.attr('name')].value);
                }
            });
            var texts = $('#exampaper :input[type=text]');
            $.each(texts,function(){
                var _this = $(this);
                if(initData[_this.attr('name')])
                {
                    _this.val(initData[_this.attr('name')]?initData[_this.attr('name')].value:'');
                    if(initData[_this.attr('name')].value && initData[_this.attr('name')].value != '')
                        batmark(_this.parents('.panel:first').attr('data-questionid'),initData[_this.attr('name')].value);
                }
            });

            var radios = $('#exampaper :input[type=radio]');
            $.each(radios,function(){
                var _= this, v = initData[_.name]?initData[_.name].value:null;
                var _this = $(this);
                if(v!=''&&v==_.value){
                    _.checked = true;
                    batmark(_this.parents('.panel:first').attr('data-questionid'),initData[_this.attr('name')].value);
                }else{
                    _.checked=false;
                }
            });

            var checkboxs=$('#exampaper :input[type=checkbox]');
            $.each(checkboxs,function(){
                var _=this,v=initData[_.name]?initData[_.name].value:null;
                var _this = $(this);
                if(v!=''&&v==_.value){
                    _.checked=true;
                    batmark(_this.parents('.panel:first').attr('data-questionid'),initData[_this.attr('name')].value);
                }else{
                    _.checked=false;
                }
            });
        }

        $('#exampaper :input[type=text]').change(function(){
            var _this=$(this);
            var p=[];
            p.push(_this.attr('name'));
            p.push(_this.val());
            p.push(Date.parse(new Date())/1000);
            set.apply(formData,p);
            markQuestion(_this.parents('.panel:first').attr('data-questionid'),true);
        });

        $('#exampaper :input[type=radio]').change(function(){
            var _=this;
            var _this=$(this);
            var p=[];
            p.push(_.name);
            if(_.checked){
                p.push(_.value);
                p.push(Date.parse(new Date())/1000);
                set.apply(formData,p);
            }else{
                p.push('');
                p.push(null);
                set.apply(formData,p);
            }
            markQuestion(_this.parents('.panel:first').attr('data-questionid'));
        });

        $('#exampaper textarea').change(function(){
            var _= this;
            var _this=$(this);
            var p=[];
            p.push(_.name);
            p.push(_.value);
            p.push(Date.parse(new Date())/1000);
            set.apply(formData,p);
            markQuestion(_this.parents('.panel:first').attr('data-questionid'),true);
        });
        $('#exampaper :input[type=checkbox]').change(function(){
            var _= this;
            var _this = $(this);
            var p=[];
            p.push(_.name);
            if(_.checked){
                p.push(_.value);
                p.push(Date.parse(new Date())/1000);
                set.apply(formData,p);
            }else{
                p.push('');
                p.push(null);
                set.apply(formData,p);
            }
            markQuestion(_this.parents('.panel:first').attr('data-questionid'));
        });
        $('.allquestionnumber').html($('#exampaper .panel').length);
        $('.yesdonumber').html($('#questionindex .btn-primary').length);
    })
</script>
</body>
</html>