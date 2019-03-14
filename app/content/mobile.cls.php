<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:36
 */

namespace content;

use user\model\users;

class mobile
{
    static $_user;

    static private function _start()
    {
        self::$_user = \session::getInstance()->getSessionUser();
        if(self::$_user['sessionuserid'])
        {
            \tpl::getInstance()->assign('_user',users::getUserById(self::$_user['sessionuserid']));
        }
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