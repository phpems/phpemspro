<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\model;

class points
{
    static function getSubjects($args = array(),$orderby = 'subjectid desc')
    {
        $data = array(
            'table' => 'subjects',
            'query' => $args,
            'orderby' => $orderby,
            'index' => 'subjectid'
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getSubjectsNumber($args)
    {
        $data = array(
            'select' => 'count(`trid`) as number',
            'table' => 'subjects',
            'query' => $args
        );
        $r = \pepdo::getInstance()->getElement($data);
        return $r['number'];
    }

    static function getSubjectsList($args,$page,$number = \config::webpagenumber,$orderby = 'subjectid desc')
    {
        $data = array(
            'table' => 'subjects',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function getSubjectById($id)
    {
        $data = array(
            'table' => 'subjects',
            'query' => array(
                array("AND","subjectid = :subjectid","subjectid",$id)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function addSubject($args)
    {
        $data = array(
            'table' => 'subjects',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static function delSubject($id)
    {
        $data = array(
            'table' => 'subjects',
            'query' => array(
                array("AND","subjectid = :subjectid","subjectid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function modifySubject($id,$args)
    {
        $data = array(
            'table' => 'subjects',
            'query' => array(
                array("AND","subjectid = :subjectid","subjectid",$id)
            ),
            'value' => $args
        );
        return \pepdo::getInstance()->updateElement($data);
    }

    static function getSectionsNumber($args)
    {
        $data = array(
            'select' => 'count(`sectionid`) as number',
            'table' => 'sections',
            'query' => $args
        );
        $r = \pepdo::getInstance()->getElement($data);
        return $r['number'];
    }

    static function getSectionsList($args,$page,$number = \config::webpagenumber,$orderby = 'sectionorder desc,sectionid desc')
    {
        $data = array(
            'table' => 'sections',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function getSectionsByArgs($args,$orderby = 'sectionorder desc,sectionid desc')
    {
        $data = array(
            'table' => 'sections',
            'query' => $args,
            'index' => 'sectionid',
            'orderby' => $orderby,
            'limit' => false
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getSectionById($id)
    {
        $data = array(
            'table' => 'sections',
            'query' => array(
                array("AND","sectionid = :sectionid","sectionid",$id)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function addSection($args)
    {
        $data = array(
            'table' => 'sections',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static function delSection($id)
    {
        $data = array(
            'table' => 'sections',
            'query' => array(
                array("AND","sectionid = :sectionid","sectionid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function modifySection($id,$args)
    {
        $data = array(
            'table' => 'sections',
            'query' => array(
                array("AND","sectionid = :sectionid","sectionid",$id)
            ),
            'value' => $args
        );
        return \pepdo::getInstance()->updateElement($data);
    }

    static function getPointsNumber($args)
    {
        $data = array(
            'select' => 'count(`pointid`) as number',
            'table' => 'points',
            'query' => $args
        );
        $r = \pepdo::getInstance()->getElement($data);
        return $r['number'];
    }

    static function getPoints($args,$orderby = 'pointorder desc,pointid desc')
    {
        $data = array(
            'table' => 'points',
            'query' => $args,
            'orderby' => $orderby,
            'index' => 'pointid'
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getPointsList($args,$page,$number = \config::webpagenumber,$orderby = 'pointorder desc,pointid desc')
    {
        $data = array(
            'table' => 'points',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function getPointById($id)
    {
        $data = array(
            'table' => 'points',
            'query' => array(
                array("AND","pointid = :pointid","pointid",$id)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function addPoint($args)
    {
        $data = array(
            'table' => 'points',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static function modifyPoint($id,$args)
    {
        $data = array(
            'table' => 'points',
            'value' => $args,
            'query' => array(
                array("AND","pointid = :pointid","pointid",$id)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    static function delPoint($id)
    {
        $data = array(
            'table' => 'points',
            'query' => array(
                array("AND","pointid = :pointid","pointid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function getPointsBySubjectid($subjectid)
    {
        $points = array();
        $sections = self::getSectionsByArgs(array(array("AND","sectionsubject = :subjectid","subjectid",$subjectid)));
        foreach($sections as $section)
        {
            $points[$section['sectionid']] = self::getPoints(array(array("AND","pointsection = :sectionid","sectionid",$section['sectionid'])));
        }
        return array('sections' => $sections,'points' => $points);
    }
}