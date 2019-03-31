<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace user\model;

class users
{
    static function getUserById($userid)
    {
        $data = array(
            'table' => 'users',
            'query' => array(
                array("AND","userid = :userid","userid",$userid)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getUserByUsername($username)
    {
        $data = array(
            'table' => 'users',
            'query' => array(
                array("AND","username = :username","username",$username)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getUserByEmail($email)
    {
        $data = array(
            'table' => 'users',
            'query' => array(
                array("AND","useremail = :useremail","useremail",$email)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getUserByOpenid($openid)
    {
        $data = array(
            'table' => 'users',
            'query' => array(
                array("AND","useropenid = :useropenid","useropenid",$openid)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getUserByPhone($phone)
    {
        $data = array(
            'table' => 'users',
            'query' => array(
                array("AND","userphone = :userphone","userphone",$phone)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getUsersList($args,$page,$number = \config::webpagenumber,$orderby = 'userid desc')
    {
        $data = array(
            'table' => 'users',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function getUserNumberByArgs($args)
    {
        $data = array(
            'count(*) as number',
            'users',
            'query' => $args
        );
        $sql = \pdosql::getInstance()->makeSelect($data);
        $r = \pepdo::getInstance()->fetch($sql);
        return intval($r['number']);
    }

    static function getGroupById($groupid)
    {
        $data = array(
            'table' => 'groups',
            'query' => array(
                array("AND","groupid = :groupid","groupid",$groupid)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getGroupByCode($groupcode)
    {
        $data = array(
            'table' => 'groups',
            'query' => array(
                array("AND","groupcode = :groupcode","groupcode",$groupcode)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getGroupsByModelCode($modelcode)
    {
        $data = array(
            'table' => 'groups',
            'query' => array(
                array("AND","groupmodel = :groupmodel","groupmodel",$modelcode)
            )
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getGroups()
    {
        $data = array(
            'table' => 'groups',
            'index' => 'groupcode'
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static public function getDefaultGroup()
    {
        $data = array(
            'table' => 'groups',
            'query' => array(
                array("AND","groupdefault = 1")
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static public function setDefaultGroup($groupid)
    {
        $data = array(
            'table' => 'groups',
            'value' => array('groupdefault' => 0),
            'query' => array()
        );
        \pepdo::getInstance()->updateElement($data);
        $data = array(
            'table' => 'groups',
            'value' => array('groupdefault' => 1),
            'query' => array(
                array("AND","groupid = :groupid","groupid",$groupid)
            )
        );
        return \pepdo::getInstance()->updateElement($data);
    }

    static function addUser($args)
    {
        $args['userregtime'] = TIME;
        $data = array(
            'table' => 'users',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static function addGroup($args)
    {
        $data = array(
            'table' => 'groups',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static function modifyUser($userid,$args)
    {
        $data = array(
            'table' => 'users',
            'value' => $args,
            'query' => array(
                array("AND","userid = :userid","userid",$userid)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    static function modifyGroup($groupid,$args)
    {
        $data = array(
            'table' => 'groups',
            'value' => $args,
            'query' => array(
                array("AND","groupid = :groupid","groupid",$groupid)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    static function delUser($userid)
    {
        $data = array(
            'table' => 'users',
            'query' => array(
                array("AND","userid = :userid","userid",$userid)
            )
        );
        \pepdo::getInstance()->delElement($data);
    }

    static function delGroup($groupid)
    {
        $data = array(
            'table' => 'groups',
            'query' => array(
                array("AND","groupid = :groupid","groupid",$groupid)
            )
        );
        \pepdo::getInstance()->delElement($data);
    }
}