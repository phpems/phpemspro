<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\model;

class exams
{
    static function getPaperById($dbid,$id)
    {
        $data = array(
            'table' => 'papers',
            'query' => array(
                array("AND","paperid = :paperid","paperid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function getPaperByArgs($dbid,$args)
    {
        $data = array(
            'table' => 'papers',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function getPapersByArgs($dbid,$args)
    {
        $data = array(
            'table' => 'papers',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }

    static function delPaper($dbid,$id)
    {
        $data = array(
            'table' => 'papers',
            'query' => array(
                array("AND","paperid = :paperid","paperid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function addPaper($dbid,$args)
    {
        $data = array(
            'table' => 'papers',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->insertElement($data);
    }

    static function modifyPaper($dbid,$id,$args)
    {
        $data = array(
            'table' => 'papers',
            'value' => $args,
            'query' => array(
                array("AND","paperid = :paperid","paperid",$id)
            )
        );
        \pepdo::getInstance($dbid)->updateElement($data);
    }

    static function getPapersList($dbid,$args,$page,$number = \config::webpagenumber,$orderby = 'paperid desc')
    {
        $data = array(
            'table' => 'papers',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($dbid)->listElements($page,$number,$data);
    }

    static function getBasicById($dbid,$id)
    {
        $data = array(
            'table' => 'basics',
            'query' => array(
                array("AND","basicid = :basicid","basicid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function getBasicsByArgs($dbid,$args)
    {
        $data = array(
            'table' => 'basics',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }

    static function delBasic($dbid,$id)
    {
        $data = array(
            'table' => 'basics',
            'query' => array(
                array("AND","basicid = :basicid","basicid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function addBasic($dbid,$args)
    {
        $data = array(
            'table' => 'basics',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->insertElement($data);
    }

    static function modifyBasic($dbid,$id,$args)
    {
        $data = array(
            'table' => 'basics',
            'value' => $args,
            'query' => array(
                array("AND","basicid = :basicid","basicid",$id)
            )
        );
        \pepdo::getInstance($dbid)->updateElement($data);
    }

    static function getBasicsList($dbid,$args,$page,$number = \config::webpagenumber,$orderby = 'basicid desc')
    {
        $data = array(
            'table' => 'basics',
            'query' => $args,
            'orderby' => $orderby,
            'index' => 'basicid'
        );
        return \pepdo::getInstance($dbid)->listElements($page,$number,$data);
    }

    static function getBasicMember($dbid,$args,$page,$number = \config::webpagenumber,$orderby = 'obid desc')
    {
        $data = array(
            'table' => array('users','openbasics'),
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($dbid)->listElements($page,$number,$data);
    }

    static function delBasicMember($dbid,$id)
    {
        $data = array(
            'table' => 'openbasics',
            'query' => array(
                array("AND","obid = :obid","obid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function getIsMember($dbid,$username,$basicid)
    {
        $data = array(
            'table' => 'openbasics',
            'query' => array(
                array("AND","obusername = :obusername","obusername",$username),
                array("AND","obbasicid = :obbasicid","obbasicid",$basicid)
            )
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function addBasicMember($dbid,$args)
    {
        $data = array(
            'table' => 'openbasics',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->insertElement($data);
    }

    static function modifyBasicMember($dbid,$obid,$args)
    {
        $data = array(
            'table' => 'openbasics',
            'value' => $args,
            'query' => array(
                array("AND","obid = :obid","obid",$obid)
            )
        );
        return \pepdo::getInstance($dbid)->updateElement($data);
    }

    static function getBasicMemberNumber($dbid,$basicid)
    {
        $data = array(
            'select' => 'count(*) as number',
            'table' => 'openbasics',
            'query' => array(
                array("AND","obbasicid = :obbasicid","obbasicid",$basicid),
                array("AND","obendtime >= :obendtime","obendtime",TIME)
            )
        );
        $r = \pepdo::getInstance($dbid)->getElement($data);
        return intval($r['number']);
    }

    static function getOpenBasicsByUserName($dbid,$subjectid,$username)
    {
        $data = array(
            'select' => 'basicid,obendtime,basic,basicthumb,basicdescribe',
            'table' => array('openbasics','basics'),
            'query' => array(
                array("AND","obusername = :obusername","obusername",$username),
                array("AND","obendtime >= :obendtime","obendtime",TIME),
                array("AND","obbasicid = basicid"),
                array("AND","basicsubject = :subjectid","subjectid",$subjectid)
            )
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }
}