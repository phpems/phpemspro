<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace content\controller\app;

use exam\model\exams;
use exam\model\points;
use exam\model\training;

class content
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $contentid = \route::get('contentid');
        $content = \content\model\content::getContentById($contentid);
        $cat = \core\model\category::getCategoryById($content['contentcatid']);
        $catchildren = \core\model\category::getChildCategory('content',$cat['catid']);
        $catbrother = \core\model\category::getChildCategory('content',$cat['catparent']);
        \tpl::getInstance()->assign('cat',$cat);
        \tpl::getInstance()->assign('catbrother',$catbrother);
        \tpl::getInstance()->assign('catchildren',$catchildren);
        \tpl::getInstance()->assign('content',$content);
        \tpl::getInstance()->display('content_default');
    }
}