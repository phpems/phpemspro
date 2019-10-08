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

class point
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
        if($this->basic['basicexam']['model'] == 2)
        {
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-mobile-exam"
            );
            \route::urlJump($message);
        }
    }

    public function intro()
    {
        $pointid = \route::get('pointid');
        $point = points::getPointById($pointid);
        $section = points::getSectionById($point['pointsection']);
        \tpl::getInstance()->assign('section',$section);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->display('point_intro');
    }

    public function video()
    {
        $pointid = \route::get('pointid');
        $point = points::getPointById($pointid);
        $section = points::getSectionById($point['pointsection']);
        \tpl::getInstance()->assign('section',$section);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->display('point_video');
    }

    public function clear()
    {
        $pointid = \route::get('pointid');
        $record = favor::getRecordSession($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        unset($record['recordright'][$pointid]);
        unset($record['recordwrong'][$pointid]);
        unset($record['recordnumber'][$pointid]);
        \pedis::getInstance()->setHashData('records',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'],json_encode($record));
        $message = array(
            'statusCode' => 200,
            'message' => '清理成功！',
            "callbackType" => "forward",
            "forwardUrl" => "index.php?exam-mobile-point-paper&pointid=".$pointid
        );
        \route::urlJump($message);
    }

    public function errors()
    {
        $questionid = \route::get('questionid');
        if(!$questionid)
        {
            $message = array(
                'statusCode' => 300,
                'message' => '错误的题号！'
            );
            \route::urlJump($message);
        }
        if(\route::get('adderrors'))
        {
            $error = implode(',',\route::get('error'));
            $errorcontent = \route::get('errorcontent');
            $args = array(
                'erusername' => \exam\mobile::$_user['sessionusername'],
                'ertime' => TIME,
                'erintro' => "{$error}:{$errorcontent}",
                'ersubjectid' => $this->subject['subjectid'],
                'erquestionid' => $questionid
            );
            question::addErros($args);
            $message = array(
                'statusCode' => 200,
                'message' => '反馈成功！',
                "callbackType" => "forward",
                "forwardUrl" => "back"
            );
            \route::urlJump($message);
        }
        else
        {
            \tpl::getInstance()->assign('questionid',$questionid);
            \tpl::getInstance()->display('errors');
        }
    }

    public function save()
    {
        $pointid = \route::get('pointid');
        $question = \route::get('question');
        $lastquestion = \route::get('lastquestion');
        \pedis::getInstance()->setHashData('process',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$pointid,$lastquestion);
        \pedis::getInstance()->setHashData('lastquestion',\exam\mobile::$_user['sessionusername'].'-'.\exam\mobile::$_user['currentbasic'],json_encode(array($pointid => $lastquestion)));
        favor::saveRecord($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$pointid,$question);
        $message = array(
            'statusCode' => 200,
            'message' => '保存成功！',
            'callback' => 'pep.goPrePage'
        );
        \route::urlJump($message);
    }

    public function note()
    {
        if(\route::get('savenote'))
        {
            $args = \route::get('args');
            $args['noteusername'] = \exam\mobile::$_user['sessionusername'];
            $args['notesubject'] = $this->subject['subjectid'];
            $args['notetime'] = TIME;
            $args['notestatus'] = 0;
            favor::saveNote($this->subject['subjectdb'],$args);
            $question = question::getQuestionById($this->subject['subjectdb'],$args['notequestionid']);
            if($question['questionparent'])
            {
                $qr = question::getQuestionRowsById($this->subject['subjectdb'],$question['questionparent'],false);
                foreach($qr['qrpoints'] as $p)
                {
                    $number = favor::getNoteNumberByPointid($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$p);
                    \pedis::getInstance()->setHashData('notenumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p,$number);
                }
            }
            else
            {
                foreach($question['questionpoints'] as $p)
                {
                    $number = favor::getNoteNumberByPointid($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$p);
                    \pedis::getInstance()->setHashData('notenumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p,$number);
                }
            }
            $message = array(
                'statusCode' => 200,
                'message' => '保存成功！'
            );
            \route::urlJump($message);
        }
        else
        {
            $page = \route::get('page');
            $page = $page >=1?$page:1;
            $questionid = \route::get('questionid');
            $note = favor::getNoteByUserAndQuestionid($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$questionid);
            $args = array();
            $args[] = array("and","noteusername != :noteusername","noteusername",\exam\mobile::$_user['sessionusername']);
            $args[] = array("and","notequestionid = :notequestionid","notequestionid",$questionid);
            $args[] = array("and","notestatus = 1");
            $notes = favor::getNoteList($this->subject['subjectdb'],$args,$page);
            \tpl::getInstance()->assign('page',$page);
            \tpl::getInstance()->assign('questionid',$questionid);
            \tpl::getInstance()->assign('note',$note);
            \tpl::getInstance()->assign('notes',$notes);
            \tpl::getInstance()->display('note');
        }
    }

    public function paper()
    {
        $pointid = \route::get('pointid');
        if($pointid != current(current($this->basic['basicpoints'])))
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
        }
        $point = points::getPointById($pointid);
        $record = favor::getRecordSession($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $right = $record['recordright'][$pointid];
        $wrong = $record['recordwrong'][$pointid];
        unset($record);
        $useranswer = array();
        foreach($right as $key => $p)
        {
            $useranswer[$key] = $p;
        }
        foreach($wrong as $key => $p)
        {
            $useranswer[$key] = $p;
        }
        $ids = question::getQuestionidsByPointid($this->subject['subjectdb'],$point['pointid']);
        $ids = implode(',',$ids);
        $parent = array();
        $questions = question::getQuestionsByArgs($this->subject['subjectdb'],array(array("AND","questionid in ({$ids})"),array("AND","questionstatus = 1")));
        foreach($questions as $key => $question)
        {
            if($question['questionparent'])
            {
                if(!$parent[$question['questionparent']])
                {
                    $parent[$question['questionparent']] = question::getQuestionRowsById($this->subject['subjectdb'],$question['questionparent'],false);
                }
            }
        }
        $questypes = question::getQuestypesByArgs();
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        $favors = favor::getFavorByQuestionIds($this->subject['subjectdb'],$ids,\exam\mobile::$_user['sessionusername']);
        $lastquestion = intval(\pedis::getInstance()->getHashData('process',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$pointid));
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('lastquestion',$lastquestion);
        \tpl::getInstance()->assign('useranswer',$useranswer);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('favors',$favors);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('point_paper');
    }

    public function points()
    {
        $sectionid = \route::get('sectionid');
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $record = favor::getRecordSession($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $numbers = array();
        $right = array();
        $rate = array();
        foreach ($points[$sectionid] as $point)
        {
            if($this->basic['basicpoints'][$sectionid][$point['pointid']])
            {
                $numbers[$point['pointid']] = question::getQuestionNumberByPointid($this->subject['subjectdb'], $point['pointid']);
                $right[$point['pointid']] = intval($record['recordnumber'][$point['pointid']]['right'] + $record['recordnumber'][$point['pointid']]['wrong']);
                $rate[$point['pointid']] = intval(100 * $record['recordnumber'][$point['pointid']]['right'] / ($record['recordnumber'][$point['pointid']]['right'] + $record['recordnumber'][$point['pointid']]['wrong']));
            }
        }
        unset($record);
        \tpl::getInstance()->assign('right',$right);
        \tpl::getInstance()->assign('rate',$rate);
        \tpl::getInstance()->assign('numbers',$numbers);
        \tpl::getInstance()->assign('sectionid',$sectionid);
        \tpl::getInstance()->assign('points',$points[$sectionid]);
        \tpl::getInstance()->display('point_list');
    }

    public function index()
    {
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $numbers = array();
        $record = favor::getRecordSession($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $lastquestion = json_decode(\pedis::getInstance()->getHashData('lastquestion',\exam\mobile::$_user['sessionusername'].'-'.\exam\mobile::$_user['currentbasic']),true);
        $pointid = key($lastquestion);
        $index = $lastquestion[$pointid];
        $right = array();
        $rate = array();
        foreach($points as $key => $point)
        {
            $number = 0;
            $rt = 0;
            $wg = 0;
            foreach($point as $p)
            {
                if($this->basic['basicpoints'][$key][$p['pointid']])
                {
                    $number += question::getQuestionNumberByPointid($this->subject['subjectdb'],$p['pointid']);
                    $rt += $record['recordnumber'][$p['pointid']]['right'];
                    $wg += $record['recordnumber'][$p['pointid']]['wrong'];
                    if($p['pointid'] == $pointid)
                    {
                        $thispoint = $p;
                    }
                }
            }
            $numbers[$key] = $number;
            $right[$key] = intval($rt + $wg);
            $rate[$key] = intval(100*$rt/($rt + $wg));
        }
        unset($record);
        \tpl::getInstance()->assign('right',$right);
        \tpl::getInstance()->assign('rate',$rate);
        \tpl::getInstance()->assign('numbers',$numbers);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->assign('point',$thispoint);
        \tpl::getInstance()->assign('index',$index+1);
        \tpl::getInstance()->display('point');
    }
}