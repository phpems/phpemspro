{x2;include:header}<body>{x2;include:nav}<div class="container-fluid">	<div class="row-fluid">		<div class="pep">			<div class="col-xs-2 leftmenu">                {x2;include:menu}			</div>			<div class="col-xs-10" id="datacontent">				<ol class="breadcrumb">					<li><a href="index.php?{x2;$_route['app']}-master">{x2;$apps[$_route['app']]['appname']}</a></li>					<li><a href="index.php?{x2;$_route['app']}-master-exams">考试管理</a></li>					<li><a href="index.php?{x2;$_route['app']}-master-exams-papers&subjectid={x2;$subject['subjectid']}">{x2;$subject['subjectname']}</a></li>					<li class="active">{x2;$paper['papername']}</li>				</ol>				<div class="panel panel-default">					<div class="panel-heading">修改试卷</div>					<div class="panel-body">						<form action="index.php?exam-master-exams-modifypaper" method="post" class="form-horizontal">							<fieldset>								<div class="form-group">									<label class="control-label col-sm-2" for="content">试卷名称：</label>									<div class="col-sm-4">										<input class="form-control" type="text" name="args[papername]" value="{x2;$paper['papername']}" needle="needle" msg="您必须为该试卷输入一个名称"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">评卷方式</label>									<div class="col-sm-9">										<label class="radio-inline">											<input name="args[paperdecider]" type="radio" value="1"{x2;if:$paper['paperdecider']} checked{x2;endif}/>教师评卷										</label>										<label class="radio-inline">											<input name="args[paperdecider]" type="radio" value="0"{x2;if:!$paper['paperdecider']} checked{x2;endif}/>学生自评										</label>										<span class="help-block">教师评卷时有主观题则需要教师在后台评分后才能显示分数，无主观题自动显示分数。</span>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2" for="content">考试时间：</label>									<div class="col-sm-9 form-inline">										<input class="form-control" type="text" name="args[papersetting][papertime]" value="{x2;$paper['papersetting']['papertime']}" size="4" needle="needle" class="inline"/> 分钟									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2" for="content">来源：</label>									<div class="col-sm-4">										<input class="form-control" type="text" name="args[papersetting][comfrom]" value="{x2;$paper['papersetting']['comfrom']}" size="4"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2" for="content">试卷总分：</label>									<div class="col-sm-4">										<input class="form-control" type="text" name="args[papersetting][score]" value="{x2;$paper['papersetting']['score']}" size="4" needle="needle" msg="你要为本考卷设置总分" datatype="number"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2" for="content">及格线：</label>									<div class="col-sm-4">										<input class="form-control" type="text" name="args[papersetting][passscore]" value="{x2;$paper['papersetting']['passscore']}" size="4" needle="needle" msg="你要为本考卷设置一个及格分数线" datatype="number"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">题型排序</label>									<div class="col-sm-9">										<div class="sortable btn-group">                                            {x2;tree:$paper['papersetting']['questypelite'],qlid,eqid}											<a class="btn btn-primary questpanel panel_{x2;v:key}">{x2;$questypes[v:key]['questype']}<input type="hidden" name="args[papersetting][questypelite][{x2;v:key}]" value="1" class="questypepanelinput" id="panel_{x2;v:key}"/></a>                                            {x2;endtree}										</div>										<span class="help-block">拖拽进行题型排序</span>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">题量配比模式：</label>									<div class="col-sm-9">										<label class="radio-inline">											<input type="radio" {x2;if:$paper['papersetting']['scalemodel']} checked{x2;endif} name="args[papersetting][scalemodel]" value="1" onchange="javascript:$('#modeplane').html($('#sptype').html());$('#modeplane').find('.selfmodal').on('click',modalAjax);"/> 开启										</label>										<label class="radio-inline">											<input type="radio" {x2;if:!$paper['papersetting']['scalemodel']} checked{x2;endif} name="args[papersetting][scalemodel]" value="0" onchange="javascript:$('#modeplane').html($('#normaltype').html());"/> 关闭										</label>									</div>								</div>								<div id="modeplane">									{x2;tree:$questypes,questype,qid}									<div class="form-group questpanel panel_{x2;v:questype['questcode']}">										<label class="control-label col-sm-2" for="content">{x2;v:questype['questype']}：</label>										<div class="col-sm-9 form-inline">											<span class="info">共&nbsp;</span>											<input id="iselectallnumber_{x2;v:questype['questcode']}" type="text" class="form-control" needle="needle" name="args[papersetting][questype][{x2;v:key}][number]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['number'])}" size="1" msg="您必须填写总题数"/>											<span class="info">&nbsp;题，每题&nbsp;</span><input class="form-control" needle="needle" type="text" name="args[papersetting][questype][{x2;v:key}][score]" value="{x2;$paper['papersetting']['questype'][v:key]['score']}" size="1" msg="您必须填写每题的分值"/>											<span class="info">&nbsp;分，描述&nbsp;</span><input class="form-control" type="text" name="args[papersetting][questype][{x2;v:key}][describe]" value="{x2;$paper['papersetting']['questype'][v:key]['describe']}" size="10"/>											<span class="info">&nbsp;易&nbsp;</span><input class="form-control" type="text" name="args[papersetting][questype][{x2;v:key}][easynumber]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['easynumber'])}" size="1" msg="您需要填写简单题的数量，最小为0"/>											<span class="info">&nbsp;中&nbsp;</span><input class="form-control" type="text" needle="needle" name="args[papersetting][questype][{x2;v:key}][middlenumber]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['middlenumber'])}" size="1" msg="您需要填写中等难度题的数量，最小为0"/>											<span class="info">&nbsp;难&nbsp;</span><input class="form-control" type="text" needle="needle" name="args[papersetting][questype][{x2;v:key}][hardnumber]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['hardnumber'])}" size="1" datatype="number" msg="您需要填写难题的数量，最小为0"/>										</div>									</div>                                    {x2;endtree}								</div>								<div class="form-group">									<label class="control-label col-sm-2"></label>									<div class="col-sm-9">										<button class="btn btn-primary" type="submit">提交</button>										<input type="hidden" name="modifypaper" value="1"/>										<input type="hidden" name="paperid" value="{x2;$paper['paperid']}"/>									</div>								</div>							</fieldset>						</form>						<div id="sptype" class="hide">							<div class="form-group">								<label class="control-label col-sm-2">题量配比：</label>								<div class="col-sm-9">									<label class="radio inline">题量配比模式关闭时，此设置不生效。题量配比操作繁琐，请尽量熟悉后再行操作。</label>								</div>							</div>                            {x2;tree:$questypes,questype,qid}							<div class="form-group questpanel panel_{x2;v:questype['questid']}">								<label class="control-label col-sm-2" for="content">{x2;v:questype['questype']}：</label>								<div class="col-sm-9 form-inline">									<span class="info">共&nbsp;</span>									<input id="iselectallnumber_{x2;v:questype['questid']}" type="text" class="form-control" needle="needle" name="args[papersetting][questype][{x2;v:key}][number]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['number'])}" size="2" msg="您必须填写总题数"/>									<span class="info">&nbsp;题，每题&nbsp;</span><input class="form-control" needle="needle" type="text" name="args[papersetting][questype][{x2;v:key}][score]" value="{x2;eval: echo floatval($paper['papersetting']['questype'][v:key]['score'])}" size="2" msg="您必须填写每题的分值"/>									<span class="info">&nbsp;分，描述&nbsp;</span><input class="form-control" type="text" name="args[papersetting][questype][{x2;v:key}][describe]" value="{x2;$paper['papersetting']['questype'][v:key]['describe']}" size="12"/>									<a href="javascript:;" onclick="javascript:currentP = 'examscale_{x2;v:key}';$('#tablecontent').find(':checkbox').attr('checked',false);$('#modal').modal();" class="btn btn-primary">配题</a>									<a href="javascript:;" onclick="javascript:$('#examscale_{x2;v:key}').val('');" class="btn btn-danger">重置</a>									<a class="btn btn-info selfmodal" href="javascript:;" data-target="#modal2" url="index.php?exam-master-exams-showsetting&setting={examscale_{x2;v:key}}&useframe=1" valuefrom="examscale_{x2;v:key}">检查</a>								</div>							</div>							<div class="form-group questpanel panel_{x2;v:key}">								<label class="control-label col-sm-2" for="content">配比率：</label>								<div class="col-sm-9">									<textarea class="form-control" rows="7" id="examscale_{x2;v:key}" cols="4" name="args[papersetting][paperscale][{x2;v:key}]">{x2;$paper['papersetting']['paperscale'][v:key]}</textarea>								</div>							</div>                            {x2;endtree}						</div>						<div id="normaltype" class="hide">                            {x2;tree:$questypes,questype,qid}							<div class="form-group questpanel panel_{x2;v:questype['questid']}">								<label class="control-label col-sm-2" for="content">{x2;v:questype['questype']}：</label>								<div class="col-sm-9 form-inline">									<span class="info">共&nbsp;</span>									<input id="iselectallnumber_{x2;v:key}" type="text" class="form-control" needle="needle" name="args[papersetting][questype][{x2;v:key}][number]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['number'])}" size="1" msg="您必须填写总题数"/>									<span class="info">&nbsp;题，每题&nbsp;</span><input class="form-control" needle="needle" type="text" name="args[papersetting][questype][{x2;v:key}][score]" value="{x2;$paper['papersetting']['questype'][v:key]['score']}" size="1" msg="您必须填写每题的分值"/>									<span class="info">&nbsp;分，描述&nbsp;</span><input class="form-control" type="text" name="args[papersetting][questype][{x2;v:key}][describe]" value="{x2;$paper['papersetting']['questype'][v:key]['describe']}" size="10"/>									<span class="info">&nbsp;易&nbsp;</span><input class="form-control" type="text" name="args[papersetting][questype][{x2;v:key}][easynumber]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['easynumber'])}" size="1" msg="您需要填写简单题的数量，最小为0"/>									<span class="info">&nbsp;中&nbsp;</span><input class="form-control" type="text" needle="needle" name="args[papersetting][questype][{x2;v:key}][middlenumber]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['middlenumber'])}" size="1" msg="您需要填写中等难度题的数量，最小为0"/>									<span class="info">&nbsp;难&nbsp;</span><input class="form-control" type="text" needle="needle" name="args[papersetting][questype][{x2;v:key}][hardnumber]" value="{x2;eval: echo intval($paper['papersetting']['questype'][v:key]['hardnumber'])}" size="1" datatype="number" msg="您需要填写难题的数量，最小为0"/>								</div>							</div>                            {x2;endtree}						</div>					</div>				</div>			</div>		</div>	</div></div><div id="modal2" class="modal fade">	<div class="modal-dialog">		<div class="modal-content">			<div class="modal-header">				<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>				<h4 id="myModalLabel">					配置详情				</h4>			</div>			<div class="modal-body" id="modal-body"></div>			<div class="modal-footer">				<button aria-hidden="true" class="btn btn-primary" data-dismiss="modal">完成</button>			</div>		</div>	</div></div><div id="modal" class="modal fade">	<div class="modal-dialog">		<div class="modal-content">			<div class="modal-header">				<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>				<h4 id="myModalLabel">					配题				</h4>			</div>			<div class="modal-body">				<div class="form-horizontal">					<div class="form-group" style="max-height:240px;overflow-y:scroll;" id="tablecontent">						<table class="table table-hover table-bordered" style="width:86%;margin:auto;">                            {x2;tree:$sections,section,sid}							<tr class="info">								<td colspan="3">{x2;v:section['sectionname']}</td>							</tr>							<tr>                                {x2;tree:$points[v:section['sectionid']],point,pid}								<td><label class="checkbox-inline"><input type="checkbox" value="{x2;v:point['pointid']}"/> {x2;v:point['pointname']}</label></td>                                {x2;if:v:kid % 3 == 0}							</tr><tr>                                {x2;endif}                                {x2;endtree}							</tr>                            {x2;endtree}						</table>					</div>					<div class="form-group">						<label class="control-label col-sm-2" for="content">题量：</label>						<div class="col-sm-10 form-inline">							<span class="info">共&nbsp;</span>							<input id="modalallnumber" type="text" class="form-control" needle="needle" value="10" size="1" msg="您必须填写总题数"/>							<span class="info">&nbsp;易&nbsp;</span><input id="modaleasynumber" class="form-control" type="text" value="3" size="1" msg="您需要填写简单题的数量，最小为0"/>							<span class="info">&nbsp;中&nbsp;</span><input id="modalmidnumber" class="form-control" type="text" needle="needle" value="4" size="1" msg="您需要填写中等难度题的数量，最小为0"/>							<span class="info">&nbsp;难&nbsp;</span><input id="modalhardnumber" class="form-control" type="text" needle="needle" value="3" size="1" datatype="number" msg="您需要填写难题的数量，最小为0"/>						</div>					</div>				</div>			</div>			<div class="modal-footer">				<button class="btn btn-primary" type="button" onclick="javascript:confirmRules();">增加规则</button>				<button aria-hidden="true" class="btn btn-danger" data-dismiss="modal">放弃</button>			</div>		</div>	</div></div><script>$(function(){	{x2;if:$paper['papersetting']['scalemodel']}    $('#modeplane').html($('#sptype').html());    {x2;else}    $('#modeplane').html($('#normaltype').html());    {x2;endif}});</script>{x2;include:footer}</body></html>