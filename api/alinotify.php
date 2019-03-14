<?php
/*
 * Created on 2013-12-26
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

define('PEP_PATH',dirname(dirname(__FILE__)));
include PEP_PATH.'/public/lib/base.cls.php';

class app
{
    static function display()
    {
        \alipay::getInstance()->notify();
    }
}
app::display();