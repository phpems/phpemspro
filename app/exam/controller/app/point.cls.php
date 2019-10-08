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

class point
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
                'erusername' => \exam\app::$_user['sessionusername'],
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
        $questionid = \route::get('questionid');
        $question = \route::get('question');
        favor::saveSingleRecord($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$pointid,$questionid,$question[$questionid]);
        $message = array(
            'statusCode' => 200
        );
        \route::urlJump($message);
    }

    public function note()
    {
        if(\route::get('savenote'))
        {
            $args = \route::get('args');
            $args['noteusername'] = \exam\app::$_user['sessionusername'];
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
                    $number = favor::getNoteNumberByPointid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$p);
                    \pedis::getInstance()->setHashData('notenumber',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p,$number);
                }
            }
            else
            {
                foreach($question['questionpoints'] as $p)
                {
                    $number = favor::getNoteNumberByPointid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$p);
                    \pedis::getInstance()->setHashData('notenumber',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p,$number);
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
            $args = array();
            $args[] = array("and","noteusername != :noteusername","noteusername",\exam\app::$_user['sessionusername']);
            $args[] = array("and","notequestionid = :notequestionid","notequestionid",$questionid);
            $args[] = array("and","notestatus = 1");
            \pg::setUrlTarget(' class="ajax" target="noteboxlist" ');
            $notes = favor::getNoteList($this->subject['subjectdb'],$args,$page);
            \tpl::getInstance()->assign('page',$page);
            \tpl::getInstance()->assign('questionid',$questionid);
            \tpl::getInstance()->assign('notes',$notes);
            \tpl::getInstance()->display('point_note');
        }
    }

    public function index()
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
                    "forwardUrl" => "index.php?exam-app-basic-open"
                );
                \route::urlJump($message);
            }
        }
        $number = \route::get('number');
        $questype = \route::get('questype');
        if($number < 1)
        {
            if($questype)
            {
                $number = 1;
            }
            else
            {
                $lastquestion = intval(\pedis::getInstance()->getHashData('process',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$pointid));
                $number = intval($lastquestion) + 1;
            }
        }
        $point = points::getPointById($pointid);
        $ids = question::getQuestionidsByPointid($this->subject['subjectdb'],$point['pointid']);
        $ids = implode(',',$ids);
        $parent = array();
        $args = array(array("AND","questionid in ({$ids})"),array("AND","questionstatus = 1"));
        if($questype)
        {
            $args[] = array("AND","questiontype = :questiontype","questiontype",$questype);
        }
        $questions = question::getQuestionsByArgs($this->subject['subjectdb'],$args,"questionparent asc,questionorder asc,questionid desc",'questionid');
        $allnumber = count($questions);
        if($number > $allnumber)$number = $allnumber;
        if(!$questype)
        {
            \pedis::getInstance()->setHashData('process',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$pointid,$number-1);
            \pedis::getInstance()->setHashData('lastquestion',\exam\app::$_user['sessionusername'].'-'.\exam\app::$_user['currentbasic'],json_encode(array($pointid => $lastquestion)));
        }
        if(\route::get('questionid'))
        {
            $i = array_search(array('questionid' => \route::get('questionid')),$questions);
            if($i !== false)
            {
                $number = $i+1;
            }
        }
        $questionid = $questions[$number - 1]['questionid'];
        $question = question::getQuestionById($this->subject['subjectdb'],$questionid);
        $parent = question::getQuestionRowsById($this->subject['subjectdb'],$question['questionparent'],false);
        $questypes = question::getQuestypesByArgs();
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        $favors = favor::getFavorByQuestionIds($this->subject['subjectdb'],$questionid,\exam\app::$_user['sessionusername']);
        $record = favor::getRecordSession($this->subject['subjectdb'],\exam\app::$_user['sessionusername']);
        $right = $record['recordright'][$pointid];
        $wrong = $record['recordwrong'][$pointid];
        unset($record);
        $useranswer = array();
        foreach($right as $key => $p)
        {
            $useranswer[$key]['answer'] = $p;
            $useranswer[$key]['status'] = 'right';
        }
        foreach($wrong as $key => $p)
        {
            $useranswer[$key]['answer'] = $p;
            $useranswer[$key]['status'] = 'wrong';
        }
        $note = favor::getNoteByUserAndQuestionid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$questionid);
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('useranswer',$useranswer);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('number',$number);
        \tpl::getInstance()->assign('allnumber',$allnumber);
        \tpl::getInstance()->assign('favors',$favors);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('question',$question);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('questype',$questype);
        \tpl::getInstance()->display('point');
    }
}