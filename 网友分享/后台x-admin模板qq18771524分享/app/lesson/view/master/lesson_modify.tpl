{x2;if:!$_userhash}
{x2;globaltpl:ad_header}
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div id="datacontent">
{x2;endif}
				<ol class="breadcrumb">
					<li><a href="index.php?{x2;$_route['app']}-master-lessons&page={x2;$page}">课程管理</a></li>
					<li><a href="index.php?{x2;$_route['app']}-master-lessons&catid={x2;$cat['catid']}">{x2;$cat['catname']}</a></li>
					<li class="active">修改课程</li>
				</ol>
				<div class="panel panel-default">
					<div class="panel-heading">
						修改课程
					</div>
					<div class="panel-body">
						<form action="index.php?lesson-master-lessons-modify" method="post" class="form-horizontal">
							<div class="form-group">
								<label for="lessonname" class="control-label col-sm-2">标题：</label>
								<div class="col-sm-9">
									<input class="form-control" id="lessonname"  type="text" name="args[lessonname]" value="{x2;$lesson['lessonname']}" />
								</div>
							</div>
							<div class="form-group">
								<label for="lessontime" class="control-label col-sm-2">时间：</label>
								<div class="col-sm-9">
									<input class="form-control datetimepicker normalinput" value="{x2;$lesson['lessontime']}" data-date-format="yyyy-mm-dd hh:ii:ss" id="lessontime"  type="text" name="args[lessontime]" />
								</div>
							</div>
							<div class="form-group">
								<label for="lessonthumb" class="control-label col-sm-2">缩略图：</label>
								<div class="col-sm-9">
									<script type="text/template" id="pe-template-lessonthumb">
										<div class="qq-uploader-selector" style="width:30%">
											<div class="qq-upload-button-selector" style="clear:both;">
												<ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
													<li class="text-center">
														<div class="thumbnail">
															<img alt="点击上传新图片" class="qq-thumbnail-selector">
															<input type="hidden" class="qq-edit-filename-selector" name="args[lessonthumb]" tabindex="0">
														</div>
													</li>
												</ul>
												<ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
													<li class="text-center">
														<div class="thumbnail">
															<img src="{x2;$lesson['lessonthumb']}" alt="点击上传新图片" class="qq-thumbnail-selector">
															<input type="hidden" class="qq-edit-filename-selector" name="args[lessonthumb]" value="{x2;$lesson['lessonthumb']}">
														</div>
													</li>
												</ul>
											</div>
										</div>
									</script>
									<div class="fineuploader" attr-type="thumb" attr-template="pe-template-lessonthumb"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">做为免费考场</label>
								<div class="col-sm-9">
									<label class="radio-inline">
										<input name="args[lessondemo]" type="radio" value="1" {x2;if:$lesson['lessondemo']}checked{x2;endif}/>是
									</label>
									<label class="radio-inline">
										<input name="args[lessondemo]" type="radio" value="0" {x2;if:!$lesson['lessondemo']}checked{x2;endif}/>否
									</label>
									<span class="help-block">免费考场用户开通考场时不扣除积分</span>
								</div>
							</div>
							<div class="form-group">
								<label for="lessonprice" class="control-label col-sm-2">价格设置</label>
								<div class="col-sm-9">
									<textarea class="form-control" rows="4" name="args[lessonprice]" id="lessonprice">{x2;$lesson['lessonprice']}</textarea>
									<span class="help-block">请按照“名称:时长:开通所需价格”格式填写，每行一个，时长以天为单位，免费考场此设置无效。</span>
								</div>
							</div>
							<div class="form-group">
								<label for="contenttitle" class="control-label col-sm-2">简介：</label>
								<div class="col-sm-9">
									<textarea name="args[lessonintro]" rows="4" class="form-control" id="lessonintro">{x2;$lesson['lessonintro']}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="contenttitle" class="control-label col-sm-2">大纲：</label>
								<div class="col-sm-9">
									<textarea name="args[lessontext]" class="pepeditor" id="lessontext">{x2;$lesson['lessontext']}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2"></label>
								<div class="col-sm-9">
									<button class="btn btn-primary" type="submit">提交</button>
									<input type="hidden" name="modifylesson" value="1">
									<input type="hidden" name="lessonid" value="{x2;$lesson['lessonid']}">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
{x2;if:!$_userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}