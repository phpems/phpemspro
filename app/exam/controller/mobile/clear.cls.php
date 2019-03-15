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

class clear
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
    }

    public function notes()
    {
        foreach($this->basic['basicpoints'] as $ps)
        {
            foreach($ps as $p)
            {
                \pedis::getInstance()->delHashData('notenumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p);
            }
        }
        favor::delNotesByUsername($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $message = array(
            'statusCode' => 200,
            'message' => '清理成功！'
        );
        \route::urlJump($message);
    }

    public function favors()
    {

        foreach($this->basic['basicpoints'] as $ps)
        {
            foreach($ps as $p)
            {
                \pedis::getInstance()->delHashData('favornumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p);
            }
        }
        favor::delFavorsByUsername($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $message = array(
            'statusCode' => 200,
            'message' => '清理成功！'
        );
        \route::urlJump($message);
    }

    public function answers()
    {
        \pedis::getInstance()->delHashData('records',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb']);
        favor::delRecord($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $message = array(
            'statusCode' => 200,
            'message' => '清理成功！'
        );
        \route::urlJump($message);
    }

    public function process()
    {
        foreach($this->basic['basicpoints'] as $ps)
        {
            foreach($ps as $p)
            {
                \pedis::getInstance()->delHashData('lastquestion',\exam\mobile::$_user['sessionusername'].'-'.\exam\mobile::$_user['currentbasic']);
            }
        }
        $message = array(
            'statusCode' => 200,
            'message' => '清理成功！'
        );
        \route::urlJump($message);
    }

    public function index()
    {
        \tpl::getInstance()->display('clear');
    }
}