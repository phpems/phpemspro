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
					<li><a href="index.php?{x2;$_route['app']}-master-lessons">课程管理</a></li>
					<li class="active">{x2;$categories[$catid]['catname']}</li>
                    {x2;else}
					<li class="active">课程管理</li>
                    {x2;endif}
				</ol>
				<div class="panel panel-default">
					<div class="panel-heading">
                        {x2;if:$catid}{x2;$categories[$catid]['catname']}{x2;else}所有课程{x2;endif}
						<a href="index.php?lesson-master-lessons-add&catid={x2;$catid}" class="pull-right">增加</a>
					</div>
					<div class="panel-body">
						<form action="index.php?lesson-master-lessons" method="post" class="form-inline">
							<table class="table">
								<thead>
									<tr>
										<td>
											内容ID：
										</td>
										<td>
											<input name="search[lessonsid]" class="form-control" size="15" type="text" class="number" value="{x2;$search['lessonsid']}"/>
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
										<td>
											<button class="btn btn-primary" type="submit">提交</button>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="input">
								<input type="hidden" value="1" name="search[argsmodel]" />
							</div>
						</form>
						<form action="index.php?lesson-master-lessons-order" method="post">
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
											<th width="180">操作</th>
										</tr>
									</thead>
									<tbody>
										{x2;tree:$lessons['data'],lesson,lid}
										<tr>
											<td><input type="checkbox" name="delids[{x2;v:lesson['lessonid']}]" value="1"></td>
											<td class="form-inline"><input class="orderinput" type="text" name="ids[{x2;v:lesson['lessonid']}]" value="{x2;v:lesson['lessonorder']}"/></td>
											<td>{x2;v:lesson['lessonid']}</td>
											<td>
												{x2;v:lesson['lessonname']}
											</td>
											<td>
												<a href="index.php?lesson-master-lessons&catid={x2;v:lesson['lessoncatid']}" target="">{x2;$categories[v:lesson['lessoncatid']]['catname']}</a>
											</td>
											<td>
												{x2;v:lesson['lessontime']}
											</td>
											<td class="actions">
												<ul class="list-unstyled list-inline">
													<li><a href="index.php?lesson-master-lessons-members&lessonid={x2;v:lesson['lessonid']}&page={x2;$page}{x2;$u}" title="成员">成员</a></li>
													<li><a href="index.php?lesson-master-lessons-videos&lessonid={x2;v:lesson['lessonid']}&page={x2;$page}{x2;$u}" title="课件">课件</a></li>
													<li><a href="index.php?lesson-master-lessons-modify&lessonid={x2;v:lesson['lessonid']}&page={x2;$page}{x2;$u}" title="修改">修改</a></li>
													<li><a class="confirm" href="index.php?lesson-master-lessons-del&lessonid={x2;v:lesson['lessonid']}&page={x2;$page}{x2;$u}" title="删除">删除</a></li>
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
										<label class="radio-inline hide">
											<input type="radio" name="action" value="movecategory" />移动
										</label>
										<label class="radio-inline">
											<input type="radio" name="action" value="delete" />删除
										</label>
										{x2;tree:$search,arg,sid}
										<input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
										{x2;endtree}
										<label class="radio-inline">
											<button class="btn btn-primary" type="submit">提交</button>
										</label>
										<input type="hidden" name="orderlesson" value="1"/>
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
<script src="index.php?lesson-master-lessons-catsmenu&catid={x2;$catid}"></script>
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