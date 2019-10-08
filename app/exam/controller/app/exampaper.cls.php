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

class exampaper
{
    public function __construct()
    {
        if(!\exam\app::$_user['currentsubject'])
        {
            $message = array(
                'statusCode' => 300,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?content-mobile"
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
                "forwardUrl" => "index.php?exam-app-history-decide&ehid=".$rs['ehid']
            );
        }
        else
        {
            $message = array(
                'statusCode' => 200,
                'message' => '保存成功！',
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-app-history-detail&ehid=".$rs['ehid']
            );
        }
        \route::urlJump($message);
    }

    public function paper()
    {
        $paper = json_decode(\pedis::getInstance()->getHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId()),true);
        if(!$paper)
        {
            header("location:index.php?exam-app-exampaper");
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
        \tpl::getInstance()->display('exampaper_paper');
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
        \pedis::getInstance()->delHashData('examsession_'.\exam\app::$_user['sessionusername']);
        $paperid = \route::get('paperid');
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
            $args['type'] = 1;
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
            $args['type'] = 1;
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
            $args['type'] = 1;
            $args['key'] = $paper['paperid'];
            $args['basic'] = $this->basic['basicid'];
            $args['username'] = \exam\app::$_user['sessionusername'];
            $args['token'] = md5(serialize($args));
            \pedis::getInstance()->setHashData('examsession_'.\exam\app::$_user['sessionusername'],\session::getInstance()->getSessionId(),json_encode($args));
        }
        $message = array(
            'statusCode' => 200,
            "callbackType" => 'forward',
            "forwardUrl" => "index.php?exam-app-exampaper-paper",
            'time' => 1
        );
        \route::urlJump($message);
    }

    public function index()
    {
        $paperids = $this->basic['basicexam']['auto'];
        if($paperids)
        {
            $args = array();
            $args[] = array("AND","find_in_set(paperid,:paperid)","paperid",$paperids);
            $papers = exams::getPapersByArgs($this->subject['subjectdb'],$args);
            \tpl::getInstance()->assign('papers',$papers);
        }
        \tpl::getInstance()->display('exampaper');
    }
}