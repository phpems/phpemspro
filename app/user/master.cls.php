<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:36
 */

namespace user;
use user\model\users;
class master
{
    static $_user;

    static private function _start()
    {
        self::$_user = \session::getInstance()->getSessionUser();
        if (!self::$_user['sessionuserid']) {
            $message = array(
                'statusCode' => 300,
                "message" => "请您先登陆",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?core-master-login"
            );
            \route::urlJump($message);
        }
        $user = users::getUserById(self::$_user['sessionuserid']);
        if ($user['usergroupcode'] != 'webmaster') {
            $message = array(
                'statusCode' => 300,
                "message" => "您无权登陆后台",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?core-master-login"
            );
            \route::urlJump($message);
        }
        \tpl::getInstance()->assign('_user', $user);
        $apps = \core\model\apps::getAppList();
        \tpl::getInstance()->assign('apps', $apps);
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