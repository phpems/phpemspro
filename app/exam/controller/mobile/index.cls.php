<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\controller\mobile;

use exam\model\exams;
use exam\model\points;
use exam\model\training;
use finance\model\orders;

class index
{
    public function __construct()
    {
        //
    }

    public function active()
    {
        if((TIME - $_SESSION['onlytime']) < 1)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "请勿多次提交"
            );
            \route::urlJump($message);
        }
        $_SESSION['onlytime'] = TIME;
        $activeid = \route::get('activeid');
        $args = array();
        $args[] = array("AND","activeid = :activeid","activeid",$activeid);
        $args[] = array("AND","activeusername = :activeusername","activeusername",\exam\mobile::$_user['sessionusername']);
        $args[] = array("AND","activestatus = 0");
        $active = orders::getActiveByArgs($args);
        if($active['activeid'])
        {
            $subject = points::getSubjectById($active['activesubjectid']);
            if($subject)
            {
                $basic = exams::getBasicById($subject['subjectdb'],$active['activebasicid']);
                if($basic)
                {
                    $r = \exam\model\exams::getIsMember($subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$basic['basicid']);
                    if(!$r)
                    {
                        $args = array(
                            'obbasicid' => $basic['basicid'],
                            'obusername' => \exam\mobile::$_user['sessionusername'],
                            'obtime' => TIME,
                            'obendtime' => TIME + 24*3600*$active['activetime']
                        );
                        \exam\model\exams::addBasicMember($subject['subjectdb'],$args);
                    }
                    elseif(strtotime($r['obendtime']) < TIME)
                    {
                        $args = array(
                            'obendtime' => TIME + 24*3600*$active['activetime']
                        );
                        \exam\model\exams::modifyBasicMember($subject['subjectdb'],$r['obid'],$args);
                    }
                    elseif(strtotime($r['obendtime']) >= TIME)
                    {
                        $args = array(
                            'obendtime' => strtotime($r['obendtime']) + 24*3600*$active['activetime']
                        );
                        \exam\model\exams::modifyBasicMember($subject['subjectdb'],$r['obid'],$args);
                    }
                    orders::modifyActive($active['activeid'],array('activestatus' => 1));
                    \session::getInstance()->setSessionUser(array('currentsubject' => $subject['subjectid'],'currentbasic' => $basic['basicid']));
                    $message = array(
                        'statusCode' => 200,
                        "message" => "激活成功",
                        "callbackType" => "forward",
                        "forwardUrl" => "index.php?exam-mobile-basic"
                    );
                    exit(json_encode($message));
                }
            }
        }
        $message = array(
            'statusCode' => 300,
            "message" => "激活失败，请确认是否已经激活过，更多问题请询问管理员"
        );
        exit(json_encode($message));
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
                $basics[$subject['subjectid']] = exams::getOpenBasicsByUserName($subject['subjectdb'],$subject['subjectid'],\exam\mobile::$_user['sessionusername']);
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
        \tpl::getInstance()->display('index');
    }
}