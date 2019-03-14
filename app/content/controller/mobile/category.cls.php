<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace content\controller\mobile;

use content\model\content;
use exam\model\exams;
use exam\model\points;
use exam\model\training;

class category
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page > 1?$page:1;
        $catid = \route::get('catid');
        $cat = \core\model\category::getCategoryById($catid);
        $catchildren = \core\model\category::getChildCategory('content',$catid);
        if(!count($catchildren))
        {
            $catstring = \core\model\category::getChildCategoryString('content',$catid);
            $args = array(
                array("AND","find_in_set(contentcatid,:contentcatid)","contentcatid",$catstring)
            );
            $contents = content::getContentList($args,$page);
            \tpl::getInstance()->assign('contents',$contents);
        }
        \tpl::getInstance()->assign('catchildren',$catchildren);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('cat',$cat);
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