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
					<div class="text-center">错题反馈</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter">
				<form class="pages-box" action="index.php?exam-mobile-point-errors" method="post">
					<div class="page-ele radius margin">
						<div class="clear question">
							<div style="clear: both">
								<label class="selectbox checkbox float">
									<input type="checkbox" name="error[]" value="答案错误"><span class="selector"><i class="glyphicon glyphicon-ok"></i></span>
								</label>
								<p>
									答案错误
								</p>
							</div>
							<hr>
							<div style="clear: both">
								<label class="selectbox checkbox float">
									<input type="checkbox" name="error[]" value="题干错误"><span class="selector"><i class="glyphicon glyphicon-ok"></i></span>
								</label>
								<p>
									题干错误
								</p>
							</div>
							<hr>
							<div style="clear: both">
								<label class="selectbox checkbox float">
									<input type="checkbox" name="error[]" value="解析错误"><span class="selector"><i class="glyphicon glyphicon-ok"></i></span>
								</label>
								<p>
									解析错误
								</p>
							</div>
							<hr>
							<div style="clear: both">
								<label class="selectbox checkbox float">
									<input type="checkbox" name="error[]" value="其他错误"><span class="selector"><i class="glyphicon glyphicon-ok"></i></span>
								</label>
								<p>
									其他错误
								</p>
							</div>
							<hr>
							<input type="hidden" name="questionid" value="{x2;$questionid}">
							<input type="hidden" name="adderrors" value="1">
							<div style="clear: both;margin-top: 0.15rem;">
								<textarea name="errorcontent" class="form-control" style="height: 1rem;"></textarea>
							</div>
						</div>
					</div>
					<div class="page-ele clear">
						<div class="form-group">
							<div class="controls">
								<button class="btn btn-primary btn-block" type="submit">反馈错题</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}