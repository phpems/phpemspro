{x2;if:!$_userhash}
{x2;include:header}
<div class="pages">
    {x2;endif}
		<div class="pages-tabs">
			<div class="pages-header">
				<a class="col-xs-2" href="javascript:history.back();"><div class="text-center">
					<i class="glyphicon glyphicon glyphicon-menu-left"></i>
				</div></a>
				<a class="col-xs-8 active">
					<div class="text-center">微信支付</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter" data-refresh="yes">
				<div class="pages-box">
					<div class="page-ele margin">
						<ul class="orders">
							<li class="title">{x2;$order['ordername']} <span class="pull-right">订单号：{x2;$order['ordersn']}</span></li>
							<li class="detail">
								{x2;tree:$order['orderitems'],item,iid}
								{x2;if:$order['ordertype'] == 'exam'}
								<div style="clear: both;overflow: hidden">
									{x2;v:item['basicname']}
									<span class="pull-right info">{x2;v:item['time']}天</span>
								</div>
								{x2;else}
								<div style="clear: both;overflow: hidden">
									{x2;v:item['name']}
									<span class="pull-right info">{x2;v:item['time']}天</span>
								</div>
								{x2;endtree}
								{x2;endtree}
							</li>
							<li class="tip">合计：<span class="price">￥ {x2;$order['orderprice']}</span></li>
						</ul>
					</div>
					{x2;if:$order['orderstatus'] == 1}
					<div class="page-ele clear">
						<p class="col-xs-12">
							<a class="btn btn-primary btn-block ajax" href="javascript:;" onclick="javascript:callpay();">微信支付</a>
						</p>
					</div>
					{x2;elseif:$order['orderstatus'] == 2}
					<div class="page-ele clear">
						<p class="col-xs-12">
							<a class="btn btn-success btn-block ajax" href="javascript:;">已完成</a>
						</p>
					</div>
					{x2;else}
					<div class="page-ele clear">
						<p class="col-xs-12">
							<a class="btn btn-default btn-block ajax" href="javascript:;">已取消</a>
						</p>
					</div>
					{x2;endif}
				</div>
			</div>
		</div>
		<script>
			function jsApiCall()
			{
				WeixinJSBridge.invoke(
					'getBrandWCPayRequest',
						{x2;$jsApiParameters },
					function(res){
						WeixinJSBridge.log(res.err_msg);
						if(res.err_msg == 'get_brand_wcpay_request:cancel')
						{
							pep.mask.show('tips',{'message':'支付取消'});
						}
						else if(res.err_msg == 'get_brand_wcpay_request:ok')
						{
							history.back();
						}
						else
						{
                            pep.mask.show('tips',{'message':'支付失败'});
						}
					}
				);
			}

			function callpay()
			{
				if (typeof WeixinJSBridge == "undefined"){
					if( document.addEventListener ){
						document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
					}else if (document.attachEvent){
						document.attachEvent('WeixinJSBridgeReady', jsApiCall);
						document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
					}
				}else{
					jsApiCall();
				}
			}
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}