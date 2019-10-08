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
use exam\model\points;
use exam\model\question;

class favor
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

    public function save()
    {
        $pointid = \route::get('pointid');
        $question = \route::get('question');
        $lastquestion = \route::get('lastquestion');
        \pedis::getInstance()->setHashData('process',\exam\app::$_user['sessionusername'].'_'.$this->subject['subjectdb'].'_'.$pointid,$lastquestion);
        \pedis::getInstance()->setHashData('lastquestion',\exam\app::$_user['sessionusername'].'_'.\exam\app::$_user['currentsubject'],json_encode(array($pointid => $lastquestion)));
        \exam\model\favor::saveRecord($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$pointid,$question);
        $message = array(
            'statusCode' => 200,
            'message' => '保存成功！',
            'callback' => 'pep.goPrePage'
        );
        \route::urlJump($message);
    }

    public function notepaper()
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
        $point = points::getPointById($pointid);
        $section = points::getSectionById($point['pointsection']);
        $parent = array();
        $questions = \exam\model\favor::getNoteQuestionsByPointid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$pointid,'questionid');
        $ids = array();
        foreach($questions as $key => $p)
        {
            $ids[] = $p['questionid'];
        }
        $allnumber = count($questions);
        if($number < 1)$number = 1;
        if($number > $allnumber)$number = $allnumber;
        $questionid = $questions[$number - 1]['questionid'];
        $question = question::getQuestionById($this->subject['subjectdb'],$questionid);
        if($question['questionparent'])
        {
            if(!$parent[$question['questionparent']])
            {
                $parent[$question['questionparent']] = question::getQuestionRowsById($this->subject['subjectdb'],$question['questionparent'],false);
            }
        }
        $questypes = question::getQuestypesByArgs();
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        $favors = \exam\model\favor::getFavorByQuestionIds($this->subject['subjectdb'],$ids,\exam\app::$_user['sessionusername']);
        $note = \exam\model\favor::getNoteByUserAndQuestionid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$questionid);
        \tpl::getInstance()->assign('section',$section);
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('favors',$favors);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('number',$number);
        \tpl::getInstance()->assign('allnumber',$allnumber);
        \tpl::getInstance()->assign('section',$section);
        \tpl::getInstance()->assign('question',$question);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('note_paper');
    }

    public function wrongpaper()
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
        $point = points::getPointById($pointid);
        $section = points::getSectionById($point['pointsection']);
        $record = \exam\model\favor::getRecordSession($this->subject['subjectdb'],\exam\app::$_user['sessionusername']);
        $wrong = $record['recordwrong'][$pointid];
        unset($record);
        $ids = array();
        $useranswer = array();
        foreach($wrong as $key => $p)
        {
            $ids[] = $key;
            $useranswer[$key] = $p;
        }
        $ids = implode(',',$ids);
        $parent = array();
        $args = array(array("AND","questionid in ({$ids})"),array("AND","questionstatus = 1"));
        $questions = question::getQuestionsByArgs($this->subject['subjectdb'],$args,"questionparent asc,questionorder asc,questionid desc",'questionid');
        $allnumber = count($questions);
        if($number < 1)$number = 1;
        if($number > $allnumber)$number = $allnumber;
        $questionid = $questions[$number - 1]['questionid'];
        $question = question::getQuestionById($this->subject['subjectdb'],$questionid);
        if($question['questionparent'])
        {
            if(!$parent[$question['questionparent']])
            {
                $parent[$question['questionparent']] = question::getQuestionRowsById($this->subject['subjectdb'],$question['questionparent'],false);
            }
        }
        $questypes = question::getQuestypesByArgs();
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        $favors = \exam\model\favor::getFavorByQuestionIds($this->subject['subjectdb'],$ids,\exam\app::$_user['sessionusername']);
        $note = \exam\model\favor::getNoteByUserAndQuestionid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$questionid);
        \tpl::getInstance()->assign('section',$section);
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('useranswer',$useranswer);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('number',$number);
        \tpl::getInstance()->assign('allnumber',$allnumber);
        \tpl::getInstance()->assign('favors',$favors);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('question',$question);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('wrong_paper');
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
                    "forwardUrl" => "index.php?exam-app-basic-open"
                );
                \route::urlJump($message);
            }
        }
        $number = \route::get('number');
        $allnumber = intval(\pedis::getInstance()->getHashData('favornumber',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$pointid));
        if($number < 1)$number = 1;
        if($number > $allnumber)$number = $allnumber;
        $point = points::getPointById($pointid);
        $section = points::getSectionById($point['pointsection']);
        $parent = array();
        $questions = \exam\model\favor::getFavorQuestionsByPointid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$pointid,'questionid');
        $ids = array();
        foreach($questions as $p)
        {
            $ids[] = $p['questionid'];
        }
        $question = question::getQuestionById($this->subject['subjectdb'],$ids[$number - 1]);
        if($question['questionparent'])
        {
            if(!$parent[$question['questionparent']])
            {
                $parent[$question['questionparent']] = question::getQuestionRowsById($this->subject['subjectdb'],$question['questionparent'],false);
            }
        }
        $record = \exam\model\favor::getRecordSession($this->subject['subjectdb'],\exam\app::$_user['sessionusername']);
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
        $questypes = question::getQuestypesByArgs();
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        $note = \exam\model\favor::getNoteByUserAndQuestionid($this->subject['subjectdb'],\exam\app::$_user['sessionusername'],$questionid);
        \tpl::getInstance()->assign('section',$section);
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('useranswer',$useranswer);
        \tpl::getInstance()->assign('number',$number);
        \tpl::getInstance()->assign('allnumber',$allnumber);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('question',$question);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('favor_paper');
    }

    public function index()
    {
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $record = \exam\model\favor::getRecordSession($this->subject['subjectdb'],\exam\app::$_user['sessionusername']);
        $wrong = array();
        $right = array();
        $favor = array();
        $note = array();
        $numbers = array();
        foreach($points as $key => $point)
        {
            foreach($point as $p)
            {
                $numbers[$p['pointid']] = question::getQuestionNumberByPointid($this->subject['subjectdb'],$p['pointid']);
                $favor[$p['pointid']] = intval(\pedis::getInstance()->getHashData('favornumber',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p['pointid']));
                $note[$p['pointid']] = intval(\pedis::getInstance()->getHashData('notenumber',\exam\app::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p['pointid']));
                $wrong[$p['pointid']] = intval($record['recordnumber'][$p['pointid']]['wrong']);
                $right[$p['pointid']] = intval($record['recordnumber'][$p['pointid']]['right']);
            }
        }
        unset($record);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('wrong',$wrong);
        \tpl::getInstance()->assign('favor',$favor);
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->display('favor');
    }
}