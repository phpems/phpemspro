<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/public/admin/css/font.css">
        <link rel="stylesheet" href="/public/admin/css/xadmin.css">
    </head>
    <body>
    <div class="x-body">
        <blockquote class="layui-elem-quote">欢迎管理员：
            <span class="x-red">{x2;$_user['username']}</span>！当前时间:{x2;date:TIME,'Y-m-d H:i:s'}  <a onclick="parent.x_admin_add_to_tab('在tab打开','https://www.163.com',true)" style="color: red" href="javascript:;">在tab打开</a>
        </blockquote>
        <fieldset class="layui-elem-field">
            <legend>数据统计</legend>
            <div class="layui-field-box">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body">
                            <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                                <div carousel-item="">
                                    <ul class="layui-row layui-col-space10 layui-this">
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>文章数</h3>
                                                <p>
                                                    <cite>66</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>会员数</h3>
                                                <p>
                                                    <cite>12</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>回复数</h3>
                                                <p>
                                                    <cite>99</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>商品数</h3>
                                                <p>
                                                    <cite>67</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>文章数</h3>
                                                <p>
                                                    <cite>67</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs2">
                                            <a href="javascript:;" class="x-admin-backlog-body">
                                                <h3>文章数</h3>
                                                <p>
                                                    <cite>6766</cite></p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="layui-elem-field">
            <legend>系统通知</legend>
            <div class="layui-field-box">
                <table class="layui-table" lay-skin="line">
                    <tbody>
                        <tr>
                            <td >
                                <a class="x-a" href="http://www.phpems.net/index.php?content-app-content&contentid=72" target="_blank">新版PHPEMSPRO上线了</a>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <a class="x-a" href="#" target="_blank">交流qq群:(438228249，2554408，479709205，474900152)</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <fieldset class="layui-elem-field">
            <legend>系统信息</legend>
            <div class="layui-field-box">
                <table class="layui-table">
                    <tbody>
                        <tr>
                            <th>phpems版本</th>
                            <td>PHPEMSPRO1.0测试版</td></tr>
                        <tr>
                            <th>服务器地址</th>
                            <td>{x2;$args['servername']}</td></tr>
                        <tr>
                            <th>服务器ip</th>
                            <td>{x2;$args['server']}</td></tr>
                        <tr>
                            <th>操作系统</th>
                            <td>{x2;$args['uname']}</td></tr>
                        <tr>
                            <th>服务器端信息</th>
                            <td>{x2;$args['software']}</td></tr>
                        <tr>
                            <th>运行环境</th>
                            <td>{x2;$args['sapi']}</td></tr>
                        <tr>
                            <th>PHP版本</th>
                            <td>{x2;$args['version']}</td></tr>
                        <tr>
                            <th>上传附件限制</th>
                            <td>{x2;$args['up_size']}</td></tr>
                        <tr>
                            <th>执行时间限制</th>
                            <td>{x2;$args['up_time']}</td></tr>
                        <tr>
                            <th>占用最大内存</th>
                            <td>{x2;$args['memory']}</td></tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <fieldset class="layui-elem-field">
            <legend>开发团队</legend>
            <div class="layui-field-box">
                <table class="layui-table">
                    <tbody>
                        <tr>
                            <th>版权所有</th>
                            <td>phpems.net
                                <a href="http://www.phpems.net/" class='x-a' target="_blank">访问官网</a></td>
                        </tr>
                        <tr>
                            <th>开发者</th>
                            <td>火眼(2241223009@qq.com)</td></tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <blockquote class="layui-elem-quote layui-quote-nm">QQ交流群：438228249，2554408，479709205，474900152。</blockquote>
    </div>
    </body>
</html>