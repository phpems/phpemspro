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
					<div class="text-center">例题视频</div>
				</a>
				<a class="col-xs-2">
					<div class="text-center">
						<i class="glyphicon glyphicon-option-horizontal"></i>
					</div>
				</a>
			</div>
			<div class="pages-content nofooter">
				<div class="pages-box">
					<div class="page-ele margin">
						<div id="videobox" class="page-video">
							<video id="videocontainer" src="{x2;$point['pointvideo']}"></video>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(function(){
				var videoObject = {
					container: '#videobox', //容器的ID或className
					variable: 'player',//播放函数名称
					mobileCkControls:true,//是否在移动端（包括ios）环境中显示控制栏
					mobileAutoFull:false,//在移动端播放后是否按系统设置的全屏播放
					h5container:'#videocontainer',//h5环境中使用自定义容器
					loop:false,
					video: '{x2;$point['pointvideo']}'
				};
				var player = new ckplayer(videoObject);
			});
		</script>
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}