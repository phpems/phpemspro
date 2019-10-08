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
use exam\model\points;
use exam\model\question;

class favor
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

    public function save()
    {
        $pointid = \route::get('pointid');
        $question = \route::get('question');
        $lastquestion = \route::get('lastquestion');
        \pedis::getInstance()->setHashData('process',\exam\mobile::$_user['sessionusername'].'_'.$this->subject['subjectdb'].'_'.$pointid,$lastquestion);
        \pedis::getInstance()->setHashData('lastquestion',\exam\mobile::$_user['sessionusername'].'_'.\exam\mobile::$_user['currentsubject'],json_encode(array($pointid => $lastquestion)));
        \exam\model\favor::saveRecord($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$pointid,$question);
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
        $point = points::getPointById($pointid);
        $parent = array();
        $questions = \exam\model\favor::getNoteQuestionsByPointid($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$pointid);
        $ids = array();
        foreach($questions as $key => $question)
        {
            $ids[] = $question['questionid'];
            if($question['questionparent'])
            {
                if(!$parent[$question['questionparent']])
                {
                    $parent[$question['questionparent']] = question::getQuestionRowsById($this->subject['subjectdb'],$question['questionparent'],false);
                }
            }
        }
        $ids = implode(',',$ids);
        $questypes = question::getQuestypesByArgs();
        $app = apps::getAppByCode('exam');
        $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
        $favors = \exam\model\favor::getFavorByQuestionIds($this->subject['subjectdb'],$ids,\exam\mobile::$_user['sessionusername']);
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('favors',$favors);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('favor_notepaper');
    }

    public function wrongpaper()
    {
        $pointid = \route::get('pointid');
        $point = points::getPointById($pointid);
        $record = \exam\model\favor::getRecordSession($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
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
        $favors = \exam\model\favor::getFavorByQuestionIds($this->subject['subjectdb'],$ids,\exam\mobile::$_user['sessionusername']);
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('useranswer',$useranswer);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('favors',$favors);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('favor_wrongpaper');
    }

    public function paper()
    {
        $pointid = \route::get('pointid');
        $point = points::getPointById($pointid);
        $parent = array();
        $questions = \exam\model\favor::getFavorQuestionsByPointid($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$pointid);
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
        \tpl::getInstance()->assign('setting',$app['appsetting']);
        \tpl::getInstance()->assign('point',$point);
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('favor_paper');
    }

    public function note()
    {
        $sectionid = \route::get('sectionid');
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $note = array();
        foreach ($points[$sectionid] as $point)
        {
            $note[$point['pointid']] += intval(\pedis::getInstance()->getHashData('notenumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$point['pointid']));
        }
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('sectionid',$sectionid);
        \tpl::getInstance()->assign('points',$points[$sectionid]);
        \tpl::getInstance()->display('favor_note');
    }

    public function wrong()
    {
        $sectionid = \route::get('sectionid');
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $record = \exam\model\favor::getRecordSession($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $wrong = array();
        foreach ($points[$sectionid] as $point)
        {
            $wrong[$point['pointid']] = intval($record['recordnumber'][$point['pointid']]['wrong']);
        }
        unset($record);
        \tpl::getInstance()->assign('wrong',$wrong);
        \tpl::getInstance()->assign('sectionid',$sectionid);
        \tpl::getInstance()->assign('points',$points[$sectionid]);
        \tpl::getInstance()->display('favor_wrong');
    }

    public function index()
    {
        $sectionid = \route::get('sectionid');
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $favor = array();
        foreach ($points[$sectionid] as $point)
        {
            $favor[$point['pointid']] += intval(\pedis::getInstance()->getHashData('favornumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$point['pointid']));
        }
        \tpl::getInstance()->assign('favor',$favor);
        \tpl::getInstance()->assign('sectionid',$sectionid);
        \tpl::getInstance()->assign('points',$points[$sectionid]);
        \tpl::getInstance()->display('favor');
    }
}