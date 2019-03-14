{x2;if:!$_userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div class="col-xs-2 leftmenu">
				<div id="catsmenu"></div>
			</div>
			<div class="col-xs-10" id="datacontent">
{x2;endif}
				<ol class="breadcrumb">
					<li><a href="index.php?{x2;$_route['app']}-master">{x2;$apps[$_route['app']]['appname']}</a></li>
                    {x2;if:$catid}
					<li><a href="index.php?{x2;$_route['app']}-master-contents">内容管理</a></li>
					<li class="active">{x2;$categories[$catid]['catname']}</li>
                    {x2;else}
					<li class="active">内容管理</li>
                    {x2;endif}
				</ol>
				<div class="panel panel-default">
					<div class="panel-heading">
                        {x2;if:$catid}{x2;$categories[$catid]['catname']}{x2;else}所有内容{x2;endif}
						<a href="index.php?content-master-contents-addpage&catid={x2;$catid}" class="pull-right">增加</a>
					</div>
					<div class="panel-body">
						<form action="index.php?content-master-contents" method="post" class="form-inline">
							<table class="table">
								<thead>
									<tr>
										<td>
											内容ID：
										</td>
										<td>
											<input name="search[contentid]" class="form-control" size="15" type="text" class="number" value="{x2;$search['contentid']}"/>
										</td>
										<td>
											录入时间：
										</td>
										<td>
											<input class="form-control datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="search[stime]" size="10" id="stime" value="{x2;$search['stime']}"/> - <input class="form-control datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" size="10" type="text" name="search[etime]" id="etime" value="{x2;$search['etime']}"/>
										</td>
										<td>
											关键字：
										</td>
										<td>
											<input class="form-control" name="search[keyword]" size="15" type="text" value="{x2;$search['keyword']}"/>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											录入人：
										</td>
										<td>
											<input class="form-control" name="search[username]" size="15" type="text" value="{x2;$search['username']}"/>
										</td>
										<td>
											内容模型：
										</td>
										<td>
											<select name="search[contentmodelcode]" class="form-control">
												<option value="0">不限</option>
												{x2;tree:$models,model,mid}
												<option value="{x2;v:model['modelcode']}"{x2;if:$search['contentmodelcode'] == v:model['modelcode']} selected{x2;endif}>{x2;v:model['modelname']}</option>
												{x2;endtree}
											</select>
										</td>
										<td>
											<button class="btn btn-primary" type="submit">提交</button>
										</td>
										<td></td>
									</tr>
								</tbody>
							</table>
							<div class="input">
								<input type="hidden" value="1" name="search[argsmodel]" />
							</div>
						</form>
						<form action="index.php?content-master-contents-order" method="post">
							<fieldset>
								<table class="table table-hover table-bordered">
									<thead>
										<tr class="info">
											<th width="36"><input type="checkbox" class="checkall" target="delids"/></th>
											<th width="60">权重</th>
											<th width="40">ID</th>
											<th>标题</th>
											<th width="120">分类</th>
											<th width="180">发布时间</th>
											<th width="100">操作</th>
										</tr>
									</thead>
									<tbody>
										{x2;tree:$contents['data'],content,cid}
										<tr>
											<td><input type="checkbox" name="delids[{x2;v:content['contentid']}]" value="1"></td>
											<td class="form-inline"><input class="orderinput" type="text" name="ids[{x2;v:content['contentid']}]" value="{x2;v:content['contentorder']}"/></td>
											<td>{x2;v:content['contentid']}</td>
											<td>
												{x2;v:content['contenttitle']}
											</td>
											<td>
												<a href="?content-master-contents&catid={x2;v:content['contentcatid']}" target="">{x2;$categories[v:content['contentcatid']]['catname']}</a>
											</td>
											<td>
												{x2;v:content['contenttime']}
											</td>
											<td class="actions">
												<ul class="list-unstyled list-inline">
													<li><a href="index.php?content-master-contents-modify&contentid={x2;v:content['contentid']}&page={x2;$page}{x2;$u}" title="修改">修改</a></li>
													<li><a class="confirm" href="index.php?content-master-contents-del&catid={x2;v:content['cncatid']}&contentid={x2;v:content['contentid']}&page={x2;$page}{x2;$u}" title="删除">删除</a></li>
												</ul>
											</td>
										</tr>
										{x2;endtree}
									</tbody>
								</table>
								<div class="control-group">
									<div class="controls">
										<label class="radio-inline">
											<input type="radio" name="action" value="order" checked/>排序
										</label>
										<label class="radio-inline">
											<input type="radio" name="action" value="move" />移动
										</label>
										<label class="radio-inline">
											<input type="radio" name="action" value="delete" />删除
										</label>
										{x2;tree:$search,arg,sid}
										<input type="hidden"-name="search[{x2;v:key}]" value="{x2;v:arg}"/>
										{x2;endtree}
										<label class="radio-inline">
											<button class="btn btn-primary" type="submit">提交</button>
										</label>
										<input type="hidden" name="ordercontent" value="1"/>
										<input type="hidden" name="catid" value="{x2;$catid}"/>
										<input type="hidden" name="page" value="{x2;$page}"/>
									</div>
								</div>
								{x2;if:$contents['pages']}
								<ul class="pagination pull-right">
									{x2;$contents['pages']}
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
<script src="index.php?content-master-contents-catsmenu&catid={x2;$catid}"></script>
<script>
    $('#catsmenu').treeview({
        levels: {x2;$catlevel},
        expandIcon: 'glyphicon glyphicon-chevron-right',
        collapseIcon: 'glyphicon glyphicon-chevron-down',
        selectedColor: "#000000",
        selectedBackColor: "#FFFFFF",
        enableLinks: true,
        data: treeData
    });
</script>
{x2;include:footer}
</body>
</html>
{x2;endif}