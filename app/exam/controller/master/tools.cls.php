<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/25
 * Time: 21:24
 */

namespace exam\controller\master;

use exam\model\favor;
use exam\model\points;
use exam\model\question;

class tools
{

    public function index()
    {

        \tpl::getInstance()->display('tools');
    }

    public function errors()
    {
        $page = \route::get('page');
        $page = $page > 1?$page:1;
        $subjects = points::getSubjects();
        $args = array();
        $errors = question::getErrorsList($args,$page);
        \tpl::getInstance()->assign('subjects',$subjects);
        \tpl::getInstance()->assign('errors',$errors);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('tools_errors');
    }

    public function signdone()
    {
        $erid = \route::get('erid');
        $args = array(
            'erstatus' => 1,
            'erteacher' => \exam\master::$_user['sessionusername']
        );
        question::modifyErrors($erid,$args);
        $message = array(
            'statusCode' => 200,
            "message" => "标记成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function del()
    {
        $erid = \route::get('erid');
        question::delErrors($erid);
        $message = array(
            'statusCode' => 200,
            "message" => "删除成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function gorepair()
    {
        $erid = \route::get('erid');
        $error = question::getErrorById($erid);
        $subject = points::getSubjectById($error['ersubjectid']);
        $question = question::getQuestionById($subject['subjectdb'],$error['erquestionid']);
        if($question['questionparent'])
        {
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-questionrows&subjectid={$error['ersubjectid']}&search[qrid]={$question['questionparent']}"
            );
            exit(json_encode($message));
        }
        else
        {
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-questions&subjectid={$error['ersubjectid']}&search[questionid]={$error['erquestionid']}"
            );
            exit(json_encode($message));
        }
    }

    public function clearuser()
    {
        \pedis::getInstance()->delHashData('users');
        \pedis::getInstance()->delHashData('session');
        $message = array(
            'statusCode' => 200,
            "message" => "清理成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function clearquestionrows()
    {
        \pedis::getInstance()->delHashData('questionrows');
        \pedis::getInstance()->delHashData('subjectquestionrows');
        $message = array(
            'statusCode' => 200,
            "message" => "清理成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function clearquestions()
    {
        \pedis::getInstance()->delHashData('questions');
        \pedis::getInstance()->delHashData('subjectquestions');
        $message = array(
            'statusCode' => 200,
            "message" => "清理成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function clearnumber()
    {
        \pedis::getInstance()->delHashData('number');
        $message = array(
            'statusCode' => 200,
            "message" => "清理成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function clearsession()
    {
        \pedis::getInstance()->delHashData('examsession');
        $message = array(
            'statusCode' => 200,
            "message" => "清理成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }
}