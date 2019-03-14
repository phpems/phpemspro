<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/12/8
 * Time: 10:47
 */

namespace exam\controller\master;


use exam\model\points;
use exam\model\question;

class ajax
{
    public function getpointsbysectionid()
    {
        $sectionid = \route::get('sectionid');
        $points = points::getPoints(array(array("AND","pointsection = :sectionid","sectionid",$sectionid)));
        foreach ($points as $p) {
            echo "<option value='{$p['pointid']}'>{$p['pointname']}</option>";
        }
        return;
    }

    public function selected()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $show = \route::get('show');
        $questionids = trim(\route::get('questionids')," ,");
        $rowsquestionids = trim(\route::get('questionrowsids')," ,");
        if(!$questionids)$questionids = '0';
        if(!$rowsquestionids)$rowsquestionids = '0';
        $questions = \exam\model\question::getQuestionsByArgs($subject['subjectdb'],array(array("AND","questionstatus = 1"),array("AND","find_in_set(questionid,:questionid)",'questionid',$questionids)));
        $questionrows = array();
        $rowsquestionids = explode(',',$rowsquestionids);
        foreach($rowsquestionids as $p)
        {
            if($p)
            {
                $r = \exam\model\question::getQuestionRowsById($subject['subjectdb'],$p);
                if($r['qrstatus'])
                {
                    $questionrows[$p] = $r;
                }
            }
        }
        \tpl::getInstance()->assign('questionrows',$questionrows);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->assign('show',$show);
        \tpl::getInstance()->display('ajax_selected');
    }

    public function selectquestions()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $search = \route::get('search');
        \pg::setUrlTarget('modal-body" class="ajax');
        if(!$search['questionisrows'])
        {
            $args = array(array("AND","questionstatus = '1'"),array("AND","questionparent = 0"));
            if($search['keyword'])
            {
                $args[] = array("AND","question LIKE :question",'question','%'.$search['keyword'].'%');
            }
            if($search['questionpointid'])
            {
                $args[] = array("AND","find_in_set(:questionpoints,questionpoints)",'questionpoints',$search['questionpointid']);
            }
            if($search['stime'])
            {
                $args[] = array("AND","questiontime >= :stime",'stime',strtotime($search['stime']));
            }
            if($search['etime'])
            {
                $args[] = array("AND","questiontime <= :etime",'etime',strtotime($search['etime']));
            }
            if($search['questiontype'])
            {
                $args[] = array("AND","questiontype = :questiontype",'questiontype',$search['questiontype']);
            }
            if($search['questionlevel'])
            {
                $args[] = array("AND","questionlevel = :questionlevel",'questionlevel',$search['questionlevel']);
            }
            $questions = question::getQuestionList($subject['subjectdb'],$args,$page);
        }
        else
        {
            $args = array(array("AND","qrstatus = '1'"));
            if($search['keyword'])
            {
                $args[] = array("AND","qrquestion LIKE :qrquestion",'qrquestion','%'.$search['keyword'].'%');
            }
            if($search['questionpointid'])
            {
                $args[] = array("AND","find_in_set(:qrpoints,qrpoints)",'qrpoints',$search['questionpointid']);
            }
            if($search['questiontype'])
            {
                $args[] = array("AND","qrtype = :qrtype",'qrtype',$search['questiontype']);
            }
            if($search['stime'])
            {
                $args[] = array("AND","qrtime >= :stime",'stime',strtotime($search['stime']));
            }
            if($search['etime'])
            {
                $args[] = array("AND","qrtime <= :etime",'etime',strtotime($search['etime']));
            }
            if($search['qrlevel'])
            {
                $args[] = array("AND","qrlevel = :qrlevel",'qrlevel',$search['qrlevel']);
            }
            $questions = question::getQuestionRowsList($subject['subjectdb'],$args,$page);
        }
        $points = points::getPointsBySubjectid($subjectid);
        $sections = $points['sections'];
        $points = $points['points'];
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('search',$search);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->assign('questions',$questions);
        \tpl::getInstance()->display('ajax_selectquestions');
    }

    public function selectpapers()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $target = \route::get('target');
        \pg::setUrlTarget('select-modal-body" class="ajax');
        $papers = \exam\model\exams::getPapersList($subject['subjectdb'],array(array("AND","papersubject = :papersubject","papersubject",$subjectid)),$page);
        \tpl::getInstance()->assign('papers',$papers);
        \tpl::getInstance()->assign('target',$target);
        \tpl::getInstance()->display('ajax_selectpapers');
    }

    public function selectgroups()
    {
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $target = \route::get('target');
        \pg::setUrlTarget('select-modal-body" class="ajax');
        $groups = \user\model\users::getGroups();
        \tpl::getInstance()->assign('groups',$groups);
        \tpl::getInstance()->assign('target',$target);
        \tpl::getInstance()->display('ajax_selectgroups');
    }

    public function questiondetail()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $questionid = \route::get('questionid');
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
        $question = question::getQuestionById($subject['subjectdb'],$questionid);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('question',$question);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->display('ajax_questiondetail');
    }

    public function questionrowsdetail()
    {
        $subjectid = $_SESSION['subjectid'];
        $subject = points::getSubjectById($subjectid);
        $qrid = \route::get('qrid');
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
        $questionrows = question::getQuestionRowsById($subject['subjectdb'],$qrid);
        \tpl::getInstance()->assign('subject',$subject);
        \tpl::getInstance()->assign('questionrows',$questionrows);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->display('ajax_questionrowsdetail');
    }

    public function index()
    {
        return;
    }
}