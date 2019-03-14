<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace lesson\controller\mobile;

use finance\model\orders;
use lesson\model\lessons;

class index
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $lessons = lessons::getOpenLessons(\lesson\mobile::$_user['sessionusername']);
        \tpl::getInstance()->assign('lessons',$lessons);
        \tpl::getInstance()->display('index');
    }
}