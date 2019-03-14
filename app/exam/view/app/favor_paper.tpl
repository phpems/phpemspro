{x2;include:header}
<body>
{x2;include:top}
<div class="container-fluid">
    <div class="row-fluid nav">
        <div class="pep nav">
            <div class="col-xs-3 title">
                <ul class="list-unstyled list-inline">
                    <li class="nopadding"><a href="index.php"><img src="public/static/images/index_logo.jpg" /></a></li>
                </ul>
            </div>
            <div class="col-xs-6">
                <ul class="list-unstyled list-inline">
                    <li class="title">{x2;$section['sectionname']}</li>
                    <li class="text-danger">{x2;$point['pointname']}</li>
                </ul>
            </div>
            <div class="col-xs-3 text-right">
                {x2;if:!$status['status']}
                <a class="btn btn-primary" style="margin-top: 20px;" href="index.php?exam-app-basic-open"><i class="glyphicon glyphicon-yen"></i> 开通  </a>
                {x2;endif}
                <a class="btn btn-default" style="margin-top: 20px;" href="index.php?exam-app-basic"><i class="glyphicon glyphicon-chevron-left"></i> 返回  </a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row-fluid panels">
        <div class="pep panels" style="background: url('public/static/images/shuiyinbg.png')">
            <div class="col-xs-3" style="padding-left: 0px;">
                <p class="pagebox">
                    <a class="btn btn-default btn-block" onclick="javascript:$('#jsqmodal').modal();" style="font-size: 20px;padding:15px;font-weight: 600;"><i class="glyphicon glyphicon-edit"></i> 计算器</a>
                </p>
                <div class="leftmenu" style="background: none;">
                    <div class="topbox" style="background: none;color:#333333;font-weight: 600;">
                        答题卡
                    </div>
                </div>
                <div class="leftmenu swiper-container" style="background: none;overflow: hidden;">
                    <div class="swiper-wrapper" style="height: auto;">
                        <div class="swiper-slide questionindex">
                            {x2;tree:$questions,question,qid}
                            <a href="index.php?exam-app-favor-paper&questype={x2;$questype}&pointid={x2;$point['pointid']}&number={x2;v:qid}" class="btn{x2;if:v:qid == $number} btn-primary{x2;else}{x2;if:$useranswer[v:question['questionid']]}{x2;if:$useranswer[v:question['questionid']]['status'] == 'right'} btn-success{x2;else} btn-danger{x2;endif}{x2;else} btn-default{x2;endif}{x2;endif}">{x2;v:qid}</a>
                            {x2;if:v:qid % 45 == 0 && v:qid < $allnumber}
                        </div>
                        <div class="swiper-slide questionindex">
                            {x2;endif}
                            {x2;endtree}
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <p class="pagebox margin">
                    <img src="public/static/images/qrcode.jpg" width="100%"/>
                </p>
            </div>
            <div class="col-xs-9 nopadding">
                {x2;if:$question}
                <div class="panel panel-default pagebox border" style="background: none;">
                    <div class="panel-heading blod" style="background: none;">
                        第{x2;$number}题 【{x2;$questypes[$question['questiontype']]['questype']}】
                        <a class="btn btn-default{x2;if:$favors[$question['questionid']]} btn-primary{x2;endif} pull-right" id="favorbutton"><i class="glyphicon glyphicon-star-empty"></i> 收藏</a>
                        <a class="btn btn-default pull-right" id="errorbutton" onclick="javascript:$('#submodal').modal();"><i class="glyphicon glyphicon-edit"></i> 纠错</a>
                        {x2;if:$number < $allnumber}
                        <a data-toggle="tooltip" data-placement="top" title="也可以使用键盘右方向键切换" class="btn btn-default pull-right" onclick="javascirpt:nextpage();"> 下一题 <i class="glyphicon glyphicon-chevron-right"></i></a>
                        {x2;endif}
                        {x2;if:$number >1}
                        <a class="btn btn-default pull-right" onclick="javascript:prepage();"><i class="glyphicon glyphicon-chevron-left"></i> 上一题</a>
                        {x2;endif}
                    </div>
                    <div class="panel-body">
                        {x2;if:$parent['qrquestion']}
                        <div class="panel-heading">
                            {x2;realhtml:$parent['qrquestion']}
                        </div>
                        {x2;endif}
                        <div class="panel-heading">
                            {x2;realhtml:$question['question']}
                        </div>
                        <form action="index.php?exam-app-point-save" method="post" class="panel-body" id="selectbox"{x2;if:$useranswer[$question['questionid']]} data-useranswer="{x2;$useranswer[$question['questionid']]['answer']}"{x2;endif}{x2;if:$questypes[$question['questiontype']]['questsort']} data-answer="A"{x2;else} data-answer="{x2;$question['questionanswer']}"{x2;endif}>
                            {x2;if:$setting['selectormodel']}
                            <div class="clear question">
                                {x2;if:$questypes[$question['questiontype']]['questsort']}
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="A"><span class="selector">A</span>
                                    </label>
                                    <p>掌握</p>
                                </div>
                                <hr/>
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="B"><span class="selector">B</span>
                                    </label>
                                    <p>未掌握</p>
                                </div>
                                {x2;else}
                                {x2;if:$questypes[$question['questiontype']]['questchoice'] == 4}
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="A"><span class="selector">A</span>
                                    </label>
                                    <p>对</p>
                                </div>
                                <hr/>
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="B"><span class="selector">B</span>
                                    </label>
                                    <p>错</p>
                                </div>
                                {x2;else}
                                {x2;eval:$question['questionselect'] = \strings::parseSelector($question['questionselect'])}
                                {x2;tree:$question['questionselect'],selector,sid}
                                {x2;if:$questypes[$question['questiontype']]['questchoice'] == 1}
                                {x2;if:v:key}<hr/>{x2;endif}
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="{x2;v:selector[0]}"><span class="selector">{x2;v:selector[0]}</span>
                                    </label>
                                    {x2;v:selector[1]}
                                </div>
                                {x2;elseif:$questypes[$question['questiontype']]['questchoice'] == 2 || $questypes[$question['questiontype']]['questchoice'] == 3}
                                {x2;if:v:key}<hr/>{x2;endif}
                                <div style="clear: both">
                                    <label class="selectbox checkbox float">
                                        <input type="checkbox" name="question[{x2;$question['questionid']}][]" value="{x2;v:selector[0]}"><span class="selector">{x2;v:selector[0]}</span>
                                    </label>
                                    {x2;v:selector[1]}
                                </div>
                                {x2;endif}
                                {x2;if:v:sid >= $question['questionselectnumber']}
                                {x2;eval:break}
                                {x2;endif}
                                {x2;endtree}
                                {x2;endif}
                                {x2;endif}
                                {x2;if:in_array($questypes[$question['questiontype']]['questchoice'],array(2,3))}
                                <hr/>
                                <div class="pagebox padding" style="padding-left: 0px;">
                                    <a class="btn btn-primary finishbtn">回答完毕</a>
                                </div>
                                {x2;endif}
                            </div>
                            {x2;else}
                            <div class="clear question">
                                {x2;tree:$setting['selectortype'],selector,sid}
                                {x2;if:$questypes[$question['questiontype']]['questchoice'] == 1}
                                {x2;eval:$question['questionselect'] = str_replace('[['.v:selector.']]','<label class="selectbox radio"><input type="radio" value="'.v:selector.'" name="question['.$question['questionid'].']"><span class="selector">'.v:selector.'</span></label>',$question['questionselect'])}
                                {x2;elseif:$questypes[$question['questiontype']]['questchoice'] == 2 || $questypes[$question['questiontype']]['questchoice'] == 3}
                                {x2;eval:$question['questionselect'] = str_replace('[['.v:selector.']]','<label class="selectbox checkbox"><input type="checkbox" value="'.v:selector.'" name="question['.$question['questionid'].'][]"><span class="selector">'.v:selector.'</span></label>',$question['questionselect'])}
                                {x2;endif}
                                {x2;if:v:sid >= $question['questionselectnumber']}
                                {x2;eval:break}
                                {x2;endif}
                                {x2;endtree}
                                {x2;if:$questypes[$question['questiontype']]['questsort']}
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="A"><span class="selector">A</span>
                                    </label>
                                    <p>掌握</p>
                                </div>
                                <hr/>
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="B"><span class="selector">B</span>
                                    </label>
                                    <p>未掌握</p>
                                </div>
                                {x2;else}
                                {x2;if:in_array($questypes[$question['questiontype']]['questchoice'],array(2,3))}
                                {x2;$question['questionselect']}
                                <hr/>
                                <div class="pagebox padding" style="padding-left: 0px;">
                                    <a class="btn btn-primary finishbtn">回答完毕</a>
                                </div>
                                {x2;elseif:$questypes[$question['questiontype']]['questchoice'] == 1}
                                {x2;$question['questionselect']}
                                {x2;elseif:$questypes[$question['questiontype']]['questchoice'] == 4}
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="A"><span class="selector">A</span>
                                    </label>
                                    <p>对</p>
                                </div>
                                <hr/>
                                <div style="clear: both">
                                    <label class="selectbox radio float">
                                        <input type="radio" name="question[{x2;$question['questionid']}]" value="B"><span class="selector">B</span>
                                    </label>
                                    <p>错</p>
                                </div>
                                {x2;else}
                                {x2;endif}
                                {x2;endif}
                            </div>
                            {x2;endif}
                            <input type="hidden" name="questionid" value="{x2;$question['questionid']}">
                            <input type="hidden" name="pointid" value="{x2;$point['pointid']}">
                            <input type="hidden" name="saveanswer" value="1">
                        </form>
                    </div>
                </div>
                <div id="answerbox" class="panel panel-default pagebox border hide" style="position: relative;background: none;">
                    <img src="public/static/images/pcwrong.png" style="position: absolute;left:250px;top:10px;width:200px;"/>
                    <div class="panel-heading bold" style="font-weight: 800;background: none;">
                        习题编号：{x2;$question['questionid']}
                    </div>
                    <div class="panel-heading bold" style="font-weight: 800;background: none;">
                        我的答案：<span class="text-warning myanswer">-</span>
                    </div>
                    <div class="panel-heading bold" style="font-weight: 800;background: none;">
                        参考答案：<span class="text-success">{x2;$question['questionanswer']}</span>
                    </div>
                    <div class="panel-heading bold" style="font-weight: 800;background: none;">
                        参考解析
                    </div>
                    <div class="panel-body">
                        {x2;if:$question['questionintro']}
                        {x2;$question['questionintro']}
                        {x2;else}
                        <p>暂无解析</p>
                        {x2;endif}
                    </div>
                </div>
                <div id="notebox" class="panel panel-default pagebox border hide" style="background: none;">
                    <div class="panel-heading bold" style="background: none;">
                        <a class="btn btn-primary" onclick="javascript:$(this).addClass('btn-primary').removeClass('btn-default').siblings().removeClass('btn-primary').addClass('btn-default');$(this).parents('.panel:first').find('.panel-body').addClass('hide').eq(0).removeClass('hide');"><i class="glyphicon glyphicon-star-empty"></i> 他人笔记</a>
                        <a class="btn btn-default" onclick="javascript:$(this).addClass('btn-primary').removeClass('btn-default').siblings().removeClass('btn-primary').addClass('btn-default');$(this).parents('.panel:first').find('.panel-body').addClass('hide').eq(1).removeClass('hide');"><i class="glyphicon glyphicon-edit"></i> 我的笔记</a>
                    </div>
                    <div class="panel-body autoloaditem" id="noteboxlist" autoload="index.php?exam-app-point-note&questionid={x2;$question['questionid']}">
                    </div>
                    <div class="panel-body hide">
                        <form class="pagebox notes" action="index.php?exam-app-point-note" method="post">
                            <textarea class="form-control" name="args[notecontent]" style="height: 160px;">{x2;$note['notecontent']}</textarea>
                            <div class="text-right">
                                <input type="hidden" name="savenote" value="1" />
                                <input type="hidden" name="args[notequestionid]" value="{x2;$question['questionid']}" />
                                <button type="submit" class="btn btn-primary" style="margin: 10px 0px;">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
                {x2;else}
                <div class="panel panel-default pagebox border" style="background: none;">
                    <div class="panel-heading blod" style="background: none;">
                        该题型下没有题目
                    </div>
                </div>
                {x2;endif}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="submodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">题型</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?exam-app-point-errors" method="post" class="form-horizontal" style="padding:20px;" id="reporterrorform">
                    <fieldset>
                        <div class="form-group">
                            <label class="control-label col-sm-3">错误类型：</label>
                            <div class="col-sm-9">
                                <div style="clear: both">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="error[]" value="答案错误"><span>答案错误</span>
                                    </label>
                                </div>
                                <div style="clear: both">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="error[]" value="题干错误"><span>题干错误</span>
                                    </label>
                                </div>
                                <div style="clear: both">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="error[]" value="解析错误"><span>解析错误</span>
                                    </label>
                                </div>
                                <div style="clear: both">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="error[]" value="其他错误"><span>其他错误</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">详情描述：</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="errorcontent" style="height:80px;margin-top: 10px;" needle="needle" msg="请填写错误描述"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-10">
                                <button class="btn btn-primary hide btn-block" type="submit">提交</button>
                                <input type="hidden" name="questionid" value="{x2;$question['questionid']}">
                                <input type="hidden" name="adderrors" value="1">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:$('#reporterrorform').submit();">提交</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="jsqmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">计算器</h4>
            </div>
            <div class="modal-body">
                <iframe src="jsq/index.html" width="100%;" height="500"></iframe>
            </div>
            <div class="modal-footer">
                <button aria-hidden="true" class="btn" type="button" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
{x2;include:footer}
<script>
    function prepage(){
        {x2;if:$number > 1}
        window.location = 'index.php?exam-app-favor-paper&questype={x2;$questype}&pointid={x2;$point['pointid']}&number={x2;eval: echo $number - 1}';
        {x2;endif}
    }

    function nextpage(){
        {x2;if:$number < $allnumber}
        window.location = 'index.php?exam-app-favor-paper&questype={x2;$questype}&pointid={x2;$point['pointid']}&number={x2;eval: echo $number + 1}';
        {x2;endif}
    }
    $(function () {
        var init = true;
        $('[data-toggle="tooltip"]').tooltip();
        var mySwiper = new Swiper('.swiper-container', {
            "pagination":".swiper-pagination",
            "paginationType" : 'fraction',
            'preventClicks':false,
            'initialSlide':{x2;eval: echo intval(($number-1)/45)},
            "loop": false,
            "autoplay": 0,
            "observer": true,
            "observeParents": true,
            prevButton:'.swiper-button-prev',
            nextButton:'.swiper-button-next'
        });
        $('.selectbox.radio .selector').on('click',function(){
            var parent = $('#selectbox');
            var _this = $(this);
            _this.removeClass('right').removeClass('wrong');
            $('#notebox').removeClass('hide');
            $('#answerbox').removeClass('hide');
            $('#answerbox').find('.myanswer').html(_this.parent().find('input:first').val());
            if(_this.parent().find('input:first').val() == parent.attr('data-answer'))
            {
                _this.addClass('right');
                $('#answerbox').find('img:first').attr('src','public/static/images/pcright.png');
            }
            else
            {
                _this.addClass('wrong');
                $('#answerbox').find('img:first').attr('src','public/static/images/pcwrong.png');
            }
        });
        $('.selectbox.checkbox .selector').on('click',function(){
            var parent = $('#selectbox');
            var _this = $(this);
            parent.find('.selector').removeClass('right').removeClass('wrong');
            parent.find('.finishbtn').parent().removeClass('hide');
        });
        $('.finishbtn').on('click',function(){
            var parent = $('#selectbox');
            var _this = $(this);
            if(parent.find('input:checked').length < 1)
            {
                $.zoombox.show('ajax',{'message':'请选择一个答案'});
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
            $('#notebox').removeClass('hide');
            $('#answerbox').removeClass('hide');
            $('#answerbox').find('.myanswer').html(answer);
            if(parent.attr('data-answer') == answer)
            {
                $('#answerbox').find('img:first').attr('src','public/static/images/pcright.png');
            }
            else
            {
                $('#answerbox').find('img:first').attr('src','public/static/images/pcwrong.png');
            }
        });
        $('.selectbox.radio .selector').parent().siblings().on('click',function(){
            $(this).parent().find('.selector').trigger('click');
        });
        $('.selectbox.checkbox .selector').parent().siblings().on('click',function(){
            $(this).parent().find('.selector').trigger('click');
        });
        $('#selectbox').each(function(){
            var _this = $(this);
            if(_this.attr('data-useranswer'))
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
            init = false;
        });
        $('#favorbutton').on('click',function(){
            if($(this).hasClass('btn-primary'))
            {
                submitAjax({'url':'index.php?exam-app-ajax-cancelfavor&questionid={x2;$question['questionid']}'});
                $(this).removeClass('btn-primary');
            }
            else
            {
                submitAjax({'url':'index.php?exam-app-ajax-favorquestion&questionid={x2;$question['questionid']}'});
                $(this).addClass('btn-primary');
            }
        });
        $(document).keyup(function(e){
            var key =  e.which;
            if(key == 37){
                prepage();
            }
            else if(key == 39){
                nextpage();
            }
        });
    })
</script>
</body>
</html>