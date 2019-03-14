<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\model;

class training
{
    static function getTrainingById($id)
    {
        $data = array(
            'table' => 'training',
            'query' => array(
                array("AND","trid = :trid","trid",$id)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getTrainingsByArgs($args = array())
    {
        $data = array(
            'table' => 'training',
            'query' => $args,
            'orderby' => 'trid desc',
            'index' => 'trid',
            'limit' => false
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getTrainingList($page,$number = \config::webpagenumber)
    {
        $data = array(
            'table' => 'training',
            'query' => array(),
            'orderby' => 'trid desc'
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function modifyTrainingById($id,$args)
    {
        $data = array(
            'table' => 'training',
            'value' => $args,
            'query' => array(
                array("AND","trid = :trid","trid",$id)
            )
        );
        return \pepdo::getInstance()->updateElement($data);
    }

    static function addTraining($args)
    {
        $data = array(
            'table' => 'training',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static function delTraining($id)
    {
        $data = array(
            'table' => 'training',
            'query' => array(
                array("AND","trid = :trid","trid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }
}