<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2019/1/4
 * Time: 21:09
 */

namespace exam\controller\mobile;


use core\model\apps;
use exam\model\exams;
use exam\model\favor;
use exam\model\points;
use exam\model\question;

class history
{
    public function __construct()
    {
        if(!\exam\mobile::$_user['currentsubject'])
        {
            $message = array(
                'statusCode' => 300,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?content-mobile"
            );
            \route::urlJump($message);
        }
        $this->subject = points::getSubjectById(\exam\mobile::$_user['currentsubject']);
        $this->basic = exams::getBasicById($this->subject['subjectdb'],\exam\mobile::$_user['currentbasic']);
        $this->status = exams::getIsMember($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],\exam\mobile::$_user['currentbasic']);
        if(strtotime($this->status['obendtime']) >= TIME)
        {
            $this->status['status'] = true;
        }
        \tpl::getInstance()->assign('subject',$this->subject);
        \tpl::getInstance()->assign('basic',$this->basic);
        \tpl::getInstance()->assign('status',$this->status);
    }

    public function view()
    {
        if(!$this->status['status'])
        {
            $message = array(
                'statusCode' => 200,
                'message' => '你需要购买后才可以使用本功能',
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-mobile-basic-open"
            );
            \route::urlJump($message);
        }
        $ehid = \route::get('ehid');
        $questypes = question::getQuestypesByArgs();
        $history = favor::getExamHistoryById($this->subject['subjectdb'],$ehid);
        foreach($history['ehuseranswer'] as $key => $p)
        {
            if(is_array($p))
            $history['ehuseranswer'][$key] = implode('',$p);
        }
        $ids = array();
        foreach($history['ehquestion']['questions'] as $key => $ps)
        {
            foreach($ps as $q)
            {
                $ids[] = $q['questionid'];
            }
        }
        foreach($history['ehquestion']['questionrows'] as $key => $prs)
        {
            foreach($prs as $pr)
            {
                foreach($pr['data'] as $q)
                {
                    $ids[] = $q['questionid'];
                }
            }
        }
        $ids = implode(',',$ids);
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        $favors = favor::getFavorByQuestionIds($this->subject['subjectdb'],$ids,\exam\mobile::$_user['sessionusername']);
        \tpl::getInstance()->assign('favors',$favors);
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('history',$history);
        \tpl::getInstance()->display('history_view');
    }

    public function decide()
    {
        $ehid = \route::get('ehid');
        $history = favor::getExamHistoryById($this->subject['subjectdb'],$ehid);
        if(\route::get('makedecide'))
        {
            $score = \route::get('score');
            foreach($score as $key => $p)
            {
                $history['ehscorelist'][$key] = floatval($p);
            }
            $score = array_sum($history['ehscorelist']);
            favor::modifyExamHistory($this->subject['subjectdb'],$ehid,array('ehscorelist' => $history['ehscorelist'],'ehscore' => $score,'ehstatus' => 1));
            $message = array(
                'statusCode' => 200,
                'message' => '评分完成',
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-mobile-history-detail&ehid=".$ehid
            );
            \route::urlJump($message);
        }
        else
        {
            if($history['ehsetting']['paperdecider'])
            {
                $message = array(
                    'statusCode' => 200,
                    'message' => '本试卷需要教师评分后才能展示',
                    "callbackType" => "forward",
                    "forwardUrl" => "index.php?exam-mobile-history"
                );
                \route::urlJump($message);
            }
            if($history['ehstatus'])
            {
                $message = array(
                    'statusCode' => 200,
                    "callbackType" => "forward",
                    "forwardUrl" => "back"
                );
                \route::urlJump($message);
            }
            $questypes = question::getQuestypesByArgs();
            $needdecide = array();
            foreach($history['ehquestion']['questions'] as $key => $p)
            {
                if($questypes[$key]['questsort'])
                {
                    $needdecide[$key] = 1;
                }
            }
            foreach($history['ehquestion']['questionrows'] as $key => $p)
            {
                if($questypes[$key]['questsort'])
                {
                    $needdecide[$key] = 1;
                }
                else
                {
                    foreach($p as $q)
                    {
                        foreach($q['data'] as $qd)
                        {
                            if($questypes[$qd['questype']]['questsort'])
                            {
                                $needdecide[$key] = 1;
                            }
                        }
                    }
                }
            }
            $app = apps::getAppByCode('exam');
            $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
            \tpl::getInstance()->assign('setting',$app['appsetting']);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->assign('needdecide',$needdecide);
            \tpl::getInstance()->assign('history',$history);
            \tpl::getInstance()->display('history_decide');
        }
    }

    public function detail()
    {
        $ehid = \route::get('ehid');
        $history = favor::getExamHistoryById($this->subject['subjectdb'],$ehid);
        $questypes = question::getQuestypesByArgs();
        $number = array();
        $right = array();
        $score = array();
        $allnumber = 0;
        $allright = 0;
        $qids = array();
        $qrids = array();
        foreach($questypes as $key => $q)
        {
            $number[$key] = 0;
            $right[$key] = 0;
            $score[$key] = 0;
            if($history['ehquestion']['questions'][$key])
            {
                foreach($history['ehquestion']['questions'][$key] as $p)
                {
                    $number[$key]++;
                    $allnumber++;
                    if($history['ehscorelist'][$p['questionid']] == $history['ehsetting']['papersetting']['questype'][$key]['score'])
                    {
                        $right[$key]++;
                        $allright++;
                    }
                    $score[$key] = $score[$key] + $history['ehscorelist'][$p['questionid']];
                    $qids[] = $p['questionid'];
                }
            }
            if($history['ehquestion']['questionrows'][$key])
            {
                foreach($history['ehquestion']['questionrows'][$key] as $v)
                {
                    $qrids[] = $v['qrid'];
                    foreach($v['data'] as $p)
                    {
                        $qids[] = $p['questionid'];
                        $number[$key]++;
                        $allnumber++;
                        if($history['ehscorelist'][$p['questionid']] == $history['ehsetting']['papersetting']['questype'][$key]['score'])
                        {
                            $right[$key]++;
                            $allright++;
                        }
                        $score[$key] = $score[$key]+$history['ehscorelist'][$p['questionid']];
                        if($number[$key] == $history['ehsetting']['papersetting']['questype'][$key]['number'])break;
                    }
                }
            }
        }
        \tpl::getInstance()->assign('allright',$allright);
        \tpl::getInstance()->assign('allnumber',$allnumber);
        \tpl::getInstance()->assign('right',$right);
        \tpl::getInstance()->assign('score',$score);
        \tpl::getInstance()->assign('number',$number);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('history',$history);
        \tpl::getInstance()->display('history_detail');
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page?$page:1;
        $args = array();
        $args[] = array("AND","ehbasicid = :basicid","basicid",$this->basic['basicid']);
        $args[] = array("AND","ehusername = :username","username",\exam\mobile::$_user['sessionusername']);
        $histories = favor::getExamHistoryList($this->subject['subjectdb'],$args,$page);
        \tpl::getInstance()->assign('histories',$histories);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('history');
    }
}