{x2;if:!$_userhash}
{x2;globaltpl:ad_header}
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div id="datacontent">
{x2;endif}
				<ol class="breadcrumb">
					<li><a href="index.php?{x2;$_route['app']}-master-category">分类管理</a></li>
					<li class="active">增加分类</li>
				</ol>
				<div class="panel panel-default">
					<div class="panel-heading">
                        {x2;if:$parent}{x2;$parent['catname']}{x2;else}一级分类{x2;endif}
					</div>
					<div class="panel-body">
						<form action="index.php?content-master-category-add" method="post" class="form-horizontal">
							<fieldset>
								<div class="form-group">
									<label for="modulename" class="control-label col-sm-2">分类名称</label>
									<div class="col-sm-4">
										<input class="form-control" type="text" id="input1" name="args[catname]" value="{x2;$category['catname']}" datatype="userName" needle="needle" msg="您必须输入中英文字符的分类名称">
										<span class="help-block">请输入分类名称</span>
									</div>
								</div>
								<div class="form-group">
									<label for="moduledescribe" class="control-label col-sm-2">分类图片</label>
									<div class="col-sm-9">
										<script type="text/template" id="pe-template-photo">
											<div class="qq-uploader-selector" style="width:30%" qq-drop-area-text="可将图片拖拽至此处上传" style="clear:both;">
												<div class="qq-upload-button-selector" style="clear:both;">
													<ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
														<li class="text-center">
															<div class="thumbnail">
																<img class="qq-thumbnail-selector" alt="点击上传新图片">
																<input type="hidden" class="qq-edit-filename-selector" name="args[catthumb]" tabindex="0">
															</div>
														</li>
													</ul>
													<ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
														<li class="text-center">
															<div class="thumbnail">
																<img class="qq-thumbnail-selector" src="app/core/styles/images/noimage.gif" alt="点击上传新图片">
																<input type="hidden" class="qq-edit-filename-selector" name="args[catthumb]" tabindex="0" value="app/core/styles/images/noimage.gif">
															</div>
														</li>
													</ul>
												</div>
											</div>
										</script>
										<div class="fineuploader" attr-type="thumb" attr-template="pe-template-photo"></div>
									</div>
								</div>
								<div class="form-group">
									<label for="catdes" class="control-label col-sm-2">分类简介</label>
									<div  class="col-sm-10">
										<textarea class="ckeditor" rows="7" id="catdes" name="args[catintro]"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="modulecode" class="control-label col-sm-2">分类模板</label>
									<div class="col-sm-4">
										<select class="form-control" name="args[cattpl]" needle="needle" msg="您必须为这个分类选择一个模板">
                                            {x2;tree:$tpls,tpl,tid}
											<option value="{x2;v:tpl}"{x2;if:$category['cattpl'] == v:tpl} selected{x2;endif}>{x2;v:tpl}</option>
                                            {x2;endtree}
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="catdes" class="control-label col-sm-2"></label>
									<div class="col-sm-10">
										<button class="btn btn-primary" type="submit">提交</button>
										<input type="hidden" name="page" value="{x2;$page}">
										<input type="hidden" name="addcategory" value="1">
										<input type="hidden" name="args[catparent]" value="{x2;$parent['catid']}">
                                        {x2;tree:$search,arg,aid}
										<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
                                        {x2;endtree}
									</div>
								</div>
							</fieldset>
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