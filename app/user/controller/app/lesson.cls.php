<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace user\controller\app;

use lesson\model\lessons;

class lesson
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $lessons = lessons::getOpenLessons(\user\app::$_user['sessionusername']);
        \tpl::getInstance()->assign('lessons',$lessons);
        \tpl::getInstance()->display('lesson');
    }
}