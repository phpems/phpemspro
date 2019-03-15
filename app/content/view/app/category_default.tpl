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
						<ul class="list-group">
                            {x2;tree:$contents['data'],content,cid}
							<li class="list-group-item">
								<a  href="index.php?content-app-content&contentid={x2;v:content['contentid']}">
                                    {x2;v:content['contenttitle']}
								</a>
								<span class="pull-right">
									<span class="intros">{x2;v:content['contenttime']}</span>
								</span>
							</li>
                            {x2;endtree}
						</ul>
                        {x2;if:$contents['pages']}
						<ul class="pagination pull-right">
                            {x2;$contents['pages']}
						</ul>
                        {x2;endif}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>