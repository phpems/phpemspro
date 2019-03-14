{x2;include:header}<body>{x2;include:nav}<div class="container-fluid">	<div class="row-fluid">		<div class="pep">			<div class="col-xs-2 leftmenu">                {x2;include:menu}			</div>			<div class="col-xs-10" id="datacontent">				<ol class="breadcrumb">					<li><a href="index.php?{x2;$_route['app']}-teach">教师管理</a></li>					<li><a href="index.php?{x2;$_route['app']}-teach-exams">考试管理</a></li>					<li><a href="index.php?{x2;$_route['app']}-teach-exams-papers&subjectid={x2;$subject['subjectid']}">{x2;$subject['subjectname']}</a></li>					<li class="active">添加试卷</li>				</ol>				<div class="settingbar">					<a href="index.php?exam-teach-exams-addpaper&subjectid={x2;$subject['subjectid']}&type=1" class="btn{x2;if:$type <= 1} btn-primary{x2;else} btn-default{x2;endif}">随机组卷</a>					<a href="index.php?exam-teach-exams-addpaper&subjectid={x2;$subject['subjectid']}&type=2" class="btn{x2;if:$type == 2} btn-primary{x2;else} btn-default{x2;endif}">手工组卷</a>					<a href="index.php?exam-teach-exams-addpaper&subjectid={x2;$subject['subjectid']}&type=3" class="btn{x2;if:$type == 3} btn-primary{x2;else} btn-default{x2;endif}">即时组卷</a>				</div>				<div class="panel panel-default">					<div class="panel-heading">添加试卷</div>					<div class="panel-body">						<form action="index.php?exam-teach-exams-addpaper" method="post" class="form-horizontal">							<fieldset>								<div class="form-group">									<label class="control-label col-sm-2">试卷名称：</label>									<div class="col-sm-4">										<input class="form-control" type="text" name="args[papername]" value="" needle="needle" msg="您必须为该试卷输入一个名称"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">评卷方式</label>									<div class="col-sm-9">										<label class="radio-inline">											<input name="args[paperdecider]" type="radio" value="1"/>教师评卷										</label>										<label class="radio-inline">											<input name="args[paperdecider]" type="radio" value="0" checked/>学生自评										</label>										<span class="help-block">教师评卷时有主观题则需要教师在后台评分后才能显示分数，无主观题自动显示分数。</span>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">考试时间：</label>									<div class="col-sm-9 form-inline">										<input class="form-control" type="text" name="args[papersetting][papertime]" value="60" size="4" needle="needle" class="inline"/> 分钟									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">来源：</label>									<div class="col-sm-3">										<input class="form-control" type="text" name="args[papersetting][comfrom]" value="" size="4"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">试卷总分：</label>									<div class="col-sm-3">										<input class="form-control" type="text" name="args[papersetting][score]" value="" size="4" needle="needle" msg="你要为本考卷设置总分" datatype="number"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">及格线：</label>									<div class="col-sm-3">										<input class="form-control" type="text" name="args[papersetting][passscore]" value="" size="4" needle="needle" msg="你要为本考卷设置一个及格分数线" datatype="number"/>									</div>								</div>								<div class="form-group">									<label class="control-label col-sm-2">题型排序</label>									<div class="col-sm-9">										<div class="sortable btn-group">                                            {x2;tree:$questypes,questype,qid}											<a class="btn btn-primary questpanel panel_{x2;v:questype['questcode']}">{x2;v:questype['questype']}<input type="hidden" name="args[papersetting][questypelite][{x2;v:questype['questcode']}]" class="questypepanelinput" id="panel_{x2;v:questype['questcode']}" value="1"/></a>                                            {x2;endtree}										</div>										<span class="help-block">拖拽进行题型排序</span>									</div>								</div>                                {x2;tree:$questypes,questype,qid}								<div class="form-group questpanel panel_{x2;v:questype['questcode']}">									<label class="control-label col-sm-2">{x2;v:questype['questype']}：</label>									<div class="col-sm-9 form-inline">										<span class="info">共&nbsp;</span>										<input id="iselectallnumber_{x2;v:questype['questcode']}" type="text" class="form-control" needle="needle" name="args[papersetting][questype][{x2;v:questype['questcode']}][number]" value="0" size="2" msg="您必须填写总题数"/>										<span class="info">&nbsp;题，每题&nbsp;</span><input class="form-control" needle="needle" type="text" name="args[papersetting][questype][{x2;v:questype['questcode']}][score]" value="0" size="2" msg="您必须填写每题的分值"/>										<span class="info">&nbsp;分，描述&nbsp;</span><input class="form-control" type="text" name="args[papersetting][questype][{x2;v:questype['questcode']}][describe]" value="" size="12"/>										<span class="info">&nbsp;已选题数：<a id="ialreadyselectnumber_{x2;v:key}">0</a>&nbsp;&nbsp;题</span>										<span class="info">&nbsp;<a class="selfmodal btn btn-info" href="javascript:;" data-target="#modal" url="index.php?exam-teach-ajax-selected&questionids={iselectquestions_{x2;v:key}}&questionrowsids={iselectrowsquestions_{x2;v:key}}" valuefrom="iselectquestions_{x2;v:key}|iselectrowsquestions_{x2;v:key}">看题</a></span>										<span class="info">&nbsp;<a class="selfmodal btn btn-primary" href="javascript:;" data-target="#modal" url="index.php?exam-teach-ajax-selectquestions&search[questiontype]={x2;v:key}&questionids={iselectquestions_{x2;v:key}}&questionrowsids={iselectrowsquestions_{x2;v:key}}&useframe=1" valuefrom="iselectquestions_{x2;v:key}|iselectrowsquestions_{x2;v:key}">选题</a></span>										<input type="hidden" value="" id="iselectquestions_{x2;v:key}" name="args[paperquestions][{x2;v:key}][questions]" />										<input type="hidden" value="" id="iselectrowsquestions_{x2;v:key}" name="args[paperquestions][{x2;v:key}][questionrows]" />									</div>								</div>                                {x2;endtree}								<div class="form-group">									<label class="control-label col-sm-2"></label>									<div class="col-sm-9">										<button class="btn btn-primary" type="submit">提交</button>										<input type="hidden" name="addpaper" value="1"/>										<input type="hidden" name="args[papertype]" value="2"/>										<input type="hidden" name="args[papersubject]" value="{x2;$subject['subjectid']}"/>									</div>								</div>							</fieldset>						</form>					</div>				</div>			</div>		</div>	</div></div><div id="modal" class="modal fade">	<div class="modal-dialog">		<div class="modal-content">			<div class="modal-header">				<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>				<h4 id="myModalLabel">					试题详情				</h4>			</div>			<div class="modal-body" id="modal-body"></div>			<div class="modal-footer">				<button aria-hidden="true" class="btn btn-primary" data-dismiss="modal">完成</button>			</div>		</div>	</div></div>{x2;include:footer}</body></html>