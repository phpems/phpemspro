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
					<div class="text-center">我的笔记</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content">
				<div class="pages-box" data-questionid="{x2;v:question['questionid']}" {x2;if:$questypes[v:question['questiontype']]['questsort']}data-sort="1" data-answer="A"{x2;else}data-sort="0" data-answer="{x2;v:question['questionanswer']}"{x2;endif} data-favor="1">
					<form class="page-ele radius margin" action="index.php?exam-mobile-point-note" method="post" id="noteform">
						<h5 class="bigtitle col-xs-12">我的笔记</h5>
						<div class="clear question">
                            <textarea class="form-control" rows="5" name="args[notecontent]">{x2;$note['notecontent']}</textarea>
						</div>
						<div class="text-center">
							<input type="hidden" name="savenote" value="1" />
							<input type="hidden" name="args[notequestionid]" value="{x2;$questionid}" />
							<a onclick="javascript:$('#noteform').submit();" class="btn btn-primary finishbtn" style="border-radius: 0.17rem;padding:0.075rem 0.25rem;">保存</a>
						</div>
					</form>
					{x2;tree:$notes['data'],note,nid}
					<div class="page-ele radius">
						<h5 class="bigtitle col-xs-12">{x2;v:note['noteusername']}</h5>
						<div class="clear question">
							{x2;v:note['notecontent']}
						</div>
					</div>
					{x2;endtree}
				</div>
			</div>
		</div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}