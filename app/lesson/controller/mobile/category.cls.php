<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace lesson\controller\mobile;

use exam\model\exams;
use exam\model\points;
use exam\model\training;
use lesson\model\lessons;

class category
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page >1?$page:1;
        $catid = \route::get('catid');
        $cat = \core\model\category::getCategoryById($catid);
        $catchildren = \core\model\category::getChildCategory('lesson',$catid);
        if(!count($catchildren))
        {
            $catstring = \core\model\category::getChildCategoryString('lesson',$catid);
            $args = array(
                array("AND","find_in_set(lessoncatid,:lessoncatid)","lessoncatid",$catstring)
            );
            $lessons = lessons::getLessonList($args,$page);
            \tpl::getInstance()->assign('lessons',$lessons);
        }
        \tpl::getInstance()->assign('catchildren',$catchildren);
        \tpl::getInstance()->assign('cat',$cat);
        \tpl::getInstance()->assign('page',$page);
        if(count($catchildren))
        {
            \tpl::getInstance()->display('category');
        }
        else
        {
            if(!$cat['cattpl'])
            {
                $cat['cattpl'] = 'category_default';
            }
            \tpl::getInstance()->display($cat['cattpl']);
        }
    }
}