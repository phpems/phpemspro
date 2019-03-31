<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace content\controller\mobile;

use content\model\content;
use core\model\category;
use exam\model\exams;
use exam\model\points;
use exam\model\training;
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
        $catindex = array(1,2,3);
        $contents = array();
        foreach($catindex as $catid)
        {
            $catstring = category::getChildCategoryString('content',$catid);
            $args = array(
                array("AND","find_in_set(contentcatid,:contentcatid)","contentcatid",$catstring)
            );
            $contents[$catid] = content::getContentList($args,1,5);
        }
        $trainings = training::getTrainingsByArgs();
        $subjects = array();
        $basics = array();
        foreach($trainings as $training)
        {
            $subjects[$training['trid']] = points::getSubjects(array(array("AND","subjecttrid = :trid","trid",$training['trid'])));
            foreach($subjects[$training['trid']] as $subject)
            {
                $basics[$subject['subjectid']] = exams::getBasicsList($subject['subjectdb'],array(array("AND","basicsubject = :basicsubject","basicsubject",$subject['subjectid'])),1,10);
                $openbasics[$subject['subjectid']] = exams::getOpenBasicsByUserName($subject['subjectdb'],$subject['subjectid'],\content\mobile::$_user['sessionusername']);
            }
        }

        $lessoncats = \core\model\category::getCategoriesByArgs(array(array("AND","catparent = 0"),array("AND","catapp = 'lesson'")));

        $lessons = lessons::getLessonList(array(),1,5);

        \tpl::getInstance()->assign('lessoncats',$lessoncats);
        \tpl::getInstance()->assign('lessons',$lessons);
        \tpl::getInstance()->assign('contents',$contents);
        \tpl::getInstance()->assign('subjects',$subjects);
        \tpl::getInstance()->assign('trainings',$trainings);
        \tpl::getInstance()->assign('openbasics',$openbasics);
        \tpl::getInstance()->assign('basics',$basics);
        \tpl::getInstance()->display('index');
    }
}