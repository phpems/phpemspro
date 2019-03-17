<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/20
 * Time: 23:10
 */

namespace content\model;


class content
{

    static function getContentById($id)
    {
        $args = array(array("AND","contentid = :contentid","contentid",$id));
        $data = array(
            'select' => false,
            'table' => 'contents',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function modifyContent($id,$args)
    {
        $data = array(
            'table' => 'contents',
            'value' => $args,
            'query' => array(
                array("AND","contentid = :contentid","contentid",$id)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    //添加信息
    static function addContent($args)
    {
        $data = array(
            'table' => 'contents',
            'query' => $args
        );
        \pepdo::getInstance()->insertElement($data);
    }

    static function delContent($id)
    {
        $data = array(
            'table' => 'contents',
            'query' => array(
                array("AND","contentid = :contentid","contentid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static public function getContentList($args,$page,$number = \config::webpagenumber,$orderby = 'contentorder desc,contentid desc')
    {
        $data = array(
            'table' => 'contents',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }
}