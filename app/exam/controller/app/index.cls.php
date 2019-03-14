<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\controller\app;

use exam\model\exams;
use exam\model\points;
use exam\model\training;

class index
{
    public function __construct()
    {
        //
    }

    public function intro()
    {
        $trid = \route::get('trid');
        $training = training::getTrainingById($trid);
        \tpl::getInstance()->assign('training',$training);
        \tpl::getInstance()->display('training_intro');
    }

    public function training()
    {
        $trid = \route::get('trid');
        $training = training::getTrainingById($trid);
        $subjects = points::getSubjects(array(array("AND","subjecttrid = :trid","trid",$training['trid'])));
        foreach($subjects as $subject)
        {
            $basics[$subject['subjectid']] = exams::getBasicsList($subject['subjectdb'],array(array("AND","basicsubject = :basicsubject","basicsubject",$subject['subjectid'])),1,5);
        }
        \tpl::getInstance()->assign('basics',$basics);
        \tpl::getInstance()->assign('subjects',$subjects);
        \tpl::getInstance()->assign('training',$training);
        \tpl::getInstance()->display('training');
    }

    public function index()
    {
        $trainings = training::getTrainingsByArgs();
        $subjects = array();
        foreach($trainings as $training)
        {
            $subjects[$training['trid']] = points::getSubjects(array(array("AND","subjecttrid = :trid","trid",$training['trid'])));
        }
        \tpl::getInstance()->assign('subjects',$subjects);
        \tpl::getInstance()->assign('trainings',$trainings);
        \tpl::getInstance()->display('index');
    }
}