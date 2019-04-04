{x2;if:!$_userhash}
{x2;globaltpl:ad_header}
<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div id="datacontent">
{x2;endif}
				<ol class="breadcrumb">
					<li><a href="index.php?{x2;$_app}-master-contents">内容管理</a></li>
					{x2;if:$catid}
					<li><a href="index.php?{x2;$_app}-master-contents&catid={x2;$catid}">{x2;$categories[$catid]['catname']}</a></li>
                    {x2;endif}
					<li class="active">添加内容</li>
				</ol>
				<div class="panel panel-default">
					<div class="panel-heading">
                        增加内容
					</div>
					<div class="panel-body">
						<div style="padding: 10px 0px;overflow:visible">
                            {x2;tree:$models,model,mid}
							<a class="col-xs-3 text-center" href="index.php?content-master-contents-add&modelcode={x2;v:model['modelcode']}">
								<div class="well">
									<h2>{x2;v:model['modelname']}</h2>
									<p>{x2;v:model['modelintro']}</p>
								</div>
							</a>
                            {x2;endtree}
						</div>
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