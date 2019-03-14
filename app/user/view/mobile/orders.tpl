{x2;if:!$_userhash}
{x2;include:header}
<div class="pages">
    {x2;endif}
		{x2;if:$page <= 1}
		<div class="pages-tabs">
			<div class="pages-header">
				<a class="col-xs-2" href="javascript:history.back();"><div class="text-center">
					<i class="glyphicon glyphicon glyphicon-menu-left"></i>
				</div></a>
				<a class="col-xs-8 active">
					<div class="text-center">我的订单</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter" data-pageurl="index.php?user-mobile-orders" data-scroll="yes">
				<div class="pages-box">
					{x2;endif}
					{x2;tree:$orders['data'],order,oid}
					<div class="page-ele margin">
						<ul class="orders">
							<li class="title">{x2;v:order['ordername']} <span class="pull-right">订单号：{x2;v:order['ordersn']}</span></li>
							<li class="detail">
								{x2;tree:v:order['orderitems'],item,iid}
								{x2;if:v:order['ordertype'] == 'exam'}
								<div style="clear: both;overflow: hidden">
									{x2;v:item['basicname']}{x2;v:item['lessonname']}
									<span class="pull-right info">{x2;v:item['time']}天</span>
								</div>
								{x2;else}
								<div style="clear: both;overflow: hidden">
                                    {x2;v:item['basicname']}{x2;v:item['lessonname']}
									<span class="pull-right info">{x2;v:item['time']}天</span>
								</div>
								{x2;endtree}
								{x2;endtree}
							</li>
							<li class="tip">合计：<span class="price">￥ {x2;v:order['orderprice']}</span></li>
						</ul>
					</div>
					{x2;endtree}
                    {x2;if:$page <= 1}
				</div>
			</div>
		</div>
    	{x2;endif}
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}