<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2019/1/17
 * Time: 21:20
 */

namespace lesson\model;


class lessons
{
    static function getLessonById($id)
    {
        $args = array(array("AND","lessonid = :lessonid","lessonid",$id));
        $data = array(
            'select' => false,
            'table' => 'lessons',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function modifyLesson($id,$args)
    {
        $data = array(
            'table' => 'lessons',
            'value' => $args,
            'query' => array(
                array("AND","lessonid = :lessonid","lessonid",$id)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    //添加信息
    static function addLesson($args)
    {
        $data = array(
            'table' => 'lessons',
            'query' => $args
        );
        \pepdo::getInstance()->insertElement($data);
    }

    static function delLesson($id)
    {
        $data = array(
            'table' => 'lessons',
            'query' => array(
                array("AND","lessonid = :lessonid","lessonid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function getLessonList($args,$page,$number = \config::webpagenumber,$orderby = 'lessonid desc')
    {
        $data = array(
            'table' => 'lessons',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function getVideoList($args,$page,$number = \config::webpagenumber,$orderby = 'videoorder desc,videoid desc')
    {
        $data = array(
            'table' => 'videos',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function getVideosByArgs($args,$orderby = 'videoorder desc,videoid desc')
    {
        $data = array(
            'table' => 'videos',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getVideoById($id)
    {
        $args = array(array("AND","videoid = :videoid","videoid",$id));
        $data = array(
            'select' => false,
            'table' => 'videos',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function modifyVideo($id,$args)
    {
        $data = array(
            'table' => 'videos',
            'value' => $args,
            'query' => array(
                array("AND","videoid = :videoid","videoid",$id)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    //添加信息
    static function addVideo($args)
    {
        $data = array(
            'table' => 'videos',
            'query' => $args
        );
        \pepdo::getInstance()->insertElement($data);
    }

    static function delVideo($id)
    {
        $data = array(
            'table' => 'videos',
            'query' => array(
                array("AND","videoid = :videoid","videoid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function getVideosNumber($lessonid)
    {
        $args = array(array("AND","videolesson = :videolesson","videolesson",$lessonid));
        $data = array(
            'select' => "count(*) as number",
            'table' => 'videos',
            'query' => $args
        );
        $r = \pepdo::getInstance()->getElement($data);
        return $r['number'];
    }

    static function isLessonMember($username,$lessonid)
    {
        $data = array(
            'select' => false,
            'table' => 'openlessons',
            'query' => array(
                array("AND","oplusername = :oplusername","oplusername",$username),
                array("AND","opllessonid = :opllessonid","opllessonid",$lessonid)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getOpenLessons($username)
    {
        $args = array(array("AND","oplusername = :oplusername","oplusername",$username));
        $args[] = array("AND","opllessonid = lessonid");
        $data = array(
            'select' => false,
            'table' => array('openlessons','lessons'),
            'query' => $args,
            'limit' => false
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getLessonMemberList($args,$page,$number = \config::webpagenumber,$orderby = 'oplid desc')
    {
        $args[] = array("AND","oplusername = username");
        $data = array(
            'table' => array('openlessons','users'),
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function delLessonMember($oplid)
    {
        $data = array(
            'table' => 'openlessons',
            'query' => array(
                array("AND","oplid = :oplid","oplid",$oplid)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function openLesson($username,$lessonid,$time)
    {
        $rs = self::isLessonMember($username,$lessonid);
        if($rs)
        {
            $rs['oplendtime'] = strtotime($rs['oplendtime']);
            if($rs['oplendtime'] >= TIME)
            {
                $endtime = $rs['oplendtime'] + $time * 3600 *24;
            }
            else
            {
                $endtime = TIME + $time * 3600 *24;
            }
            $data = array(
                'table' => 'openlessons',
                'value' => array(
                    'oplendtime' => $endtime
                ),
                'query' => array(
                    array("AND","oplid = :oplid","oplid",$rs['oplid'])
                )
            );
            \pepdo::getInstance()->updateElement($data);
            return 1;
        }
        else
        {
            $data = array(
                'table' => 'openlessons',
                'query' => array(
                    'oplusername' => $username,
                    'opllessonid' => $lessonid,
                    'opltime' => TIME,
                    'oplendtime' => TIME + $time * 3600 *24
                )
            );
            \pepdo::getInstance()->insertElement($data);
            return 0;
        }
    }
}