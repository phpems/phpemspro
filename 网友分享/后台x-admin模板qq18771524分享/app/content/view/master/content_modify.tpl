{x2;if:!$_userhash}
{x2;globaltpl:ad_header}
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div id="datacontent">
{x2;endif}
				<ol class="breadcrumb">
					<li><a href="index.php?{x2;$_route['app']}-master-contents&page={x2;$page}">所有内容</a></li>
					<li><a href="index.php?{x2;$_route['app']}-master-contents&catid={x2;$cat['catid']}">{x2;$cat['catname']}</a></li>
					<li class="active">修改内容</li>
				</ol>
				<div class="panel panel-default">
					<div class="panel-heading">
						修改内容
					</div>
					<div class="panel-body">
						<form action="index.php?content-master-contents-modify" method="post" class="form-horizontal">
                            {x2;tree:$forms,form,fid}
                            {x2;if:v:form['type'] != 'hidden' && v:form['id'] != 'contentcatid'}
							<div class="form-group">
								<label for="contenttitle" class="control-label col-sm-2">{x2;v:form['title']}：</label>
								<div class="col-sm-9">
                                    {x2;v:form['html']}
								</div>
							</div>
                            {x2;endif}
                            {x2;endtree}
							<div class="form-group">
								<label for="contenttemplate" class="control-label col-sm-2">模版：</label>
								<div class="col-sm-3">
									<select class="form-control" name="args[contenttpl]" id="contenttpl">
										{x2;tree:$tpls,tpl,tid}
										<option value="{x2;v:tpl}"{x2;if:$content['contenttpl'] == v:tpl} selected{x2;endif}>{x2;v:tpl}</option>
										{x2;endtree}
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="contenttemplate" class="control-label col-sm-2"></label>
								<div class="col-sm-9">
									<button class="btn btn-primary" type="submit">提交</button>
									<input type="hidden" name="contentid" value="{x2;$content['contentid']}">
									<input type="hidden" name="modifycontent" value="1">
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