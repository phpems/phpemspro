{x2;if:!$_userhash}
{x2;include:header}
<div class="pages">
    {x2;endif}
    {x2;if:!$_userhash || !$videoid}
    <div class="pages-tabs" id="lesson-videos">
    {x2;endif}
        <div class="pages-header">
            <a class="col-xs-2" href="javascript:history.back();">
                <div class="text-center">
                    <i class="glyphicon glyphicon glyphicon-menu-left"></i>
                </div>
            </a>
            <a class="col-xs-8 active">
                <div class="text-center">{x2;substring:$lesson['lessonname'],42}</div>
            </a>
            {x2;if:$status}
            <a class="col-xs-2">
                <div class="text-center">
                    <i class="glyphicon glyphicon-option-horizontal"></i>
                </div>
            </a>
            {x2;else}
            <a class="col-xs-2 ajax" data-title="购买课程" data-page="yes" href="index.php?lesson-mobile-lesson-open&lessonid={x2;$lesson['lessonid']}">
                <div class="text-center">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                </div>
            </a>
            {x2;endif}
        </div>
        <div class="pages-content nofooter">
            <div class="pages-box nopadding">
                <div id="videobox" class="page-video">
                    <video id="videocontainer" src="{x2;$video['videopath']}"></video>
                </div>
            </div>
            <div class="pages-box nopadding">
                <div class="page-ele margin videos" id="videos-list">
                    <h5 class="bigtitle">{x2;$lesson['lessonname']}</h5>
                    <hr style="margin:0.1rem 0px"/>
                    <ul class="listmenu">
                        {x2;tree:$videos,video,vid}
                        <li>
                            <a class="ajax{x2;if:$video['videoid'] == v:video['videoid']} playing{x2;endif}" href="index.php?lesson-mobile-lesson&lessonid={x2;$lesson['lessonid']}&videoid={x2;v:video['videoid']}" data-target="lesson-videos">
                                {x2;v:video['videoname']}
                                <i class="glyphicon glyphicon-play-circle pull-right"></i>
                            </a>
                        </li>
                        {x2;endtree}
                    </ul>
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
                $('#videos-list').css('height',$(window).height() - 340);
            });
        </script>
    {x2;if:!$_userhash || !$videoid}
    </div>
    {x2;endif}
    {x2;if:!$_userhash}
</div>
{x2;include:footer}
{x2;endif}