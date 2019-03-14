<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/12/8
 * Time: 10:47
 */

namespace exam\controller\mobile;

use exam\model\favor;
use exam\model\question;

class ajax
{

    public function setcurrentbasic()
    {
        $basicid = \route::get('basicid');
        $subjectid = \route::get('subjectid');
        \session::getInstance()->setSessionUser(array('currentsubject' => $subjectid,'currentbasic' => $basicid));
        $message = array(
            'statusCode' => 200,
            "callbackType" => "forward",
            "forwardUrl" => "index.php?exam-mobile-basic"
        );
        \route::urlJump($message);
    }

    public function cancelfavor()
    {
        $questionid = \route::get('questionid');
        $username = \exam\mobile::$_user['sessionusername'];
        $subject = \exam\model\points::getSubjectById(\exam\mobile::$_user['currentsubject']);
        \exam\model\favor::delFavor($subject['subjectdb'],$username,$questionid);
        $question = question::getQuestionById($subject['subjectdb'],$questionid);
        if($question['questionparent'])
        {
            $qr = question::getQuestionRowsById($subject['subjectdb'],$question['questionparent'],false);
            foreach($qr['qrpoints'] as $p)
            {
                $number = favor::getFavorNumberByPointid($subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$p);
                \pedis::getInstance()->setHashData('favornumber',\exam\mobile::$_user['sessionusername'].'-'.$subject['subjectdb'].'-'.$p,$number);
            }
        }
        else
        {
            foreach($question['questionpoints'] as $p)
            {
                $number = favor::getFavorNumberByPointid($subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$p);
                \pedis::getInstance()->setHashData('favornumber',\exam\mobile::$_user['sessionusername'].'-'.$subject['subjectdb'].'-'.$p,$number);
            }
        }
        $message = array(
            'statusCode' => 200
        );
        \route::urlJump($message);
    }

    public function favorquestion()
    {
        $questionid = \route::get('questionid');
        $username = \exam\mobile::$_user['sessionusername'];
        $subject = \exam\model\points::getSubjectById(\exam\mobile::$_user['currentsubject']);
        \exam\model\favor::favorQuestion($subject['subjectdb'],$username,$questionid);
        $question = question::getQuestionById($subject['subjectdb'],$questionid);
        if($question['questionparent'])
        {
            $qr = question::getQuestionRowsById($subject['subjectdb'],$question['questionparent'],false);
            foreach($qr['qrpoints'] as $p)
            {
                $number = favor::getFavorNumberByPointid($subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$p);
                \pedis::getInstance()->setHashData('favornumber',\exam\mobile::$_user['sessionusername'].'-'.$subject['subjectdb'].'-'.$p,$number);
            }
        }
        else
        {
            foreach($question['questionpoints'] as $p)
            {
                $number = favor::getFavorNumberByPointid($subject['subjectdb'],\exam\mobile::$_user['sessionusername'],$p);
                \pedis::getInstance()->setHashData('favornumber',\exam\mobile::$_user['sessionusername'].'-'.$subject['subjectdb'].'-'.$p,$number);
            }
        }
        $message = array(
            'statusCode' => 200
        );
        \route::urlJump($message);
    }

    public function index()
    {
        return;
    }
}