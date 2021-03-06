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
					<div class="text-center">充值购买</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter">
				<div class="pages-box nopadding">
					<div class="page-ele">
						<ul class="listmenu">
                            <li>
								<div class="col-xs-6">考场名称</div>
								<div class="col-xs-6">{x2;$basic['basic']}</div>
							</li>
                        </ul>
					</div>
				</div>
				<div class="pages-box">
					<form action="index.php?exam-mobile-basic-open" method="post">
						<div class="page-ele clear">
							{x2;if:$package}
							<div class="cartbox">
								<a class="ajax" href="index.php?exam-mobile-basic-package&trid={x2;$subject['subjecttrid']}">
									<div class="cart">
										<div class="col-xs-7">
											<h5 class="title">购买套餐</h5>
											<p>
												购买套餐享更高折扣
											</p>
										</div>
										<div class="col-xs-5 text-warning price">
											￥{x2;$lestprice}<span style="font-size: 0.12rem;">起</span>
										</div>
									</div>
								</a>
							</div>
                            {x2;endif}
							{x2;if:$prices}
							{x2;tree:$prices,price,pid}
							<label class="cartbox">
								<input type="radio" name="opentype" value="{x2;v:key}"{x2;if:!v:key} checked{x2;endif}>
								<div class="cart">
									<div class="col-xs-7">
										<h5 class="title">{x2;v:price['name']}</h5>
										<p>
											使用天数：{x2;v:price['time']}天
										</p>
									</div>
									<div class="col-xs-5 text-warning price">
										￥{x2;v:price['price']}
									</div>
								</div>
							</label>
							{x2;endtree}
							{x2;endif}
						</div>
						{x2;if:!\route::isWeixin()}
						<div class="page-ele clear">
							<div class="col-xs-6">
								<label class="cartbox">
									<input type="radio" name="paytype" value="alipay" checked />
									<div class="cards cart" style="padding: 0.075rem 0rem;">
										<div class="col-xs-4 text-center">
											<img src="public/static/images/zhifubao.png" style="width: 76%;"/>
										</div>
										<div class="col-xs-8">
											<p>支付宝支付</p>
										</div>
									</div>
								</label>
							</div>
							<div class="col-xs-6">
								<label class="cartbox">
									<input type="radio" name="paytype" value="wxpay" />
									<div class="cards cart" style="padding: 0.075rem 0rem;">
										<div class="col-xs-4 text-center">
											<img src="public/static/images/wxpay.png" style="width: 76%;"/>
										</div>
										<div class="col-xs-8">
											<p>微信支付</p>
										</div>
									</div>
								</label>
							</div>
						</div>
						{x2;endif}
						<div class="page-ele clear">
							<button class="btn btn-primary btn-block" type="submit">购买</button>
							<a class="btn btn-danger btn-block hide" href="submit">充值码购买</a>
							<input type="hidden" value="1" name="openbasic" />
						</div>
					</form>
				</div>
			</div>
		</div>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}