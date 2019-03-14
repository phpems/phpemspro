<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:36
 */

namespace exam;

use exam\model\training;
use user\model\users;

class app
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
        \tpl::getInstance()->assign('_user',users::getUserById(self::$_user['sessionuserid']));
        $trainings = training::getTrainingList(1,5);
        \tpl::getInstance()->assign('navtrainings',$trainings['data']);
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