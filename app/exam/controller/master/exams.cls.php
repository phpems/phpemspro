<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\controller\master;

use core\model\apps;
use exam\model\favor;
use exam\model\points;
use exam\model\question;
use exam\model\training;

class exams
{
    public function __construct()
    {
        $search = \route::get('search');
        if($search)
        {
            $this->u = '';
            $this->search = $search;
            \tpl::getInstance()->assign('search',$search);
            foreach($search as $key => $arg)
            {
                $this->u .= "&search[{$key}]={$arg}";
            }
            unset($search);
        }
    }

    public function ordernote()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $delids = \route::get('delids');
        $action = \route::get('action');
        switch($action)
        {
            case 'pass':
            foreach($delids as $key => $v)
            {
                favor::modifyNote($subject['subjectdb'],$key,array('notestatus' => 1));
            }
            break;

            case 'delete':
            foreach($delids as $key => $v)
            {
                favor::delNote($subject['subjectdb'],$key);
            }
            break;

            default:
            break;
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function passnote()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $noteid = \route::get('noteid');
        favor::modifyNote($subject['subjectdb'],$noteid,array('notestatus' => 1));
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function delnote()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $noteid = \route::get('noteid');
        favor::delNote($subject['subjectdb'],$noteid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function notes()
    {
        if(\route::get('subjectid'))
        {
            $subjectid = \route::get('subjectid');
            $_SESSION['subjectid'] = $subjectid;
        }
        else
        {
            $subjectid = $_SESSION['subjectid'];
        }
        $page = \route::get('page');
        $page = $page > 1?$page:1;
        $subject = points::getSubjectById($subjectid);
        $args = array();
        $args[] = array("AND","notesubject = :notesubject","notesubject",$subject['subjectid']);
        $notes = favor::getNoteList($subject['subjectdb'],$args,$page,20,$orderby = 'notetime desc,noteid desc');
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('notes',$notes);
        \tpl::getInstance()->display('exams_notes');
    }

    public function delbasics()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $delids = \route::get('delids');
        foreach($delids as $key => $p)
        {
            \exam\model\exams::delBasic($subject['subjectdb'],$key);
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function addbasic()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        if(\route::get('addbasic'))
        {
            $args = \route::get('args');
            \exam\model\exams::addBasic($subject['subjectdb'],$args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-basics&subjectid=".$args['basicsubject']
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->display('exams_addbasic');
        }
    }

    public function modifybasic()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $basicid = \route::get('basicid');
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);;
        if(\route::get('modifybasic'))
        {
            $args = \route::get('args');
            \exam\model\exams::modifyBasic($subject['subjectdb'],$basicid,$args);
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
            \tpl::getInstance()->assign('basic',$basic);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->display('exams_modifybasic');
        }
    }

    public function settingbasic()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $basicid = \route::get('basicid');
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);;
        if(\route::get('settingbasic'))
        {
            $args = \route::get('args');
            $args['basicsections'] = array();
            if(is_array($args['basicpoints']))
            {
                foreach($args['basicpoints'] as $key => $p)
                {
                    $args['basicsections'][] = $key;
                }
            }
            $args['basicexam']['opentime']['start'] = strtotime($args['basicexam']['opentime']['start']);
            $args['basicexam']['opentime']['end'] = strtotime($args['basicexam']['opentime']['end']);
            $args['basicsections'] = $args['basicsections'];
            $args['basicpoints'] = $args['basicpoints'];
            $args['basicexam'] = $args['basicexam'];
            \exam\model\exams::modifyBasic($subject['subjectdb'],$basicid,$args);
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
            $points = points::getPointsBySubjectid($basic['basicsubject']);
            $sections = $points['sections'];
            $points = $points['points'];
            $tpls = array();
            foreach(glob("app/exam/view/app/exampaper_paper*.tpl") as $p)
            {
                $tpls['ep'][] = substr(basename($p),0,-4);
            }
            foreach(glob("app/exam/view/app/exam_paper*.tpl") as $p)
            {
                $tpls['pp'][] = substr(basename($p),0,-4);
            }
            \tpl::getInstance()->assign('tpls',$tpls);
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->assign('basic',$basic);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->display('exams_settingbasic');
        }
    }

    public function delbasic()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $basicid = \route::get('basicid');
        \exam\model\exams::delBasic($subject['subjectdb'],$basicid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function basics()
    {
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        if(\route::get('subjectid'))
        {
            $subjectid = \route::get('subjectid');
            $_SESSION['subjectid'] = $subjectid;
        }
        else
        {
            $subjectid = $_SESSION['subjectid'];
        }
        $subject = points::getSubjectById($subjectid);
        $args = array();
        $args[] = array("AND","basicsubject = :subjectid","subjectid",$subjectid);
        $basics = \exam\model\exams::getBasicsList($subject['subjectdb'],$args,$page);
        foreach($basics['data'] as $key => $basic)
        {
            $number = \exam\model\exams::getBasicMemberNumber($subject['subjectdb'],$basic['basicid']);
            $basics['data'][$key]['number'] = $number;
        }
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('basics',$basics);
        \tpl::getInstance()->display('exams_basics');
    }

    public function sectionconsole()
    {
        switch (\route::get('action'))
        {
            case 'modify':
                $ids = \route::get('ids');
                foreach($ids as $key => $p)
                {
                    points::modifySection($key,array('sectionorder' => $p));
                }
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功",
                    "callbackType" => "forward",
                    "forwardUrl" => "reload"
                );
                exit(json_encode($message));
                break;

            case 'delete':
                $delids = \route::get('delids');
                foreach($delids as $key => $p)
                {
                    if(points::getPointsNumber(array(array("AND","pointsection = :pointsection","pointsection",$key))))
                    {
                        $section = points::getSectionById($key);
                        $message = array(
                            'statusCode' => 300,
                            "message" => "操作失败，请先删除章节{$section['sectionname']}下所有知识点"
                        );
                        exit(json_encode($message));
                    }
                    points::delSection($key);
                }
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功",
                    "callbackType" => "forward",
                    "forwardUrl" => "reload"
                );
                exit(json_encode($message));
                break;

            default:
                break;
        }
    }

    public function pointconsole()
    {
        switch (\route::get('action'))
        {
            case 'modify':
                $ids = \route::get('ids');
                foreach($ids as $key => $p)
                {
                    points::modifyPoint($key,array('pointorder' => $p));
                }
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功",
                    "callbackType" => "forward",
                    "forwardUrl" => "reload"
                );
                exit(json_encode($message));
                break;

            case 'delete':
                $delids = \route::get('delids');
                foreach($delids as $key => $p)
                {
                    /*if(points::getPointsNumber(array(array("AND","pointsection = :pointsection","pointsection",$key))))
                    {
                        $section = points::getSectionById($key);
                        $message = array(
                            'statusCode' => 300,
                            "message" => "操作失败，请先删除章节{$section['sectionname']}下所有知识点"
                        );
                        exit(json_encode($message));
                    }*/
                    points::delPoint($key);
                }
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功",
                    "callbackType" => "forward",
                    "forwardUrl" => "reload"
                );
                exit(json_encode($message));
                break;

            default:
                break;
        }
    }

    public function addpoint()
    {
        if(\route::get('addpoint'))
        {
            $args = \route::get('args');
            points::addPoint($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-points&sectionid=".$args['pointsection']
            );
            exit(json_encode($message));
        }
        else
        {
            $sectionid = \route::get('sectionid');
            $section = points::getSectionById($sectionid);
            $subject = points::getSubjectById($section['sectionsubject']);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('section',$section);
            \tpl::getInstance()->display('exams_addpoint');
        }
    }

    public function modifypoint()
    {
        $pointid = \route::get('pointid');
        $point = points::getPointById($pointid);
        if(\route::get('modifypoint'))
        {
            $args = \route::get('args');
            points::modifyPoint($pointid,$args);
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
            $section = points::getSectionById($point['pointsection']);
            $subject = points::getSubjectById($section['sectionsubject']);
            \tpl::getInstance()->assign('point',$point);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('section',$section);
            \tpl::getInstance()->display('exams_modifypoint');
        }
    }

    public function delpoint()
    {
        $pointid = \route::get('pointid');
        points::delPoint($pointid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function points()
    {
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $sectionid = \route::get('sectionid');
        $args = array();
        $args[] = array("AND","pointsection = :sectionid","sectionid",$sectionid);
        $section = points::getSectionById($sectionid);
        $subject = points::getSubjectById($section['sectionsubject']);
        $points = points::getPointsList($args,$page);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('section',$section);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->display('exams_points');
    }

    public function addsection()
    {
        if(\route::get('addsection'))
        {
            $args = \route::get('args');
            points::addSection($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-sections&subjectid=".$args['sectionsubject']
            );
            exit(json_encode($message));
        }
        else
        {
            $subjectid = \route::get('subjectid');
            $subject = points::getSubjectById($subjectid);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->display('exams_addsection');
        }
    }

    public function modifysection()
    {
        $sectionid = \route::get('sectionid');
        $section = points::getSectionById($sectionid);
        if(\route::get('modifysection'))
        {
            $args = \route::get('args');
            points::modifySection($sectionid,$args);
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
            $subject = points::getSubjectById($section['sectionsubject']);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('section',$section);
            \tpl::getInstance()->display('exams_modifysection');
        }
    }

    public function delsection()
    {
        $sectionid = \route::get('sectionid');
        if(points::getPointsNumber(array(array("AND","pointsection = :sectionid","sectionid",$sectionid))))
        {
            $message = array(
                'statusCode' => 300,
                "message" => "操作失败，请删除该章节下所有知识点"
            );
            exit(json_encode($message));
        }
        points::delSection($sectionid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function sections()
    {
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $subjectid = \route::get('subjectid');
        $args = array();
        $args[] = array("AND","sectionsubject = :subjectid","subjectid",$subjectid);
        $subject = points::getSubjectById($subjectid);
        $sections = points::getSectionsList($args,$page);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->display('exams_sections');
    }

    public function addsubject()
    {
        if(\route::get('addsubject'))
        {
            $args = \route::get('args');
            points::addSubject($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams"
            );
            exit(json_encode($message));
        }
        else
        {
            $questypes = question::getQuestypesByArgs();
            $trainings = training::getTrainingsByArgs();
            \tpl::getInstance()->assign('trainings',$trainings);
            \tpl::getInstance()->assign('databases',\config::db);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->display('exams_addsubject');
        }
    }

    public function modifysubject()
    {
        $subjectid = \route::get('subjectid');
        $subject = points::getSubjectById($subjectid);
        if(\route::get('modifysubject'))
        {
            $args = \route::get('args');
            points::modifySubject($subjectid,$args);
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
            $questypes = question::getQuestypesByArgs();
            $trainings = training::getTrainingsByArgs();
            \tpl::getInstance()->assign('trainings',$trainings);
            \tpl::getInstance()->assign('databases',\config::db);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->display('exams_modifysubject');
        }
    }

    public function delsubjects()
    {
        $delids = \route::get('delids');
        foreach($delids as $subjectid => $p)
        {
            if(points::getSectionsNumber(array(array("AND","sectionsubject = :subjectid","subjectid",$subjectid))))
            {
                $subject = points::getSubjectById($subjectid);
                $message = array(
                    'statusCode' => 300,
                    "message" => "操作失败，请删除科目《{$subject['subjectname']}》下所有章节"
                );
                exit(json_encode($message));
            }
            points::delSubject($subjectid);
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function delsubject()
    {
        $subjectid = \route::get('subjectid');
        if(points::getSectionsNumber(array(array("AND","sectionsubject = :subjectid","subjectid",$subjectid))))
        {
            $message = array(
                'statusCode' => 300,
                "message" => "操作失败，请删除该科目下所有章节"
            );
            exit(json_encode($message));
        }
        points::delSubject($subjectid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function addpaper()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        if(\route::get('addpaper'))
        {
            $args = \route::get('args');
            $args['paperauthor'] = \exam\app::$_user['sessionusername'];
            $args['papertime'] = TIME;
            $totalscore = 0;
            foreach($args['papersetting']['questype'] as $key => $p)
            {
                if(!$args['papersetting']['questypelite'][$key])
                {
                    unset($args['papersetting']['questype'][$key],$args['paperquestions'][$key]);
                }
                $totalscore += $p['number'] * $p['score'];
            }
            if($args['papersetting']['score'] != $totalscore)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "分数设置不正确，请检查"
                );
                exit(json_encode($message));
            }
            if($args['papertype'] == 3)
            {
                $uploadfile = \route::get('uploadfile');
                $args['paperquestions'] = question::importCsvQuestions($uploadfile);
            }
            \exam\model\exams::addPaper($subject['subjectdb'],$args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-papers&subjectid={$args['papersubject']}"
            );
            exit(json_encode($message));
        }
        else
        {
            $type = \route::get('type');
            $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
            $points = points::getPointsBySubjectid($subjectid);
            $sections = $points['sections'];
            $points = $points['points'];
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('type',$type);
            \tpl::getInstance()->assign('questypes',$questypes);
            switch ($type)
            {
                case '2':
                    \tpl::getInstance()->display('exams_addselfpaper');
                    break;

                case '3':
                    \tpl::getInstance()->display('exams_addtemppaper');
                    break;

                default:
                    \tpl::getInstance()->display('exams_addpaper');
                    break;
            }
        }
    }

    public function modifypaper()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $paperid = \route::get('paperid');
        $paper = \exam\model\exams::getPaperById($subject['subjectdb'],$paperid);
        if(\route::get('modifypaper'))
        {
            $args = \route::get('args');
            $totalscore = 0;
            foreach($args['papersetting']['questype'] as $key => $p)
            {
                if(!$args['papersetting']['questypelite'][$key])
                {
                    unset($args['papersetting']['questype'][$key],$args['paperquestions'][$key]);
                }
                $totalscore += $p['number'] * $p['score'];
            }
            if($args['papersetting']['score'] != $totalscore)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "分数设置不正确，请检查"
                );
                exit(json_encode($message));
            }
            if($args['papertype'] == 3)
            {
                $uploadfile = \route::get('uploadfile');
                if($uploadfile)
                {
                    $args['paperquestions'] = question::importCsvQuestions($uploadfile);
                }
            }
            \exam\model\exams::modifyPaper($subject['subjectdb'],$paperid,$args);
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
            $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
            $points = points::getPointsBySubjectid($paper['papersubject']);
            $sections = $points['sections'];
            $points = $points['points'];
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('questypes',$questypes);
            switch ($paper['papertype'])
            {
                case '2':
                    foreach($paper['paperquestions'] as $key => $p)
                    {
                        $paper['papernumber'][$key] = \exam\model\question::getExamQuestionNumber($subject['subjectdb'],$p);
                    }
                    \tpl::getInstance()->assign('paper',$paper);
                    \tpl::getInstance()->display('exams_modifyselfpaper');
                    break;

                case '3':
                    \tpl::getInstance()->assign('paper',$paper);
                    \tpl::getInstance()->display('exams_modifytemppaper');
                    break;

                default:
                    \tpl::getInstance()->assign('paper',$paper);
                    \tpl::getInstance()->display('exams_modifypaper');
                    break;
            }
        }
    }

    public function delpaper()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $paperid = \route::get('paperid');
        \exam\model\exams::delPaper($subject['subjectdb'],$paperid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function papers()
    {
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        if(\route::get('subjectid'))
        {
            $subjectid = \route::get('subjectid');
            $_SESSION['subjectid'] = $subjectid;
        }
        else
        {
            $subjectid = $_SESSION['subjectid'];
        }
        $subject = points::getSubjectById($subjectid);
        $args = array();
        $args[] = array("AND","papersubject = :subjectid","subjectid",$subjectid);
        $subject = points::getSubjectById($subjectid);
        $papers = \exam\model\exams::getPapersList($subject['subjectdb'],$args,$page);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('papers',$papers);
        \tpl::getInstance()->display('exams_papers');
    }

    public function modifyquestion()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questionid = \route::get('questionid');
        $question = question::getQuestionById($subject['subjectdb'],$questionid);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        if(\route::get('modifyquestion'))
        {
            $args = \route::get('args');
            if(!$args['questionpoints'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
            $targs = \route::get('targs');
            if($questypes[$args['questiontype']]['questsort'])$choice = 0;
            else $choice = $questypes[$args['questiontype']]['questchoice'];
            $args['questionanswer'] = $targs['questionanswer'.$choice];
            if(!$args['questionanswer'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请填写答案"
                );
                exit(json_encode($message));
            }
            if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
            question::modifyQuestion($subject['subjectdb'],$questionid,$args);
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
            $points = points::getPointsBySubjectid($subjectid);
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
            $app = apps::getAppByCode('exam');
            $app['appsetting']['selectornumbers'] = explode(',',$app['appsetting']['selectornumbers']);
            $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
            \tpl::getInstance()->assign('question',$question);
            \tpl::getInstance()->assign('setting',$app['appsetting']);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->display('exams_modifyquestion');
        }
    }

    public function hidequestion()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questionid = \route::get('questionid');
        question::hideQuestion($subject['subjectdb'],$questionid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function hidequestions()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $delids = \route::get('delids');
        foreach($delids as $id => $p)
        {
            question::hideQuestion($subject['subjectdb'],$id);
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function addquestion()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        if(\route::get('addquestion'))
        {
            $args = \route::get('args');
            if(!$args['questionpoints'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
            $targs = \route::get('targs');
            if($questypes[$args['questiontype']]['questsort'])$choice = 0;
            else $choice = $questypes[$args['questiontype']]['questchoice'];
            $args['questionanswer'] = $targs['questionanswer'.$choice];
            if(!$args['questionanswer'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请填写答案"
                );
                exit(json_encode($message));
            }
            if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
            question::addQuestion($subject['subjectdb'],$args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-questions"
            );
            exit(json_encode($message));
        }
        else
        {
            $points = points::getPointsBySubjectid($subjectid);
            $sections = $points['sections'];
            $points = $points['points'];
            $app = apps::getAppByCode('exam');
            $app['appsetting']['selectornumbers'] = explode(',',$app['appsetting']['selectornumbers']);
            $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
            \tpl::getInstance()->assign('setting',$app['appsetting']);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->display('exams_addquestion');
        }
    }

    public function questions()
    {
        if(\route::get('subjectid'))
        {
            $subjectid = \route::get('subjectid');
            $_SESSION['subjectid'] = $subjectid;
        }
        else
        {
            $subjectid = $_SESSION['subjectid'];
        }
        $subject = points::getSubjectById($subjectid);
        $points = points::getPointsBySubjectid($subjectid);
        $sections = $points['sections'];
        $points = $points['points'];
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $args = array();
        if($this->search['questionid'])
        {
            $args[] = array("AND","questionid = :questionid",'questionid',$this->search['questionid']);
        }
        if($this->search['keyword'])
        {
            $args[] = array("AND","question LIKE :question",'question','%'.$this->search['keyword'].'%');
        }
        if($this->search['stime'])
        {
            $args[] = array("AND","questiontime >= :questioncreatetime",'questioncreatetime',strtotime($this->search['stime']));
        }
        if($this->search['etime'])
        {
            $args[] = array("AND","questiontime <= :questionendtime",'questionendtime',strtotime($this->search['etime']));
        }
        if($this->search['questiontype'])
        {
            $args[] = array("AND","questiontype = :questiontype",'questiontype',$this->search['questiontype']);
        }
        if($this->search['questionlevel'])
        {
            $args[] = array("AND","questionlevel = :questionlevel",'questionlevel',$this->search['questionlevel']);
        }
        if($this->search['questionsectionid'])
        {
            if($this->search['questionpointid'])
            {
                $args[] = array("AND","find_in_set(:questionpointid,questionpoints)","questionpointid",$this->search['questionpointid']);
            }
            else
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
            /*else
            {
                $args[] = array("AND","(");
                foreach($points[$this->search['questionsectionid']] as $key => $p)
                {
                    $args[] = array("OR","find_in_set(:questionpointid{$key},questionpoints)","questionpointid{$key}",$p['pointid']);
                }
                $args[] = array(")");
            }*/
        }
        else
        {
            $args[] = array("AND","questionsubject = :subjectid","subjectid",$subjectid);
        }
        $args[] = array("AND","questionstatus = 1");
        $args[] = array("AND","questionparent = 0");
        $questions = question::getQuestionList($subject['subjectdb'],$args,$page);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->display('exams_questions');
    }

    public function modifychildquestion()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questionid = \route::get('questionid');
        $question = question::getQuestionById($subject['subjectdb'],$questionid);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        if(\route::get('modifychildquestion'))
        {
            $args = \route::get('args');
            $targs = \route::get('targs');
            if($questypes[$args['questiontype']]['questsort'])$choice = 0;
            else $choice = $questypes[$args['questiontype']]['questchoice'];
            $args['questionanswer'] = $targs['questionanswer'.$choice];
            if(!$args['questionanswer'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请填写答案"
                );
                exit(json_encode($message));
            }
            if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
            question::modifyQuestion($subject['subjectdb'],$questionid,$args);
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
            $points = points::getPointsBySubjectid($subjectid);
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
            $app = apps::getAppByCode('exam');
            $app['appsetting']['selectornumbers'] = explode(',',$app['appsetting']['selectornumbers']);
            $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
            \tpl::getInstance()->assign('question',$question);
            \tpl::getInstance()->assign('setting',$app['appsetting']);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->display('exams_modifychildquestion');
        }
    }

    public function delquestion()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questionid = \route::get('questionid');
        question::delQuestion($subject['subjectdb'],$questionid);
        $question = question::getQuestionById($subject['subjectdb'],$questionid);
        if($question['questionparent'])
        question::resetRowsQuestionNumber($subject['subjectdb'],$question['questionparent']);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function orderchildquestion()
    {
        $action = \route::get('action');
        $delids = \route::get('delids');
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        switch ($action)
        {
            case 'sequence':
                foreach ($delids as $key => $p)
                {
                    question::modifyQuestion($subject['subjectdb'],$key,array('questionorder' => $p));
                }
                $question = question::getQuestionById($subject['subjectdb'],$key);
                if($question['questionparent'])
                question::resetRowsQuestionNumber($subject['subjectdb'],$question['questionparent']);
                break;

            default:
                break;
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function addchildquestion()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $qrid = \route::get('qrid');
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        if(\route::get('addchildquestion'))
        {
            $args = \route::get('args');
            $targs = \route::get('targs');
            if($questypes[$args['questiontype']]['questsort'])$choice = 0;
            else $choice = $questypes[$args['questiontype']]['questchoice'];
            $args['questionanswer'] = $targs['questionanswer'.$choice];
            if(!$args['questionanswer'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请填写答案"
                );
                exit(json_encode($message));
            }
            if(is_array($args['questionanswer']))$args['questionanswer'] = implode('',$args['questionanswer']);
            question::addQuestion($subject['subjectdb'],$args);
            question::resetRowsQuestionNumber($subject['subjectdb'],$args['questionparent']);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-questionrowsdetail&qrid={$qrid}"
            );
            exit(json_encode($message));
        }
        else
        {
            $points = points::getPointsBySubjectid($subjectid);
            $sections = $points['sections'];
            $points = $points['points'];
            $app = apps::getAppByCode('exam');
            $app['appsetting']['selectornumbers'] = explode(',',$app['appsetting']['selectornumbers']);
            $app['appsetting']['selectortype'] = explode(',',$app['appsetting']['selectortype']);
            \tpl::getInstance()->assign('setting',$app['appsetting']);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->assign('qrid',$qrid);
            \tpl::getInstance()->display('exams_addchildquestion');
        }
    }

    public function questionrowsdetail()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $qrid = \route::get('qrid');
        $questionrows = question::getQuestionRowsById($subject['subjectdb'],$qrid);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        $points = points::getPointsBySubjectid($subjectid);
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
        \tpl::getInstance()->assign('questionrows',$questionrows);
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->display('exams_questionrowsdetail');
    }

    public function hidequestionrow()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questionid = \route::get('qrid');
        question::hideQuestionrows($subject['subjectdb'],$questionid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function hidequestionrows()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $delids = \route::get('delids');
        foreach($delids as $id => $p)
        {
            question::hideQuestionrows($subject['subjectdb'],$id);
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function modifyquestionrows()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $qrid = \route::get('qrid');
        $questionrows = question::getQuestionRowsById($subject['subjectdb'],$qrid);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        if(\route::get('modifyquestionrows'))
        {
            $args = \route::get('args');
            $args['qrpoints'] = $args['questionpoints'];
            unset($args['questionpoints']);
            if(!$args['qrpoints'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
            question::modifyQuestionRows($subject['subjectdb'],$qrid,$args);
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
            $points = points::getPointsBySubjectid($subjectid);
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
            \tpl::getInstance()->assign('questionrows',$questionrows);
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->display('exams_modifyquestionrows');
        }
    }

    public function addquestionrows()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        if(\route::get('addquestionrows'))
        {
            $args = \route::get('args');
            $args['qrpoints'] = $args['questionpoints'];
            unset($args['questionpoints']);
            if(!$args['qrpoints'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
            question::addQuestionRows($subject['subjectdb'],$args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-master-exams-questionrows"
            );
            exit(json_encode($message));
        }
        else
        {
            $points = points::getPointsBySubjectid($subjectid);
            $sections = $points['sections'];
            $points = $points['points'];
            \tpl::getInstance()->assign('questypes',$questypes);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('sections',$sections);
            \tpl::getInstance()->assign('points',$points);
            \tpl::getInstance()->display('exams_addquestionrows');
        }
    }

    public function questionrows()
    {
        if(\route::get('subjectid'))
        {
            $subjectid = \route::get('subjectid');
            $_SESSION['subjectid'] = $subjectid;
        }
        else
        {
            $subjectid = $_SESSION['subjectid'];
        }
        $subject = points::getSubjectById($subjectid);
        $points = points::getPointsBySubjectid($subjectid);
        $sections = $points['sections'];
        $points = $points['points'];
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $args = array();
        if($this->search['qrid'])
        {
            $args[] = array("AND","qrid = :qrid",'qrid',$this->search['qrid']);
        }
        if($this->search['keyword'])
        {
            $args[] = array("AND","qrquestion LIKE :qrquestion",'qrquestion','%'.$this->search['keyword'].'%');
        }
        if($this->search['stime'])
        {
            $args[] = array("AND","qrtime >= :questioncreatetime",'questioncreatetime',strtotime($this->search['stime']));
        }
        if($this->search['etime'])
        {
            $args[] = array("AND","qrtime <= :questionendtime",'questionendtime',strtotime($this->search['etime']));
        }
        if($this->search['questiontype'])
        {
            $args[] = array("AND","qrtype = :questiontype",'questiontype',$this->search['questiontype']);
        }
        if($this->search['questionlevel'])
        {
            $args[] = array("AND","qrlevel = :questionlevel",'questionlevel',$this->search['questionlevel']);
        }
        if($this->search['questionsectionid'])
        {
            if($this->search['questionpointid'])
            {
                $args[] = array("AND","find_in_set(:qrpointid,qrpoints)","qrpointid",$this->search['questionpointid']);
            }
            else
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
        }
        else
        {
            $args[] = array("AND","qrsubject = :subjectid","subjectid",$subjectid);
        }
        $args[] = array("AND","qrstatus = 1");
        $questionrows = question::getQuestionRowsList($subject['subjectdb'],$args,$page);
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('questionrows',$questionrows);
        \tpl::getInstance()->display('exams_questionrows');
    }

    public function exportquestionrows()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $args = array();
        if($this->search['qrid'])
        {
            $args[] = array("AND","qrid = :qrid",'qrid',$this->search['qrid']);
        }
        if($this->search['keyword'])
        {
            $args[] = array("AND","qrquestion LIKE :qrquestion",'qrquestion','%'.$this->search['keyword'].'%');
        }
        if($this->search['stime'])
        {
            $args[] = array("AND","qrtime >= :questioncreatetime",'questioncreatetime',strtotime($this->search['stime']));
        }
        if($this->search['etime'])
        {
            $args[] = array("AND","qrtime <= :questionendtime",'questionendtime',strtotime($this->search['etime']));
        }
        if($this->search['questiontype'])
        {
            $args[] = array("AND","qrtype = :questiontype",'questiontype',$this->search['questiontype']);
        }
        if($this->search['questionlevel'])
        {
            $args[] = array("AND","qrlevel = :questionlevel",'questionlevel',$this->search['questionlevel']);
        }
        if($this->search['questionsectionid'])
        {
            if($this->search['questionpointid'])
            {
                $args[] = array("AND","find_in_set(:qrpointid,qrpoints)","qrpointid",$this->search['questionpointid']);
            }
            else
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
        }
        else
        {
            $args[] = array("AND","qrsubject = :subjectid","subjectid",$subjectid);
        }
        $args[] = array("AND","qrstatus = 1");
        $fname = 'public/data/out/questions/'.TIME.'.csv';
        if(\files::outCsv($fname,question::exportQuestionRows($subject['subjectdb'],$args)))
        {
            $message = array(
                'statusCode' => 200,
                "message" => "试题导出成功，转入下载页面，如果浏览器没有相应，请<a href=\"{$fname}\">点此下载</a>",
                "callbackType" => 'forward',
                "forwardUrl" => "{$fname}"
            );
        }
        else
        {
            $message = array(
                'statusCode' => 300,
                "message" => "试题导出失败"
            );
        }
        exit(json_encode($message));
    }

    public function exportquestions()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $args = array();
        if($this->search['questionid'])
        {
            $args[] = array("AND","questionid = :questionid",'questionid',$this->search['questionid']);
        }
        if($this->search['keyword'])
        {
            $args[] = array("AND","question LIKE :question",'question','%'.$this->search['keyword'].'%');
        }
        if($this->search['stime'])
        {
            $args[] = array("AND","questiontime >= :questioncreatetime",'questioncreatetime',strtotime($this->search['stime']));
        }
        if($this->search['etime'])
        {
            $args[] = array("AND","questiontime <= :questionendtime",'questionendtime',strtotime($this->search['etime']));
        }
        if($this->search['questiontype'])
        {
            $args[] = array("AND","questiontype = :questiontype",'questiontype',$this->search['questiontype']);
        }
        if($this->search['questionlevel'])
        {
            $args[] = array("AND","questionlevel = :questionlevel",'questionlevel',$this->search['questionlevel']);
        }
        if($this->search['questionsectionid'])
        {
            if($this->search['questionpointid'])
            {
                $args[] = array("AND","find_in_set(:questionpointid,questionpoints)","questionpointid",$this->search['questionpointid']);
            }
            else
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "请选择知识点"
                );
                exit(json_encode($message));
            }
        }
        else
        {
            $args[] = array("AND","questionsubject = :subjectid","subjectid",$subjectid);
        }
        $args[] = array("AND","questionstatus = 1");
        $args[] = array("AND","questionparent = 0");
        $fname = 'public/data/out/questions/'.TIME.'.csv';
        if(\files::outCsv($fname,question::exportQuestions($subject['subjectdb'],$args)))
        {
            $message = array(
                'statusCode' => 200,
                "message" => "试题导出成功，转入下载页面，如果浏览器没有相应，请<a href=\"{$fname}\">点此下载</a>",
                "callbackType" => 'forward',
                "forwardUrl" => "{$fname}"
            );
        }
        else
        {
            $message = array(
                'statusCode' => 300,
                "message" => "试题导出失败"
            );
        }
        exit(json_encode($message));
    }

    public function importquestions()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        if(\route::get('importquestions'))
        {
            $uploadfile = \route::get('uploadfile');
            if(!file_exists($uploadfile))
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "上传文件不存在"
                );
                exit(json_encode($message));
            }
            else
            {
                $number = question::importQuestions($uploadfile,$subject);
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功,导入普通试题{$number['question']}道,题帽题{$number['questionrows']}道",
                    "callbackType" => "forward",
                    "forwardUrl" => "index.php?exam-master-exams-questions"
                );
                exit(json_encode($message));
            }
        }
        else
        {
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->display('exams_importquestions');
        }
    }

    public function removemember()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $obid = \route::get('obid');
        \exam\model\exams::delBasicMember($subject['subjectdb'],$obid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function addmember()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $basicid = \route::get('basicid');
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);
        if(\route::get('addmember'))
        {
            $delids = \route::get('delids');
            $days = \route::get('days');
            $number = array('new' => 0,'old' => 0);
            foreach($delids as $key => $p)
            {
                $user = \user\model\users::getUserById($key);
                if($user['username'])
                {
                    $r = \exam\model\exams::getIsMember($subject['subjectdb'],$user['username'],$basicid);
                    if(!$r)
                    {
                        $args = array(
                            'obbasicid' => $basicid,
                            'obusername' => $user['username'],
                            'obtime' => TIME,
                            'obendtime' => TIME + 24*3600*$days
                        );
                        \exam\model\exams::addBasicMember($subject['subjectdb'],$args);
                        $number['new']++;
                    }
                    elseif(strtotime($r['obendtime']) < TIME)
                    {
                        $args = array(
                            'obendtime' => TIME + 24*3600*$days
                        );
                        \exam\model\exams::modifyBasicMember($subject['subjectdb'],$r['obid'],$args);
                        $number['old']++;
                    }
                    elseif(strtotime($r['obendtime']) >= TIME)
                    {
                        $args = array(
                            'obendtime' => strtotime($r['obendtime']) + 24*3600*$days
                        );
                        \exam\model\exams::modifyBasicMember($subject['subjectdb'],$r['obid'],$args);
                        $number['old']++;
                    }
                }
            }
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功，新开通{$number['new']}人，延长时间{$number['old']}人",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            $page = \route::get('page');
            $page = $page >= 1?$page:1;
            $args = array();
            if($this->search['userid'])$args[] = array('AND',"userid = :userid",'userid',$this->search['userid']);
            if($this->search['username'])$args[] = array('AND',"username LIKE :username",'username','%'.$this->search['username'].'%');
            if($this->search['useremail'])$args[] = array('AND',"useremail  LIKE :useremail",'useremail','%'.$this->search['useremail'].'%');
            if($this->search['userphone'])$args[] = array('AND',"userphone  LIKE :userphone",'userphone','%'.$this->search['userphone'].'%');
            if($this->search['groupcode'])$args[] = array('AND',"usergroupcode = :usergroupcode",'usergroupcode',$this->search['groupcode']);
            if($this->search['stime'] || $this->search['etime'])
            {
                if(!is_array($args))$args = array();
                if($this->search['stime']){
                    $stime = strtotime($this->search['stime']);
                    $args[] = array('AND',"userregtime >= :stime",'stime',$stime);
                }
                if($this->search['etime']){
                    $etime = strtotime($this->search['etime']);
                    $args[] = array('AND',"userregtime <= :etime",'etime',$etime);
                }
            }
            $users = \user\model\users::getUsersList($args,$page);
            $groups = \user\model\users::getGroups();
            \tpl::getInstance()->assign('basic',$basic);
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('users',$users);
            \tpl::getInstance()->assign('groups',$groups);
            \tpl::getInstance()->display('exams_addmember');
        }
    }

    public function members()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $basicid = \route::get('basicid');
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);
        $groups = \user\model\users::getGroups();
        $args = array();
        $args[] = array("AND","obbasicid = :obbasicid","obbasicid",$basicid);
        $args[] = array("AND","obusername = username");
        if($this->search['stime'])
        {
            $args[] = array("AND",'obtime >= :stime','stime',strtotime($this->search['stime']));
        }
        if($this->search['etime'])
        {
            $args[] = array("AND",'obtime >= :etime','etime',strtotime($this->search['etime']));
        }
        if($this->search['username'])
        {
            $args[] = array("AND",'obusername LIKE :username','username','%'.$this->search['username'].'%');
        }
        $members = \exam\model\exams::getBasicMember($subject['subjectdb'],$args,$page);
        \tpl::getInstance()->assign('groups',$groups);
        \tpl::getInstance()->assign('basic',$basic);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('members',$members);
        \tpl::getInstance()->display('exams_members');
    }

    public function stats()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $search = \route::get('search');
        $page = \route::get('page');
        if($page < 1)$page = 1;
        $args = array();
        $basicid = \route::get('basicid');
        $args[] =  array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid);
        if($search['stime'])
        {
            $stime = strtotime($search['stime']);
            $args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
        }
        if($search['etime'])
        {
            $etime = strtotime($search['etime']);
            $args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
        }
        if($search['sscore'])
        {
            $args[] = array('AND',"ehscore >= :sscore",'sscore',$search['sscore']);
        }
        if($search['escore'])
        {
            $args[] = array('AND',"ehscore <= :escore",'escore',$search['escore']);
        }
        if($search['examid'])
        {
            $args[] = array('AND',"ehpaperid = :ehpaperid",'ehpaperid',$search['ehpaperid']);
        }
        $rs = favor::getExamHistoriesByArgs($subject['subjectdb'],$args);
        $number = count($rs);
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);
        $stats = array();
        $os = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
        $questiontype = question::getQuestypesByArgs();
        foreach ($rs as $p) {
            foreach ($p['ehquestion']['questions'] as $questions) {
                foreach ($questions as $key => $question) {
                    $stats[$question['questionid']]['title'] = $question['question'];
                    $stats[$question['questionid']]['id'] = $question['questionid'];
                    if ($p['ehscorelist'][$question['questionid']] > 0)
                        $stats[$question['questionid']]['right'] = intval($stats[$question['questionid']]['right']) + 1;
                    $stats[$question['questionid']]['number'] = intval($stats[$question['questionid']]['number']) + 1;
                    if ($p['ehuseranswer'][$question['questionid']] && $questiontype[$question['questiontype']]['questsort'] == 0 && $questiontype[$question['questiontype']]['questchoice'] < 5) {
                        $p['ehuseranswer'][$question['questionid']] = implode("", $p['ehuseranswer'][$question['questionid']]);
                        foreach ($os as $o) {
                            if (strpos($p['ehuseranswer'][$question['questionid']], $o) !== false)
                                $stats[$question['questionid']][$o] = intval($stats[$question['questionid']][$o]) + 1;
                        }
                    }
                }
            }
            foreach ($p['ehquestion']['questionrows'] as $questionrows)
            {
                foreach ($questionrows as $questionrow)
                {
                    foreach ($questionrow['data'] as $key => $question)
                    {
                        $stats[$question['questionid']]['title'] = $questionrow['qrquestion'] . '<br />' . $question['question'];
                        $stats[$question['questionid']]['id'] = $question['questionid'];
                        if ($p['ehscorelist'][$question['questionid']] > 0)
                        {
                            $stats[$question['questionid']]['right'] = intval($stats[$question['questionid']]['right']) + 1;
                        }
                        $stats[$question['questionid']]['number'] = intval($stats[$question['questionid']]['number']) + 1;
                        if ($p['ehuseranswer'][$question['questionid']] && $questiontype[$question['questiontype']]['questsort'] == 0 && $questiontype[$question['questiontype']]['questchoice'] < 5)
                        {
                            $p['ehuseranswer'][$question['questionid']] = implode("", $p['ehuseranswer'][$question['questionid']]);
                            foreach ($os as $o)
                            {
                                if (strpos($p['ehuseranswer'][$question['questionid']], $o) !== false)
                                {
                                    $stats[$question['questionid']][$o] = intval($stats[$question['questionid']][$o]) + 1;
                                }
                            }
                        }
                    }
                }
            }
        }
        ksort($stats);
        $start = $page - 1;
        $start = $start >= 0 ? $start : 0;
        $tmp = array_slice($stats, $start * 20, 20);
        $pages = \pg::outPage(\pg::getPagesNumber(count($stats), 20), $page);
        \tpl::getInstance()->assign('stats', array('data' => $tmp, 'pages' => $pages));
        \tpl::getInstance()->assign('basic', $basic);
        \tpl::getInstance()->assign('subject', $subject);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('exam_stats');
    }

    public function scorelist()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $basicid = \route::get('basicid');
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);
        $args = array();
        $args[] = array("AND","ehbasicid = :ehbasicid","ehbasicid",$basicid);
        //$args[] = array('AND',"ehtype = '2'");
        $args[] = array('AND',"ehstatus = '1'");
        if($this->search['stime'])
        {
            $stime = strtotime($this->search['stime']);
            $args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
        }
        if($this->search['etime'])
        {
            $etime = strtotime($this->search['etime']);
            $args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
        }
        if($this->search['sscore'])
        {
            $args[] = array('AND',"ehscore >= :sscore",'sscore',$this->search['sscore']);
        }
        if($this->search['escore'])
        {
            $args[] = array('AND',"ehscore <= :escore",'escore',$this->search['escore']);
        }
        if($this->search['paperid'])
        {
            $args[] = array('AND',"ehpaperid = :ehpaperid",'ehpaperid',$this->search['paperid']);
        }
        $scores = favor::getUserExamHistoryList($subject['subjectdb'],$args,$page);
        $paperids = implode(',',explode(',',str_replace(' ','',trim($basic['basicexam']['self'],' ,').trim($basic['basicexam']['auto'],' ,'))));
        $papers = \exam\model\exams::getPapersByArgs($subject['subjectdb'],array(array("AND","find_in_set(paperid,:paperid)","paperid",$paperids)));
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('basic',$basic);
        \tpl::getInstance()->assign('scores',$scores);
        \tpl::getInstance()->assign('papers',$papers);
        \tpl::getInstance()->assign('fields',array(
            array('fieldtitle' => '真实姓名','field' => 'userrealname')
        ));
        \tpl::getInstance()->display('exams_scorelist');
    }

    public function outscore()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $basicid = \route::get('basicid');
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);
        $app = apps::getAppByCode('exam');
        $fields = explode(',',str_replace(' ','',$app['appsetting']['outfields']));
        $args = array();
        $args[] = array("AND","ehbasicid = :ehbasicid","ehbasicid",$basicid);
        //$args[] = array('AND',"ehtype = '2'");
        $args[] = array('AND',"ehstatus = '1'");
        if($this->search['stime'])
        {
            $stime = strtotime($this->search['stime']);
            $args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
        }
        if($this->search['etime'])
        {
            $etime = strtotime($this->search['etime']);
            $args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
        }
        if($this->search['sscore'])
        {
            $args[] = array('AND',"ehscore >= :sscore",'sscore',$this->search['sscore']);
        }
        if($this->search['escore'])
        {
            $args[] = array('AND',"ehscore <= :escore",'escore',$this->search['escore']);
        }
        if($this->search['examid'])
        {
            $args[] = array('AND',"ehexamid = :ehexamid",'ehexamid',$this->search['examid']);
        }
        if(!$fields)
        {
            $fstr = 'ehusername,ehstarttime,ehtime';
            $fields = explode(',',$fstr);
        }
        else
        {
            $fstr = implode(',',$fields);
        }
        $scores = favor::outUserExamHistory($subject['subjectdb'],$args,$fstr);
        $r = array();
        foreach($scores as $score)
        {
            $tmp = array();
            foreach($fields as $field)
            {
                $tmp[$field] = iconv("UTF-8","GBK",$score[$field]);
            }
            $r[] = $tmp;
        }
        $filename = 'public/data/out/score/'.TIME.'.csv';
        if(\files::outCsv($filename,$r))
        {
            $message = array(
                'statusCode' => 200,
                "message" => "成绩导出成功，转入下载页面，如果浏览器没有相应，请<a href=\"{$filename}\">点此下载</a>",
                "callbackType" => 'forward',
                "forwardUrl" => "{$filename}"
            );
        }
        else
        {
            $message = array(
                'statusCode' => 300,
                "message" => "成绩导出失败"
            );
        }
        exit(json_encode($message));
    }

    public function decide()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $basicid = \route::get('basicid');
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$basicid);
        $args = array();
        $args[] = array("AND","ehbasicid = :ehbasicid","ehbasicid",$basicid);
        $args[] = array('AND',"ehstatus = '0'");
        $scores = favor::getUserExamHistoryList($subject['subjectdb'],$args,$page);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('basic',$basic);
        \tpl::getInstance()->assign('scores',$scores);
        \tpl::getInstance()->display('exams_decide');
    }

    public function savescore()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $ehid = \route::get('ehid');
        $history = favor::getExamHistoryById($subject['subjectdb'],$ehid);
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$history['ehbasicid']);
        if(\route::get('makedecide'))
        {
            $score = \route::get('score');
            foreach($score as $key => $p)
            {
                $history['ehscorelist'][$key] = floatval($p);
            }
            $score = array_sum($history['ehscorelist']);
            favor::modifyExamHistory($subject['subjectdb'],$ehid,array('ehscorelist' => $history['ehscorelist'],'ehscore' => $score,'ehstatus' => 1));
            $message = array(
                'statusCode' => 200,
                'message' => '评分完成',
                "callbackType" => "forward",
                "forwardUrl" => "back"
            );
            \route::urlJump($message);
        }
        else {
            if (!$history['ehstatus'] && !$history['ehteacher'])
            {
                $args = array();
                $sessionvars['ehteacher'] = $args['ehteacher'] = \exam\master::$_user['sessionusername'];
                $sessionvars['ehdecidetime'] = $args['ehdecidetime'] = TIME;
                favor::modifyExamHistory($subject['subjectdb'], $ehid, $args);
            }
            elseif($history['ehteacher'] != \exam\master::$_user['sessionusername'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "本试卷已被{$history['ehteacher']}锁定批改中"
                );
                \route::urlJump($message);
            }
            $questypes = question::getQuestypesByArgs();
            $needdecide = array();
            foreach ($history['ehquestion']['questions'] as $key => $p) {
                if ($questypes[$key]['questsort']) {
                    $needdecide[$key] = 1;
                }
            }
            foreach ($history['ehquestion']['questionrows'] as $key => $p) {
                if ($questypes[$key]['questsort']) {
                    $needdecide[$key] = 1;
                } else {
                    foreach ($p as $q) {
                        foreach ($q['data'] as $qd) {
                            if ($questypes[$qd['questype']]['questsort']) {
                                $needdecide[$key] = 1;
                            }
                        }
                    }
                }
            }
            \tpl::getInstance()->assign('subject',$subject);
            \tpl::getInstance()->assign('basic',$basic);
            \tpl::getInstance()->assign('questypes', $questypes);
            \tpl::getInstance()->assign('needdecide', $needdecide);
            \tpl::getInstance()->assign('history', $history);
            \tpl::getInstance()->assign('questypes', $questypes);
            \tpl::getInstance()->display('exam_savescore');
        }
    }

    public function paperview()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $ehid = \route::get('ehid');
        $history = favor::getExamHistoryById($subject['subjectdb'],$ehid);
        $basic = \exam\model\exams::getBasicById($subject['subjectdb'],$history['ehbasicid']);
        $questypes = question::getQuestypesByArgs();
        \tpl::getInstance()->assign('basic',$basic);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('questypes', $questypes);
        \tpl::getInstance()->assign('history', $history);
        \tpl::getInstance()->assign('questypes', $questypes);
        \tpl::getInstance()->display('exam_view');
    }

    public function dorecyle()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $type = \route::get('type');
        if($type != 'questionrows')
        {
            $type = 'questions';
        }
        $action = \route::get('action');
        if($type == 'questions')
        {
            switch($action)
            {
                case 'recover':
                    $delids = \route::get('delids');
                    foreach($delids as $id => $p)
                    {
                        question::recoverQuestion($subject['subjectdb'],$id);
                    }
                    break;

                case 'delete':
                    $delids = \route::get('delids');
                    foreach($delids as $id => $p)
                    {
                        question::delQuestion($subject['subjectdb'],$id);
                    }
                    break;

                default:
                    break;
            }
        }
        else
        {
            switch($action)
            {
                case 'recover':
                    $delids = \route::get('delids');
                    foreach($delids as $id => $p)
                    {
                        question::recoverQuestionrows($subject['subjectdb'],$id);
                    }
                    break;

                case 'delete':
                    $delids = \route::get('delids');
                    foreach($delids as $id => $p)
                    {
                        question::delQuestionRows($subject['subjectdb'],$id);
                    }
                    break;

                default:
                    break;
            }
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function recyle()
    {
        if(\route::get('subjectid'))
        {
            $subjectid = \route::get('subjectid');
            $_SESSION['subjectid'] = $subjectid;
        }
        else
        {
            $subjectid = $_SESSION['subjectid'];
        }
        $subject = points::getSubjectById($subjectid);
        $type = \route::get('type');
        if($type != 'questionrows')
        {
            $type = 'questions';
        }
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $args = array();
        if($type == 'questionrows')
        {
            $args[] = array("AND","qrstatus = 0");
            $questionrows = question::getQuestionRowsList($subject['subjectdb'],$args,$page);
            \tpl::getInstance()->assign('questionrows',$questionrows);
        }
        else
        {
            $args[] = array("AND","questionstatus = 0");
            $questions = question::getQuestionList($subject['subjectdb'],$args,$page);
            \tpl::getInstance()->assign('questions',$questions);
        }
        $questypes = question::getQuestypesByArgs(array(array("AND","find_in_set(questcode,:questcode)","questcode",implode(',',$subject['subjectsetting']))));
        \tpl::getInstance()->assign('questypes',$questypes);
        \tpl::getInstance()->assign('type',$type);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->display('exams_recyle'.$type);
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $args = array();
        $subjects = points::getSubjectsList($args,$page);
        $trainings = training::getTrainingsByArgs();
        \tpl::getInstance()->assign('trainings',$trainings);
        \tpl::getInstance()->assign('subjects',$subjects);
        \tpl::getInstance()->display('exams');
    }
}