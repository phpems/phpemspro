{x2;include:header}<body>{x2;include:nav}<div class="container-fluid">	<div class="row-fluid">		<div class="pep">			<div class="col-xs-2 leftmenu">				{x2;include:menu}			</div>			<div class="col-xs-10" id="datacontent">				<ol class="breadcrumb">					<li><a href="index.php?{x2;$_route['app']}-master">{x2;$apps[$_route['app']]['appname']}</a></li>					<li class="active">用户组</li>				</ol>				<div class="panel panel-default">					<div class="panel-heading">						用户组						<a class="pull-right" href="index.php?user-master-groups-add">增加</a>					</div>					<div class="panel-body">						<table class="table table-hover table-bordered">							<thead>							<tr class="info">								<th width="80">ID</th>								<th width="120">用户组</th>								<th width="120">代码</th>								<th width="80">默认注册</th>								<th width="100">绑定模型</th>								<th>角色描述</th>								<th width="100">操作</th>							</tr>							</thead>							<tbody>							{x2;if:$groups}                            {x2;tree:$groups,group,gid}							<tr>								<td>{x2;v:group['groupid']}</td>								<td>{x2;v:group['groupname']}</td>								<td>{x2;v:group['groupcode']}</td>								<td>{x2;if:v:group['groupdefault']}是{x2;else}<a class="ajax" href="index.php?user-master-groups-setdefault&groupid={x2;v:group['groupid']}&page={x2;$page}{x2;$u}">否</a>{x2;endif}</td>								<td>{x2;v:group['groupmodel']}</td>								<td>{x2;v:group['groupdescribe']}</td>								<td>									<ul class="list-unstyled list-inline">										<li><a href="index.php?user-master-groups-modify&groupid={x2;v:group['groupid']}" title="修改角色">修改</a></li>										<li><a msg="删除后不可恢复，您确定要进行此操作吗？" class="confirm" href="index.php?user-master-groups-del&groupid={x2;v:group['groupid']}&page={x2;$page}{x2;$u}" title="删除角色">删除</a></li>									</ul>								</td>							</tr>                            {x2;endtree}							{x2;else}							<tr>								<td colspan="7">目前没有用户组</td>							</tr>							{x2;endif}							</tbody>						</table>					</div>				</div>			</div>		</div>	</div></div>{x2;include:footer}</body></html>