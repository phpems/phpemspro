{x2;if:!$_userhash}
{x2;globaltpl:ad_header}
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div id="datacontent">
{x2;endif}
				<div class="panel panel-default">
					<div class="panel-heading">
                        {x2;if:$parent}{x2;$categories[$parent]['catname']}{x2;else}一级分类{x2;endif}
						<a href="index.php?content-master-category-add&parent={x2;$parent}" class="pull-right">增加</a>
					</div>
					<div class="panel-body">
						<form action="index.php?content-master-category-order" method="post">
							<fieldset>
								<table class="table table-hover table-bordered">
									<thead>
										<tr class="info">
											<th width="80">排序</th>
											<th width="80">ID</th>
											<th>分类名称</th>
											<th width="160">操作</th>
										</tr>
									</thead>
									<tbody>
										{x2;tree:$categorys['data'],category,cid}
										<tr>
											<td class="form-inline">
												<input type="text" name="ids[{x2;v:category['catid']}]" value="{x2;v:category['catorder']}" class="orderinput"/>
											</td>
											<td>{x2;v:category['catid']}</td>
											<td><span>{x2;v:category['catname']}</span></td>
											<td>
												<ul class="list-inline list-unstyled">
													<li><a href="index.php?content-master-category&parent={x2;v:category['catid']}{x2;$u}">子分类</a></li>
													<li><a href="index.php?content-master-category-modify&catid={x2;v:category['catid']}{x2;$u}">修改</a></li>
													<li><a class="confirm" href="index.php?content-master-category-del&catid={x2;v:category['catid']}&page={x2;$page}{x2;$u}">删除</a></li>
												<ul/>
											</td>
										</tr>
										{x2;endtree}
									</tbody>
								</table>
								<div class="control-group">
									<div class="controls">
										{x2;tree:$search,arg,sid}
										<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
										{x2;endtree}
										<label class="radio inline">
											<button class="btn btn-primary" type="submit">更改排序</button>
										</label>
										<input type="hidden" name="modifycategoryorder" value="1"/>
										<input type="hidden" name="page" value="{x2;$page}"/>
									</div>
								</div>
								{x2;if:$categorys['pages']}
								<ul class="pagination pull-right">
									{x2;$categorys['pages']}
								</ul>
								{x2;endif}
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