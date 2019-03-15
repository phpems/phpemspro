{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels">
			<div class="col-xs-3">
				<div class="leftmenu">
					<div class="topbox">
						分类导航
					</div>
					<ul class="list-unstyled">
                        {x2;if:$catchildren}
                        {x2;tree:$catchildren,child,cid}
						<a href="index.php?content-app-category&catid={x2;v:child['catid']}">
							<li{x2;if:$cat['catid'] == v:child['catid']} class="active"{x2;endif}>
                                {x2;v:child['catname']}
								<i class="glyphicon glyphicon-menu-right pull-right"></i>
							</li>
						</a>
                        {x2;endtree}
                        {x2;else}
                        {x2;tree:$catbrother,child,cid}
						<a href="index.php?content-app-category&catid={x2;v:child['catid']}">
							<li{x2;if:$cat['catid'] == v:child['catid']} class="active"{x2;endif}>
                                {x2;v:child['catname']}
								<i class="glyphicon glyphicon-menu-right pull-right"></i>
							</li>
						</a>
                        {x2;endtree}
                        {x2;endif}
					</ul>
				</div>
			</div>
			<div class="col-xs-9 nopadding">
				<div class="panel panel-default pagebox border">
					<div class="panel-heading bold">
                        {x2;$cat['catname']}
					</div>
					<div class="panel-body">
						<h2 class="text-center">{x2;$content['contenttitle']}</h2>
						<p class="text-center intros">{x2;$content['contenttime']}</p>
						<hr />
						<div class="contenttext">
							{x2;realhtml:$content['contenttext']}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>