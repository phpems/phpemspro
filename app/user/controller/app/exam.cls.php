<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace user\controller\app;

use exam\model\exams;
use exam\model\points;
use exam\model\training;

class exam
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $trainings = training::getTrainingsByArgs();
        $usetraining = array();
        $subjects = array();
        $basics = array();
        foreach($trainings as $training)
        {
            $i = 0;
            $subjects[$training['trid']] = points::getSubjects(array(array("AND","subjecttrid = :trid","trid",$training['trid'])));
            foreach($subjects[$training['trid']] as $subject)
            {
                $basics[$subject['subjectid']] = exams::getOpenBasicsByUserName($subject['subjectdb'],$subject['subjectid'],\user\app::$_user['sessionusername']);
                if($basics[$subject['subjectid']])$i++;
            }
            if($i)
            {
                $usetraining[$training['trid']] = 1;
            }
        }
        \tpl::getInstance()->assign('subjects',$subjects);
        \tpl::getInstance()->assign('trainings',$trainings);
        \tpl::getInstance()->assign('basics',$basics);
        \tpl::getInstance()->assign('usetraining',$usetraining);
        \tpl::getInstance()->display('exam');
    }
}