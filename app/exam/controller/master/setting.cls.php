<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/25
 * Time: 21:24
 */

namespace exam\controller\master;

use exam\model\points;
use exam\model\question;
use exam\model\training;

class setting
{
    public function training()
    {
        $page = \route::get('page') > 0?\route::get('page'):1;
        $trainings = training::getTrainingList($page);
        \tpl::getInstance()->assign('trainings',$trainings);
        \tpl::getInstance()->display('setting_training');
    }

    public function addtraining()
    {
        if(\route::get('addtraining'))
        {
            $args = \route::get('args');
            training::addTraining($args);
            $message = array(
                'statusCode' => 200,
                "message" => "添加成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-setting-training"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->display('setting_addtraining');
        }
    }

    public function modifytraining()
    {
        $trainingid = \route::get('trid');
        $training = training::getTrainingById($trainingid);
        if(\route::get('modifytraining'))
        {
            $args = \route::get('args');
            training::modifyTrainingById($trainingid,$args);
            $message = array(
                'statusCode' => 200,
                "message" => "修改成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->assign('training',$training);
            \tpl::getInstance()->display('setting_modifytraining');
        }
    }

    public function deltraining()
    {
        $trainingid = \route::get('trid');
        $args = array(array("AND","subjecttrid = :subjecttrid","subjecttrid",$trainingid));
        if(points::getSubjectsNumber($args))
        {
            $message = array(
                'statusCode' => 300,
                "message" => "删除失败，请先删除此培训下的科目"
            );
            exit(json_encode($message));
        }
        training::delTraining($trainingid);
        $message = array(
            'statusCode' => 200,
            "message" => "删除成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function deltrainings()
    {
        $trainingids = \route::get('delids');
        foreach($trainingids as $trainingid => $p)
        {
            $args = array(array("AND","subjecttrid = :subjecttrid","subjecttrid",$trainingid));
            if(points::getSubjectsNumber($args))
            {
                $training = training::getTrainingById($trainingid);
                $message = array(
                    'statusCode' => 300,
                    "message" => "删除失败，请先删除《{$training['trname']}》下的科目"
                );
                exit(json_encode($message));
            }
        }
        foreach($trainingids as $key => $trainingid)
        {
            training::delTraining($trainingid);
        }
        $message = array(
            'statusCode' => 200,
            "message" => "删除成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function questype()
    {
        $questypes = \exam\model\question::getQuestypesByArgs();
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('setting_questype');
    }

    public function addquestype()
    {
        if(\route::get('addquestype'))
        {
            $args = \route::get('args');
            question::addQuestype($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-setting-questype"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->display('setting_addquestype');
        }
    }

    public function modifyquestype()
    {
        $questid = \route::get('questid');
        $questype = question::getQuestypeById($questid);
        if(\route::get('modifyquestype'))
        {
            $args = \route::get('args');
            if($args['questsort'])
            {
                $args['questchoice'] = 0;
            }
            question::modifyQuestypeById($questid,$args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->assign('questype',$questype);
            \tpl::getInstance()->display('setting_modifyquestype');
        }
    }

    public function delquestype()
    {
        $questid = \route::get('questid');
        question::delQuestype($questid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function region()
    {
        $page = \route::get('page') > 0?\route::get('page'):1;
        $questypes = \exam\model\training::getTrainingList($page);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->display('setting_region');
    }

    public function index()
    {
        $app = \core\model\apps::getAppByCode('exam');
        if(\route::get('setting'))
        {
            $args = \route::get('args');
            \core\model\apps::modifyAppByCode('exam',array('appsetting' => $args));
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->assign('setting',$app['appsetting']);
            \tpl::getInstance()->display('setting');
        }
    }
}