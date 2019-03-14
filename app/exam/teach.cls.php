<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:36
 */

namespace exam;

use user\model\users;

class teach
{
    static $_user;

    static private function _start()
    {
        self::$_user = \session::getInstance()->getSessionUser();
        if(!self::$_user['sessionuserid'])
        {
            $message = array(
                'statusCode' => 300,
                "message" => "请您先登陆",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?user-app-login"
            );
            \route::urlJump($message);
        }
        $user = users::getUserById(self::$_user['sessionuserid']);
        if($user['usergroupcode'] != 'teacher')
        {
            $message = array(
                'statusCode' => 300,
                "message" => "只有教师用户才能登陆本后台",
                "callbackType" => "forward",
                "forwardUrl" => "index.php"
            );
            \route::urlJump($message);
        }
        \tpl::getInstance()->assign('_user',$user);
    }

    static private function _end()
    {
        //
    }

    static public function display()
    {
        self::_start();
        $methodname = \route::getUrl('app').'\\'.'controller\\'.\route::getUrl('module').'\\'.\route::getUrl('method');
        $selection = \route::getUrl('selection');
        $method = new $methodname();
        if(method_exists($method,$selection))
        {
            $method->$selection();
        }
        else
        {
            $method->index();
        }
        self::_end();
    }
}