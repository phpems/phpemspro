<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace core\controller\master;

use core\model\apps;
use user\model\users;

class login
{
    public function __construct()
    {
        //
    }

    public function logout()
    {
        \session::getInstance()->clearSessionUser();
        $message = array(
            'statusCode' => 200,
            "message" => "退出成功",
            "callbackType" => "forward",
            "forwardUrl" => "index.php?core-master"
        );
        \route::urlJump($message);
    }

    public function index()
    {
        if(\route::get('userlogin'))
        {
            $args = \route::get('args');
            $user = \user\model\users::getUserByUsername($args['username']);
            if($user)
            {
                if($user['userpassword'] == md5($args['userpassword']))
                {
                    $sessionuser = array(
                        'sessionuserid' => $user['userid'],
                        'sessionusername' => $user['username'],
                        'sessionpassword' => $user['userpassword'],
                        'sessiongroupcode' => $user['usergroupcode']
                    );
                    \session::getInstance()->setSessionUser($sessionuser);
                    $message = array(
                        'statusCode' => 200,
                        "message" => "登陆成功",
                        "callbackType" => "forward",
                        "forwardUrl" => "index.php?core-master",
                        'callback' => 'cleardata'
                    );
                    \route::urlJump($message);
                }
            }
            $message = array(
                'statusCode' => 300,
                "message" => "用户名或密码错误"
            );
            \route::urlJump($message);
        }
        else
        {
            \tpl::getInstance()->display('login');
        }
    }
}