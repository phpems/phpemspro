<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/25
 * Time: 21:24
 */

namespace exam\controller\master;

class users
{
    //public function

    public function index()
    {
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
            \tpl::getInstance()->display('users');
        }
    }
}