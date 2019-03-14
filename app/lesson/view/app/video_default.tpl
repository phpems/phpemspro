{x2;include:header}
<body>
{x2;include:top}
<div class="container-fluid">
	<div class="row-fluid nav">
		<div class="pep nav">
			<div class="col-xs-4 title">
				<ul class="list-unstyled list-inline">
					<li class="nopadding"><a href="index.php"><img src="public/static/images/index_logo.jpg" /></a></li>
				</ul>
			</div>
			<div class="col-xs-5">
				<ul class="list-unstyled list-inline">
					<li class="title">{x2;$lesson['lessonname']}</li>
				</ul>
			</div>
			<div class="col-xs-3 text-right">
                {x2;if:!$status}
				<a class="btn btn-primary" style="margin-top: 20px;" href="index.php?lesson-app-lesson-open&lessonid={x2;$lesson['lessonid']}"><i class="glyphicon glyphicon-yen"></i> 开通  </a>
                {x2;endif}
				<a class="btn btn-default" style="margin-top: 20px;" href="index.php?lesson-app-category&catid={x2;$lesson['lessoncatid']}"><i class="glyphicon glyphicon-chevron-left"></i> 返回  </a>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels">
			<div class="col-xs-8">
				<div id="videobox" class="videopage" style="height: 600px;">
					<video id="videocontainer" src="{x2;$video['videopath']}"></video>
				</div>
				<div class="panel panel-default pagebox margin">
					<div class="panel-heading">
						<a class="btn btn-primary" onclick="javascript:$(this).addClass('btn-primary').removeClass('btn-default').siblings().removeClass('btn-primary').addClass('btn-default');$('#videolists').removeClass('hide');$('#videotext').addClass('hide');"><i class="glyphicon glyphicon-th-list"></i> 视频简介</a>
						<a class="btn btn-default" onclick="javascript:$(this).addClass('btn-primary').removeClass('btn-default').siblings().removeClass('btn-primary').addClass('btn-default');$('#videolists').addClass('hide');$('#videotext').removeClass('hide');"><i class="glyphicon glyphicon-list-alt"></i> 课程大纲</a>
					</div>
					<div class="panel-body pagebox padding">
						<div class="col-xs-12 clear" id="videolists">
                            {x2;$video['videointro']}
						</div>
						<div class="col-xs-12 clear hide" id="videotext">
							{x2;realhtml:$lesson['lessontext']}
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-4 nopadding">
				<div class="panel panel-default pagebox border">
					<div class="panel-heading bold">
                        视频列表
					</div>
					<div class="panel-body">
						<ul class="list-group" style="max-height: 750px;overflow-y: scroll;">
							{x2;tree:$videos,video,vid}
							<li class="list-group-item">
								<a class="{x2;if:$video['videoid'] == v:video['videoid']} playing{x2;endif}" href="index.php?lesson-app-lesson&lessonid={x2;$lesson['lessonid']}&videoid={x2;v:video['videoid']}">
									{x2;v:video['videoname']}
								</a>
							</li>
							{x2;endtree}
						</ul>
					</div>
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
            video: '{x2;$video['videopath']}'
        };
        var player = new ckplayer(videoObject);
        var allowseek = true;
        player.addListener('play', function(){
            if(allowseek)
            {
                //player.videoSeek(110);
                allowseek = false;
            }
        });
    });
</script>
{x2;include:footer}
</body>
</html>