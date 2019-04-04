{x2;if:!$_userhash}
{x2;globaltpl:ad_header}
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div id="datacontent">
                {x2;endif}
				<ol class="breadcrumb">
					<li><a href="index.php?{x2;$_route['app']}-master-contents&page={x2;$page}">内容管理</a></li>
					<li class="active">移动分类</li>
				</ol>
				<div class="panel panel-default">
					<div class="panel-heading">
						移动分类
					</div>
					<div class="panel-body">
						<form action="index.php?content-master-contents-movecategory" method="post" class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-2">内容ID</label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="contentids" value="{x2;$contentids}" needle="needle" msg="您必须输入标题" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">目标分类</label>
								<div class="col-sm-4">
									<select msg="您必须选择一个目标分类" needle="needle" class="autocombox form-control" name="targetcatid" refUrl="index.php?content-master-category-ajax-getchildcategory&catid={value}">
										<option value="">选择一级分类</option>
										{x2;tree:$parentcat,cat,cid}
										<option value="{x2;v:cat['catid']}">{x2;v:cat['catname']}</option>
										{x2;endtree}
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2"></label>
								<div class="col-sm-9">
									<button class="btn btn-primary" type="submit">提交</button>
									<a class="btn btn-primary" href="index.php?content-master-contents&page={x2;$page}{x2;$u}">取消</a>
									{x2;tree:$search,arg,sid}
									<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
									{x2;endtree}
									<input type="hidden" name="movecategory" value="1">
									<input type="hidden" name="catid" value="{x2;$catid}">
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