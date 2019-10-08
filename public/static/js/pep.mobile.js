var pep = {
    'version':'1.0',
    'copyright':'phpems pro',
    'width':$(window).width(),
    'height':$(window).height(),
    'clock':{},
    'allowpre':true,
    'prePages':[],
    'prePage':null,
    'currentAjax':false,
    'ajaxSending':false,
    'initpage':function(page,tabindex,initscroll){
        for(x in pep.clock)
        {
            clearInterval(pep.clock[x]);
        }
        if(tabindex >= 0)
        {
            var cp = page.find('.pages-tabs').hide().eq(tabindex).show();
            page.attr('data-index',tabindex);
            var cnt = cp.find('.pages-content:first');
        }
        else
        var cnt = page.find('.pages-content:first');
        if(initscroll)page.attr('data-scrolltop',0);
        if(page.attr('data-scrolltop') > 0)
        {
            cnt.scrollTop(page.attr('data-scrolltop'));
        }

        if(cnt.attr('data-scroll') == 'yes')
        {
            var loading = false;
            cnt.scroll(function(){
                var _this = $(this),
                    viewH = _this.height(),
                    contentH = _this.get(0).scrollHeight,
                    scrollTop = _this.scrollTop();
                if(pep.isTrueVar(_this.attr('data-pageurl')))
                {
                    if(scrollTop/(contentH -viewH) >= 0.99 && !loading){
                        loading = true;
                        var page = parseInt(_this.attr('data-pagenumber'));
                        if(page != page || page <= 2)page = 2;
                        $.get(_this.attr('data-pageurl')+'&page='+page+'&userhash='+Math.random(),function(data){
                            data = $.trim(data);
                            if(data != '')
                            {
                                $(data).appendTo(_this.find('.pages-box:first'));
                                _this.attr('data-pagenumber',page+1);
                                loading = false;
                            }
                        });
                    }
                }
            });
        }
    },
    'isTrueVar':function(v){
        if(!v)return false;
        if("undefined" != typeof v)
        {
            if('string' == (typeof v).toLowerCase() && v == '')
            {
                return false;
            }
            return true;
        }
        else return false;
    },
    'setPrepage':function(item){
        pep.prePages = $.parseJSON(localStorage.getItem('prepages'));
        if(!pep.isTrueVar(pep.prePages))
        {
            pep.prePages = {};
        }
        pep.prePages[item.id] = item;
        localStorage.setItem('prepages',$.toJSON(pep.prePages));
        return true;
    },
    'getPrepage':function(id){
        pep.prePages = $.parseJSON(localStorage.getItem('prepages'));
        if(!pep.isTrueVar(pep.prePages))return false;
        var p = pep.prePages[id];
        localStorage.setItem('prepages',$.toJSON(pep.prePages));
        return p;
    },
    'goPage':function(e){
        //跳转到一个目标页面
        if(e && e.preventDefault )e.preventDefault();
        else window.event.returnValue = false;
        if(pep.ajaxSending)return false;

        var index = parseInt($('.pages:first').attr('data-index'));
        if(index != index || index < 0 )index = 0;
        $('.pages:first').attr('data-scrolltop',$('.pages:first').find('.pages-tabs').eq(index).find('.pages-content:first').scrollTop());

        var o = $(this);
        if(!o.attr("data-url") || o.attr("data-url") == '')o.attr("data-url",o.attr("href"));
        if(o.attr("data-url").substring(0,7) == 'http://' || o.attr("data-url").substring(0,8) == 'https://')
        {
            window.location = o.attr("data-url");
            return;
        }
        var par = {'url':o.attr("data-url"),'target':o.attr("data-target"),'page':o.attr("data-page"),'title':o.attr("data-title"),'action-before':o.attr("action-before")};
        var page = false;
        if(o.attr("data-page") == 'yes')
        {
            page = pep.newPage(par.title);
        }
        submitAjax(par,page);
    },
    'goPrePage':function(){
        //跳转到上一个页面
        if(pep.allowpre == false)
        {
            pep.mask.show('tips',{'message':'操作过于频繁！'});
            window.history.pushState('','','');
            return false;
        }
        if(pep.countdownloop != null)
        {
            clearInterval(pep.countdownloop);
            pep.countdownloop = null;
        }
        var p = {'id':hex_md5(window.location.pathname + window.location.search),'url':window.location.pathname + window.location.search,'tabindex':$('.pages:first').attr('data-index')};
        var mp = pep.getPrepage(p.id);
        p.time = pep.isTrueVar(mp.time)?mp.time:0;
        p.tabindex = pep.isTrueVar(mp.tabindex)?mp.tabindex:null;

        if(pep.isTrueVar(p.id) && pep.isTrueVar($('body').data(p.id)) && (new Date().getTime() - p.time < 900000))
        {
            $('body').data(p.id).appendTo($('body'));
            pep.initpage($('.pages:last'),p.tabindex);
            $('.pages:first').addClass('pt-page-moveToRight');
            $('.pages:last').addClass('pt-page-moveFromLeft');
        }
        else
        {
            var par = {'url':p.url,'tabindex':p.tabindex};
            var page = pep.newPage('',true);
            submitAjax(par,page,true);
        }
    },
    'newPage':function(title,ispre){
        if(!pep.isTrueVar(title))title = '正在加载';
        var page = $('<div class="pages">'+
            '<div class="pages-tabs">'+
                '<div class="pages-header">'+
                    '<a class="col-xs-2"><div class="text-center">'+
                        '<i class="glyphicon glyphicon-menu-left"></i>'+
                    '</div></a>'+
                    '<a class="col-xs-8 active">'+
                        '<div class="text-center">'+title+'</div>'+
                    '</a>'+
                    '<a class="col-xs-2">'+
                        '<div class="text-center">'+
                            '<i class="glyphicon glyphicon-option-horizontal"></i>'+
                        '</div>'+
                    '</a>'+
                '</div>'+
                '<div class="pages-content text-center" style="padding-top: 0.5rem;"></div>'+
            '</div>'+
        '</div>');
        /*
        *   var circle = new Sonic({
            width: 50,
            height: 50,
            padding: 50,
            strokeColor: '#E8581B',
            pointDistance: .01,
            stepsPerFrame: 3,
            trailLength: .7,
            step: 'fader',
            setup: function() {
                this._.lineWidth = 5;
            },
            path: [
                ['arc', 25, 25, 25, 0, 360]
            ]
        });
        circle.play();
        $(circle.canvas).appendTo(page.find('.pages-content'));
        page.appendTo($('body'));
        * */
        var m = $('<div class="mask"><div class="text-center" style="margin-top: 1rem;"><img src="public/static/images/loader.gif" style="width: 0.45rem;"/></div></div>');
        m.appendTo($('body'));
        page.appendTo($('body'));
        if(ispre)
        {
            $('.pages:first').addClass('pt-page-moveToRight');
            $('.pages:last').addClass('pt-page-moveFromLeft');
        }
        else
        {
            var pre = {'id':hex_md5(window.location.pathname + window.location.search),'time':new Date().getTime(),'url':window.location.pathname + window.location.search,'tabindex':$('.pages:first').attr('data-index')};
            if($('.pages:first').find('.pages-content:first').attr('data-nocache') != 'yes')
            $('body').data(pre.id,$('.pages:first'));
            pep.setPrepage(pre);
            $('.pages:first').addClass('pt-page-moveToLeft');
            $('.pages:last').addClass('pt-page-moveFromRight');
        }
        return page;
    },
    'mask':(function(){
        var timer = null;
        return {
            'show':function(type,target,func){
                pep.mask.remove();
                var m = $('<div class="mask"></div>');
                var msg = $(target).attr('message');
                if(!msg || msg == '')msg = '非法操作！';
                switch(type) {
                    case 'confirm':
                        var cnt = $('<div class="maskbox"></div>'+
                        '<div class="confirmTips">'+
                            '<div class="tipbox">'+msg+'</div>'+
                            '<div class="tiptitle">'+
                                '<div class="col-xs-6 confirm"> 确定 </div>'+
                                '<div class="col-xs-6 cancel"> 取消 </div>'+
                            '</div>'+
                        '</div>');
                        cnt.appendTo(m);
                        m.appendTo($('body'));
                        cnt.find('.cancel').on('click',pep.mask.remove);
                        cnt.find('.confirm').on('click',function(){
                            pep.mask.remove();
                            func();
                        });
                        break;
                    case 'warning':
                        var cnt = $('<div class="maskbox"></div>'+
                        '<div class="dangerTips">'+
                            '<div class="tipbox">'+msg+'</div>'+
                            '<div class="tiptitle">'+
                                '确定'+
                            '</div>'+
                        '</div>');
                        cnt.appendTo(m);
                        m.appendTo($('body'));
                        cnt.find('.tiptitle').on('click',function(){
                            pep.mask.remove();
                            if(pep.isTrueVar($(target).attr('forwardUrl')))
                            {
                                if("undefined" != typeof target.page)
                                submitAjax({'url':$(target).attr('forwardUrl')},target.page);
                                else
                                submitAjax({'url':$(target).attr('forwardUrl')});
                            }
                        });
                        break;
                    default:
                        var cnt = $('<div class="tips">'+msg+'</div>');
                        cnt.appendTo(m);
                        m.appendTo($('body'));
                        cnt.css('left',(pep.width - cnt.outerWidth(true))/2);
                        timer = setTimeout(function(){
                            pep.mask.remove();
                        },1500);
                        break;
                }

            },
            'remove':function(){
                if(timer != null){
                    clearTimeout(timer);
                    timer = null;
                }
                $('.mask').remove();
            }
        };
    })()
};
function submitAjax(parms,page,ispre){
    if(!parms.query)parms.query = "";
    parms.query += "&userhash="+Math.random();
    if(parms['action-before'])eval(parms['action-before'])();
    if(parms['action-after'])eval(parms['action-after'])();
    pep.currentAjax = $.ajax({"url":parms.url,
        "type":"post",
        "data":parms.query,
        "beforeSend":function(){
            pep.ajaxSending = true;
        },
        'error':function(){
            pep.mask.show('tips',{'message':'网络异常，请检查网络设置！'});
            setTimeout(function(){
                pep.ajaxSending = false;
            },500);
        },
        'timeout':20000,
        "success":function(data){
            setTimeout(function(){
                pep.ajaxSending = false;
            },500);
            var tmp = null;
            try{
                tmp = $.parseJSON(data);
            }
            catch(e)
            {}
            finally{
                if(tmp){
                    data = tmp;
                    pep.mask.remove();
                    if(parseInt(data.statusCode) == 200){
                        if(!data.time)data.time = 500;
                        if(data.message)
                        {
                            pep.mask.show('tips',data);
                        }
                        else
                        {
                            data.time = 1;
                        }
                        setTimeout(function(){
                            if(data.callbackType == 'forward')
                            {
                                if(data.forwardUrl && data.forwardUrl != '')
                                {
                                    pep.mask.remove();
                                    if(data.forwardUrl == 'reload')
                                    {
                                        var href = window.location.pathname;
                                        if(href && href != '')
                                        {
                                            submitAjax({'url': href,'target':$('.pages:first')[0]});
                                        }
                                    }
                                    else if(data.forwardUrl == 'back')
                                    {
                                        setTimeout(function(){history.back(-1);},500);
                                    }
                                    else
                                    {
                                        submitAjax({'url': data.forwardUrl},page);
                                    }
                                }
                            }
                            if(data.callback)
                            {
                                eval(data.callback)();
                            }
                        },data.time);
                    }else if(parseInt(data.statusCode) == 201){
                        if(data.message)
                        {
                            pep.mask.show('tips',data);
                        }
                        if(data.callbackType == 'forward'){
                            if(data.forwardUrl && data.forwardUrl != '')
                            {
                                if(data.forwardUrl == 'reload')
                                {
                                    window.location.reload();
                                }
                                else if(data.forwardUrl == 'back')
                                {
                                    history.back(-1);
                                }
                                else
                                {
                                    window.location.replace(data.forwardUrl);
                                }
                            }
                        }
                        else{
                            window.location.replace(data.forwardUrl);
                        }
                    }else if(parseInt(data.statusCode) == 300){
                        data.page = page;
                        pep.mask.show('warning',data);
                    }else if(parseInt(data.statusCode) == 301){
                        setTimeout(function(){
                            pep.mask.show('warning',data);
                        },500);
                    }
                    else{
                        pep.mask.show('tips',data);
                    }
                    return;
                }
                else
                {
                    if(data)
                    {
                        if(parms.target)
                        {
                            if((typeof parms.target).toLowerCase() == 'string')
                            $('#'+parms.target).html(data);
                            else
                            {
                                $(parms.target).html(data);
                            }
                        }
                        else
                        {
                            if(!page)page = pep.newPage(parms.title);
                            var inner = $('<div class="pages">'+data+'</div>');
                            setTimeout(function(){
                                //page.html(data);
                                pep.initpage(inner,parms.tabindex);
                                page.replaceWith(inner);
                                $('.mask').remove();
                            },300);
                            if(ispre != true)
                            history.pushState({'id':parms.url},parms.title,parms.url);
                        }
                    }
                    return page;
                }
            }
        }
    });
}
function xvars(x){
    var _this = this;
    String.prototype.replaceAll  = function(s1,s2){
        return this.replace(new RegExp(s1,"gm"),s2);
    }

    var ginkgo = function(x){
        return core(/(.)*$/gi,x);
    }

    var price = function(x){
        return core(/\d+\.*\d*$/gi,x);
    }

    var datatable = function(x){
        return core(/(\w)+/gi,x);
    }

    var keyword = function(x){
        x.value = x.value.replaceAll('，',',');
        return core(/^[\s|\S]+$/gi,x);
    }

    var english = function(x){
        return core(/^[a-z]+$/gi,x);
    }

    var userid = function(x){
        return core(/^[0-9]+$/gi,x);
    }

    var exp = function(x){
        return core(eval(x.getAttribute('exp')),x);
    }

    var qq = function(x){
        return core(/^\d{5,12}$/gi,x);
    }

    var date = function(x){
        return core(/^\d{4}-\d{1,2}-\d{1,2}$/gi,x);
    }

    var datetime = function(x){
        return core(/^\d{4}-\d{1,2}-\d{1,2}\s\d+:\d+:\d+$/gi,x);
    }

    var telphone = function(x){
        return core(/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/gi,x);
    }

    var cellphone = function(x){
        return core(/^((\(\d{3}\))|(\d{3}\-))?13[0-9]\d{8}?$|15[89]\d{8}?$/gi,x);
    }

    var url = function(x){
        return core(/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/gi,x);
    }

    var userName = function(x){
        return core(/^[\u0391-\uFFE5|\w]{2,40}$/gi,x);
    }

    var title = function(x){
        return _this.core(/^[\u0391-\uFFE5|\w|\s|-]+$/gi,x);
    }

    var password = function(x){
        return core(/^[\s|\S]{6,}$/gi,x);
    }

    var zipcode = function(x){
        return core(/^[1-9]\d{5}$/gi,x);
    }

    var email = function(x){
        return core(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/gi,x);
    }

    var randcode = function(x){
        return core(/^\d{4}$/gi,x);
    }

    var template = function(x){
        return core(/^\w+$/gi,x);
    }

    var category = function(x){
        return core(/^,[\d|,]+$/gi,x);
    }

    var relation = function(x){
        return core(/^[\d|,|-]+$/gi,x);
    }

    var number = function(x){
        return core(/^\d+$/gi,x);
    }

    var nature = function(x){
        return core(/^[1-9]{1}[0-9]?$/gi,x);
    }
    var core = function(exp,x)
    {
        if(x.attr('type') && x.attr('type').toUpperCase() == 'FILE')
        {
            return {result:true};
        }
        var maxsize = parseInt(x.attr('max'));
        var minsize = parseInt(x.attr('min'));
        var needle = x.attr('needle');
        if( x.attr('type')!='password' && x.val())x.val(x.val().replace(/^\s+/i,'').replace(/\s+$/i,''));
        if(x.get(0).tagName.toUpperCase() == "SELECT"){
            if(needle && x.val() == ""){
                return {result:false,message:x.attr('msg')};
            }
        }

        if(x.attr('maxvalue'))
        {
            var maxv = parseInt(x.attr('maxvalue'));
            if(parseInt(x.val()) > maxv)return {result:false,message:"最大值不能超过"+x.attr('maxvalue')};
        }

        if(x.attr('minvalue'))
        {
            var minv = parseInt(x.attr('minvalue'));
            if(parseInt(x.val()) < minv)return {result:false,message:"最小值不能低于"+x.attr('minvalue')};
        }

        if(x.attr('type')=='checkbox'){
            if(needle && !x.attr('checked')){
                return {result:false,message:x.attr('msg')};
            }
        }
        else{
            if(!needle && x.val() == '')return {result:true};
        }
        if(needle && (x.val() == '' || !x.val()))
            return {result:false,message:x.attr('msg')};
        if(x.attr('equ') && x.attr('equ')!='')
        {
            if(x.val() != $('#'+x.attr('equ')).val())
            {
                return {result:false,message:x.attr('msg')};
            }
        }
        if(maxsize > 0 && x.val().length > maxsize)return {result:false,message:x.attr('msg')};
        if(minsize > 0 && x.val().length < minsize)return {result:false,message:x.attr('msg')};
        try{
            if(x.val().match(exp))return {result:true};
            else return {result:false,message:x.attr('msg')};
        }
        catch(e){
            return false;
        }
    }

    var checkvars = function(x)
    {
        if(x.attr('ajax') == 'get' || x.attr('ajax') == 'post'){
            var d = eval("({'"+x.attr('name')+"':'"+x.val()+"'})");
            var url = x.attr('url');
            var data = $.ajax({
                'url':url,
                async: false,
                'data':d
            }).responseText;
            if(data != '1')return {result:false,message:data};
        }
        try{
            if(x.attr('datatype') && x.attr('datatype') != "")
            {
                var method = eval(x.attr('datatype'));
                return method(x);
            }
            else
                return ginkgo(x);
        }
        catch(e){
            return ginkgo(x);
        }
    }
    return checkvars(x);
}
function formsubmit(){
    var _this = this;
    var status = false;
    var query;
    var target = $(_this).attr('data-target');
    if(!target || target == '')target = null;
    query = $(":input",_this).serialize()+'&userhash='+Math.random();
    $(":input",_this).not('.ckeditor').each(function(){
        var _this = this;
        var data = xvars($(this));
        if(!data.result && !status){
            $(_this).parents(".control-group").addClass("error");
            pep.mask.show('tips',data);
            status = true;
        }
    });
    if(status)return false;
    if(!$(_this).attr('action') || $(_this).attr('action') == '')return false;
    if($(_this).attr('disablebutton') == 'on'){
        $("input:submit",_this).attr('disabled','true');
        $("input:submit",_this).attr('value','正在提交……');
    };
    submitAjax({"url":$(_this).attr('action'),'title':$(_this).attr("data-title"),"query":query,"target":target,'page':$(_this).attr('data-page'),'action-before':$(_this).attr('action-before')});
    return false;
}

var countdown = function(userOptions)
{
    var h,m,s,t,options;
    var init = function()
    {
        options = userOptions;
        options.counttime = options.time*60 - options.lefttime;
        s = options.counttime%60;
        m = parseInt(options.counttime%3600/60);
        h = parseInt(options.counttime/3600);
    }

    var setval = function()
    {
        if(s >= 10)
            userOptions.sbox.html(s);
        else
            userOptions.sbox.html('0'+s.toString());
        if(m >= 10)
            userOptions.mbox.html(m);
        else
            userOptions.mbox.html('0'+ m);
        if(h >= 10)
            userOptions.hbox.html(h);
        else
            userOptions.hbox.html('0'+ h);
    }

    var step = function()
    {
        if(s > 0)
        {
            s--;
        }
        else
        {
            if(m > 0)
            {
                m--;
                s = 60;
                s--;
            }
            else
            {
                if(h > 0)
                {
                    h--;
                    m = 60;
                    m--;
                    s = 60;
                    s--;
                }
                else
                {
                    clearInterval(pep.clock.countdown);
                    userOptions.finish();
                    return ;
                }
            }
        }
        setval();
    }

    init();
    pep.clock.countdown = setInterval(step, 1000);
    return function(lefttime){
        options.lefttime = lefttime;
        init();
    }
};

function inituploader()
{
    var _this = this;
    var ismul = false;
    var petemplate = 'pe-template';
    var petype = 'thumb';
    var ftype = ['jpeg', 'jpg', 'gif', 'png'];
    if($(_this).attr('attr-list') == 'true')ismul = true;
    if($(_this).attr('attr-template') &&  $(_this).attr('attr-template') != '')petemplate = $(_this).attr('attr-template');
    if($(_this).attr('attr-ftype') &&  $(_this).attr('attr-ftype') != '')ftype = $(_this).attr('attr-ftype').split(',');
    switch($(_this).attr('attr-type'))
    {
        case 'thumb':
        case 'list':
        case 'files':
            petype = $(_this).attr('attr-type');
            break;

        default:
            petype = 'thumb';
    }
    return new qq.FineUploader({
        'element': _this,
        'multiple': ismul,
        'template': petemplate,
        'request': {
            'endpoint': 'index.php?document-api-uploader-fineuploader&imgwidth=420',
            'method': 'POST'
        },
        'thumbnails': {
            'placeholders': {
                'waitingPath': 'app/core/styles/images/loader.gif',
                'notAvailablePath': 'app/core/styles/images/user_default.png'
            }
        },
        'validation': {
            'allowedExtensions': ftype
        },
        'deleteFile': {
            enabled: false
        },
        'callbacks': {
            'onSubmit':  function(id,  fileName)  {
                if(petype != 'list')
                {
                    $(_this).find('.qq-upload-list-selector').html('');
                    $(_this).find('.qq-upload-list-selector').eq(1).remove();
                }
            },
            'onProgress': function(id, fileName, loaded, total) {
                if (loaded < total)
                {
                    progress = Math.round(loaded / total * 100) + '%';
                    $(_this).find('.process').html(progress);
                }
                else
                    $(_this).find('.process').html('');
            },
            'onComplete': function(id,fileName,responseJSON) {
                $(_this).find('[qq-file-id='+id+'] .qq-edit-filename-selector').val(responseJSON.thumb);
                if(petype == 'list')
                {
                    var tpl = $(_this).find('.listimg').first().html().replace(/\*name\*/g,$(_this).attr('attr-name'));
                    tpl = tpl.replace(/\*value\*/g,responseJSON.thumb);
                    $('#'+$(_this).attr('attr-box')).append(tpl);
                }
            }
        }
    });
}

function combox(){
    var _this = this;
    if($(_this).attr("target") && ($(_this).attr("target") != "")){
        var url = $(_this).attr("refUrl").replace(/{value}/,$(_this).val());
        if($(_this).attr('valuefrom') && ($(_this).attr('valuefrom') != "")){
            var t = $(_this).attr('valuefrom').split("|");
            for(i=0;i<t.length;i++)
            {
                url = url.replace(eval("/{"+t[i]+"}/gi"),$('#'+t[i]).val());
            }
        }
        submitAjax({'url':url,'target':$(_this).attr("target")});
        if($(_this).attr("callback") && $(_this).attr("callback") != "")
        {
            eval($(_this).attr("callback"))($(_this));
        }
    }
}
function cleardata()
{
    $('body').removeData();
}
$(function(){
    $("body").delegate("a.ajax","click",pep.goPage);
    $("body").delegate("form","submit",formsubmit);
    $('body').delegate('.pages-footer .navibutton','click',function(){
        var _this = $(this);
        var index = _this.index();
        pep.initpage(_this.parents('.pages:first'),index,true);
    });
    $("body").delegate(".pages","animationstart webkitAnimationStart oAnimationStart",function(){
        pep.allowpre = false;
    });
    $("body").delegate(".pages","animationend webkitAnimationEnd oAnimationEnd",function(){
        $(".pages").removeClass('pt-page-moveFromRight').removeClass('pt-page-moveToRight').removeClass('pt-page-moveFromLeft').removeClass('pt-page-moveToLeft');
        if($(".pages").length > 1){
            $('.pages:first').remove();
        }
        pep.allowpre = true;
    });
    pep.initpage($('.pages:first'));
    window.addEventListener("hashchange", function(e) {
        return false;
    }, false);
    window.addEventListener("popstate", function(e) {
        if(pep.isTrueVar($('.pages:first').find('.pages-content:first').attr('data-callback')))
        {
            $('body').removeData();
            eval($('.pages:first').find('.pages-content:first').attr('data-callback'))();
        }
        else if($('.pages:first').find('.pages-content:first').attr('data-refresh') == 'yes')
        {
            $('body').removeData();
            pep.goPrePage();
        }
        else
        pep.goPrePage();
    }, false);
})