<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2019/1/4
 * Time: 21:09
 */

namespace exam\controller\app;


use core\model\apps;
use exam\model\exams;
use exam\model\favor;
use exam\model\points;
use exam\model\question;

class stats
{
    public function __construct()
    {
        if(!\exam\app::$_user['currentsubject'])
        {
            $message = array(
                'statusCode' => 300,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?content-app"
            );
            \route::urlJump($message);
        }
        $this->subject = points::getSubjectById(\exam\app::$_user['currentsubject']);
        $this->basic = exams::getBasicById($this->subject['subjectdb'],\exam\app::$_user['currentbasic']);
        $this->status = exams::getIsMember($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],\exam\app::$_user['currentbasic']);
        if(strtotime($this->status['obendtime']) >= TIME)
        {
            $this->status['status'] = true;
        }
        \tpl::getInstance()->assign('subject',$this->subject);
        \tpl::getInstance()->assign('basic',$this->basic);
        \tpl::getInstance()->assign('status',$this->status);
        if($this->basic['basicexam']['model'] == 2)
        {
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-app-exam"
            );
            \route::urlJump($message);
        }
    }

    public function index()
    {
        $args = array();
        $args[] = array("AND","ehbasicid = :basicid","basicid",$this->basic['basicid']);
        $args[] = array("AND","ehusername = :username","username",\exam\app::$_user['sessionusername']);
        $histories = favor::getExamHistoryList($this->subject['subjectdb'],$args,1,15,'ehscore,ehstarttime');
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $record = favor::getRecordSession($this->subject['subjectdb'],\exam\app::$_user['sessionusername']);
        $wrong = array();
        $right = array();
        $favor = array();
        $note = array();
        foreach($this->basic['basicpoints'] as $key => $point)
        {
            $rt = 0;
            $wg = 0;
            foreach($point as $p)
            {
                $numbers[$p] = question::getQuestionNumberByPointid($this->subject['subjectdb'],$p);
                $favor[$key] += intval(\pedis::getInstance()->getHashData('favornumber',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p));
                $note[$key] += intval(\pedis::getInstance()->getHashData('notenumber',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p));
                $rt += $record['recordnumber'][$p]['right'];
                $wg += $record['recordnumber'][$p]['wrong'];
            }
            $wrong[$key] = intval($wg);
            $right[$key] = intval($rt);
        }
        unset($record);
        $favor = array_sum($favor);
        $note = array_sum($note);
        $histories['data'] = array_reverse($histories['data']);
        \tpl::getInstance()->assign('allnumber',array('right' => array_sum($right),'wrong' => array_sum($wrong),'all' => array_sum($numbers)));
        \tpl::getInstance()->assign('wrong',$wrong);
        \tpl::getInstance()->assign('favor',$favor);
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('histories',$histories);
        \tpl::getInstance()->display('stats');
    }
}