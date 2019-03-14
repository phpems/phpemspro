<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace content\controller\mobile;

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
        \tpl::getInstance()->assign('cat',$cat);
        \tpl::getInstance()->assign('content',$content);
        \tpl::getInstance()->display('content_default');
    }
}