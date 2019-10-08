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

class exam
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
        if(!$this->basic['basicexam']['model'])
        {
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-app-basic"
            );
            \route::urlJump($message);
        }
    }

    public function detail()
    {
        $ehid = \route::get('ehid');
        $history = favor::getExamHistoryById($this->subject['subjectdb'],$ehid);
        if(!$history['ehstatus'] || $this->basic['basicexam']['notviewscore'])
        {
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-app-exam-history"
            );
            \route::urlJump($message);
        }
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $tmp = array();
        foreach($points as $pts)
        {
            foreach($pts as $p)
            {
                $tmp[$p['pointid']] = $p;
            }
        }
        $points = $tmp;
        $questypes = question::getQuestypesByArgs();
        $number = array();
        $right = array();
        $score = array();
        $allnumber = 0;
        $allright = 0;
        $qids = array();
        $qrids = array();
        $stats = array();
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
                    foreach($p['questionpoints'] as $point)
                    {
                        $stats[$point]['pointid'] = $point;
                        $stats[$point]['point'] = $points[$point]['pointname'];
                        $stats[$point]['number'] = intval($stats[$point]['number']) + 1;
                        $stats[$point]['score'] = $stats[$point]['score'] + $history['ehsetting']['papersetting']['questype'][$key]['score'];
                        if($history['ehscorelist'][$p['questionid']] > 0)
                        {
                            $stats[$point]['right'] = intval($stats[$point]['right']) + 1;
                            $stats[$point]['rightscore'] = $stats[$point]['rightscore'] + $history['ehscorelist'][$p['questionid']];
                        }
                    }
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
                        foreach($p['qrpoints'] as $point)
                        {
                            $stats[$point]['pointid'] = $point;
                            $stats[$point]['point'] = $points[$point]['pointname'];
                            $stats[$point]['number'] = intval($stats[$point]['number']) + 1;
                            $stats[$point]['score'] = $stats[$point]['score'] + $history['ehsetting']['papersetting']['questype'][$key]['score'];
                            if($history['ehscorelist'][$p['questionid']] > 0)
                            {
                                $stats[$point]['right'] = intval($stats[$point]['right']) + 1;
                                $stats[$point]['rightscore'] = $stats[$point]['rightscore'] + $history['ehscorelist'][$p['questionid']];
                            }
                        }
                        if($number[$key] == $history['ehsetting']['papersetting']['questype'][$key]['number'])break;
                    }
                }
            }
        }

        \tpl::getInstance()->assign('stats',$stats);
        \tpl::getInstance()->assign('allright',$allright);
        \tpl::getInstance()->assign('allnumber',$allnumber);
        \tpl::getInstance()->assign('right',$right);
        \tpl::getInstance()->assign('score',$score);
        \tpl::getInstance()->assign('number',$number);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('history',$history);
        \tpl::getInstance()->display('exam_detail');
    }

    public function history()
    {
        $page = \route::get('page');
        $page = $page?$page:1;
        $args = array();
        $args[] = array("AND","ehbasicid = :basicid","basicid",$this->basic['basicid']);
        $args[] = array("AND","ehusername = :username","username",\exam\app::$_user['sessionusername']);
        $args[] = array("AND","ehtype = 2");
        $histories = favor::getExamHistoryList($this->subject['subjectdb'],$args,$page);
        \tpl::getInstance()->assign('histories',$histories);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('exam_history');
    }

    public function lefttime()
    {
        $paper = json_decode(\pedis::getInstance()->getHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId()),true);
        $lefttime = 0;
        if($paper['starttime'])
        {
            $lefttime = TIME - $paper['starttime'];
        }
        echo $lefttime;
        exit;
    }

    public function saveanswer()
    {
        $paper = json_decode(\pedis::getInstance()->getHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId()),true);
        $question = \route::get('question');
        $paper['useranswer'] = $question;
        \pedis::getInstance()->setHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId(),json_encode($paper));
        $message = array(
            'statusCode' => 200
        );
        exit(json_encode($message));
    }

    public function save()
    {
        if($this->basic['basicexam']['examnumber'])
        {
            $args = array();
            $args[] = array("AND","ehusername = :ehusername","ehusername",\exam\app::$_user['sessionusername']);
            $args[] = array("AND","ehbasicid = :ehbasicid","ehbasicid",$this->basic['basicid']);
            $args[] = array("AND","ehtype = 2");
            $number = favor::getExamHistoryNumber($this->subject['subjectdb'],$args);
            if($number >= $this->basic['basicexam']['examnumber'])
            {
                $message = array(
                    'statusCode' => 300,
                    'message' => '您已经完成考试了！'
                );
                \route::urlJump($message);
            }
        }
        $question = \route::get('question');
        $paper = json_decode(\pedis::getInstance()->getHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId()),true);
        $rs = question::submitpaper($this->subject['subjectdb'],$question,$paper,\exam\app::$_user['sessionusername']);
        \pedis::getInstance()->delHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId());
        if($rs['needteacher'])
        {
            $message = array(
                'statusCode' => 200,
                'message' => '保存成功！',
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-app-exam-decide&ehid=".$rs['ehid']
            );
        }
        else
        {
            $message = array(
                'statusCode' => 200,
                'message' => '保存成功！',
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-app-exam-detail&ehid=".$rs['ehid']
            );
        }
        \route::urlJump($message);
    }

    public function paper()
    {
        $paper = json_decode(\pedis::getInstance()->getHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId()),true);
        if(!$paper)
        {
            header("location:index.php?exam-app-exam");
            exit;
        }
        $questypes = question::getQuestypesByArgs();
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        if($paper['useranswer'])
        {
            $useranswer = array();
            foreach($paper['useranswer'] as $key => $p)
            {
                if(is_array($p))
                {
                    foreach($p as $nkey => $cp)
                    {
                        $useranswer["question[{$key}]"][$nkey]['value'] = $cp;
                    }
                }
                else
                {
                    $useranswer["question[{$key}]"]['value'] = $p;
                }
            }
            \tpl::getInstance()->assign('useranswer',json_encode($useranswer));
        }
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('basic',$this->basic);
        \tpl::getInstance()->assign('paper',$paper);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('exam_paper');
    }

    public function selectquestions()
    {
        if(!$this->status['status'])
        {
            $message = array(
                'statusCode' => 200,
                'message' => '你需要购买后才可以使用本功能',
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-app-basic-open"
            );
            \route::urlJump($message);
        }
        if($this->basic['basicexam']['examnumber'])
        {
            $args = array();
            $args[] = array("AND","ehusername = :ehusername","ehusername",\exam\app::$_user['sessionusername']);
            $args[] = array("AND","ehbasicid = :ehbasicid","ehbasicid",$this->basic['basicid']);
            $args[] = array("AND","ehtype = 2");
            $number = favor::getExamHistoryNumber($this->subject['subjectdb'],$args);
            if($number >= $this->basic['basicexam']['examnumber'])
            {
                $message = array(
                    'statusCode' => 300,
                    'message' => '您已经完成考试了！'
                );
                \route::urlJump($message);
            }
        }
        \pedis::getInstance()->delHashData('examsession_'.\exam\app::$_user['sessionusername']);
        $paperid = \route::get('paperid');
        if($this->basic['basicexam']['selectrule'])
        {
            $ids = explode(',',trim($this->basic['basicexam']['self'],', '));
            $p = rand(0,count($ids)-1);
            $paperid = $ids[$p];
        }
        $paper = exams::getPaperById($this->subject['subjectdb'],$paperid);
        if($paper['papertype'] == 1)
        {
            $args = array();
            $points = array();
            foreach($this->basic['basicpoints'] as $section)
            {
                foreach($section as $point)
                {
                    $points[] = $point;
                }
            }
            $questionids = question::selectquestions($this->subject['subjectdb'],$paper,$points);
            $questions = array();
            $questionrows = array();
            $number = array();
            foreach($questionids['ids'] as $key => $p)
            {
                if(count($p))
                {
                    $ids = implode(',', $p);
                    $questions[$key] = question::getQuestionsByArgs($this->subject['subjectdb'], array(array("AND", "questionid in ({$ids})"), array("AND", "questionstatus = 1")));
                    $number[$key] = count($questions[$key]);
                }
            }
            foreach($questionids['qrids'] as $key => $p)
            {
                foreach($p as $qrid)
                {
                    $qr = question::getQuestionRowsById($this->subject['subjectdb'],$qrid);
                    $number[$key] += $qr['qrnumber'];
                    if($number[$key] >= $paper['papersetting']['questype'][$key]['number'])
                    {
                        $t = $number[$key] - $paper['papersetting']['questype'][$key]['number'];
                        while($t > 0)
                        {
                            array_pop($qr['data']);
                            $t--;
                        }
                        $questionrows[$key][$qrid] = $qr;
                        break;
                    }
                    $questionrows[$key][$qrid] = $qr;
                }
            }
            $args['question'] = array('questions'=>$questions,'questionrows'=>$questionrows);
            unset($paper['paperquestions']);
            $args['setting'] = $paper;
            $args['starttime'] = TIME;
            $args['name'] = $paper['papername'];
            $args['score'] = 0;
            $args['useranswer'] = '';
            $args['scorelist'] = '';
            $args['sign'] = '';
            $args['time'] = $paper['papersetting']['papertime'];
            $args['status'] = 0;
            $args['type'] = 2;
            $args['key'] = $paper['paperid'];
            $args['basic'] = $this->basic['basicid'];
            $args['username'] = \exam\app::$_user['sessionusername'];
            $args['token'] = md5(serialize($args));
            \pedis::getInstance()->setHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId(),json_encode($args));
        }
        elseif($paper['papertype'] == 2)
        {
            $args = array();
            $questions = array();
            $questionrows = array();
            foreach($paper['paperquestions'] as $key => $p)
            {
                $qids = '';
                $qrids = '';
                if($p['questions'])$qids = implode(',',explode(',',trim($p['questions']," ,")));
                if($qids)
                {
                    $questions[$key] = question::getQuestionsByArgs($this->subject['subjectdb'],array(array("AND","questionid in ({$qids})"),array("AND","questionstatus = 1")));;
                }
                if($p['questionrows'])$qrids = implode(',',explode(',',trim($p['questionrows']," ,")));
                if($qrids)
                {
                    $qrids = explode(",",$qrids);
                    foreach($qrids as $t)
                    {
                        $qr = question::getQuestionRowsById($this->subject['subjectdb'],$t);
                        if($qr)
                        {
                            $questionrows[$key][$t] = $qr;
                        }
                    }
                }
            }
            $args['question'] = array('questions'=>$questions,'questionrows'=>$questionrows);
            unset($paper['paperquestions']);
            $args['setting'] = $paper;
            $args['starttime'] = TIME;
            $args['name'] = $paper['papername'];
            $args['score'] = 0;
            $args['useranswer'] = '';
            $args['scorelist'] = '';
            $args['sign'] = '';
            $args['time'] = $paper['papersetting']['papertime'];
            $args['status'] = 0;
            $args['type'] = 2;
            $args['key'] = $paper['paperid'];
            $args['basic'] = $this->basic['basicid'];
            $args['username'] = \exam\app::$_user['sessionusername'];
            $args['token'] = md5(serialize($args));
            \pedis::getInstance()->setHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId(),json_encode($args));
        }
        elseif($paper['papertype'] == 3)
        {
            $args = array();
            $args['question'] = $paper['paperquestions'];
            unset($paper['paperquestions']);
            $args['setting'] = $paper;
            $args['starttime'] = TIME;
            $args['name'] = $paper['papername'];
            $args['score'] = 0;
            $args['useranswer'] = '';
            $args['scorelist'] = '';
            $args['sign'] = '';
            $args['time'] = $paper['papersetting']['papertime'];
            $args['status'] = 0;
            $args['type'] = 2;
            $args['key'] = $paper['paperid'];
            $args['basic'] = $this->basic['basicid'];
            $args['username'] = \exam\app::$_user['sessionusername'];
            $args['token'] = md5(serialize($args));
            \pedis::getInstance()->setHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId(),json_encode($args));
        }
        else
        {
            $message = array(
                'statusCode' => 300,
                'message' => '配置错误，请联系管理员！',
                "callbackType" => 'forward',
                "forwardUrl" => "index.php?exam-app-exam-paper",
                'time' => 1
            );
            \route::urlJump($message);
        }
        $message = array(
            'statusCode' => 200,
            "callbackType" => 'forward',
            "forwardUrl" => "index.php?exam-app-exam-paper",
            'time' => 1
        );
        \route::urlJump($message);
    }

    public function index()
    {
        $paperids = $this->basic['basicexam']['self'];
        if($paperids)
        {
            $args = array();
            $args[] = array("AND","find_in_set(paperid,:paperid)","paperid",$paperids);
            $papers = exams::getPapersByArgs($this->subject['subjectdb'],$args);
            \tpl::getInstance()->assign('papers',$papers);
        }
        \tpl::getInstance()->display('exam');
    }
}