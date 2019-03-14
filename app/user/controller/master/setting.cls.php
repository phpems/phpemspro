<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/25
 * Time: 21:24
 */

namespace user\controller\master;

class setting
{
    public function index()
    {
        $app = \core\model\apps::getAppByCode('user');
        if(\route::get('setting'))
        {
            $args = \route::get('args');
            \core\model\apps::modifyAppByCode('user',array('appsetting' => $args));
            $message = array(
                'statusCode' => 200,
                "message" => "删除成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->assign('setting',$app['appsetting']);
            \tpl::getInstance()->display('setting');
        }
    }
}