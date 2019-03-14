<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace lesson\controller\app;

use core\model\category;
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
        $lessons = array();
        $categories = category::getChildCategory('lesson',0);
        foreach($categories as $cat)
        {
            $catstring = category::getChildCategoryString('lesson',$cat['catid']);
            $args = array();
            $args[] = array("AND","find_in_set(lessoncatid,:lessoncatid)","lessoncatid",$catstring);
            $lessons[$cat['catid']] = lessons::getLessonList($args,1,4);
        }
        \tpl::getInstance()->assign('categories',$categories);
        \tpl::getInstance()->assign('lessons',$lessons);
        \tpl::getInstance()->display('index');
    }
}