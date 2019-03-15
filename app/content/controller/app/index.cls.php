<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace content\controller\app;

use exam\model\training;
use lesson\model\lessons;

class index
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $catindex = array(1,2,3);
        $contents = array();
        foreach($catindex as $catid)
        {
            $catstring = \core\model\category::getChildCategoryString('content',$catid);
            $args = array(
                array("AND","find_in_set(contentcatid,:contentcatid)","contentcatid",$catstring)
            );
            $contents[$catid] = \content\model\content::getContentList($args,1,5);
        }
        $trainings = training::getTrainingsByArgs();
        $lessons = lessons::getLessonList(array(),1,5);
        \tpl::getInstance()->assign('lessons',$lessons);
        \tpl::getInstance()->assign('contents',$contents);
        \tpl::getInstance()->assign('trainings',$trainings);
        \tpl::getInstance()->display('index');
    }
}