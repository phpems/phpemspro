<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/20
 * Time: 23:10
 */

namespace finance\model;


class orders
{

    static function getOrderBySn($sn)
    {
        $args = array(array("AND","ordersn = :ordersn","ordersn",$sn));
        $data = array(
            'select' => false,
            'table' => 'orders',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function modifyOrder($sn,$args)
    {
        $data = array(
            'table' => 'orders',
            'value' => $args,
            'query' => array(
                array("AND","ordersn = :ordersn","ordersn",$sn)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    static function delOrder($sn)
    {
        $data = array(
            'table' => 'orders',
            'query' => array(
                array("AND","ordersn = :ordersn","ordersn",$sn)
            )
        );
        \pepdo::getInstance()->delElement($data);
    }

    static function addOrder($args)
    {
        $data = array('table' => 'orders','query' => $args);
        if($args['ordertype'] == 'exam')
        {
            foreach($args['orderitems'] as $item)
            {
                $actargs = array();
                $actargs['activename'] = $item['basicname'];
                $actargs['activebasicid'] = $item['basicid'];
                $actargs['activetime'] = $item['time'];
                $actargs['activesubjectid'] = $item['subjectid'];
                $actargs['activeorder'] = $args['ordersn'];
                $actargs['activeordertime'] = TIME;
                $actargs['activestatus'] = 0;
                $actargs['activeusername'] = $args['orderusername'];
                self::addActive($actargs);
            }
        }
        return \pepdo::getInstance()->insertElement($data);
    }

    static function getOrderList($args = array(),$page,$number = \config::webpagenumber)
    {
        $data = array(
            'table' => 'orders',
            'query' => $args,
            'orderby' => 'ordersn desc'
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function addActive($args)
    {
        $data = array('table' => 'actives','query' => $args);
        return \pepdo::getInstance()->insertElement($data);
    }

    static function getActiveByArgs($args)
    {
        $data = array(
            'select' => false,
            'table' => 'actives',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getActivesByArgs($args)
    {
        $data = array(
            'select' => false,
            'table' => 'actives',
            'query' => $args
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function modifyActive($id,$args)
    {
        $data = array(
            'table' => 'actives',
            'value' => $args,
            'query' => array(
                array("AND","activeid = :activeid","activeid",$id)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    static function modifyActives($query,$args)
    {
        $data = array(
            'table' => 'actives',
            'value' => $args,
            'query' => $query
        );
        \pepdo::getInstance()->updateElement($data);
    }

    static function getRegOrderList($args = array(),$page,$number = \config::webpagenumber)
    {
        $data = array(
            'table' => array('orders','users'),
            'query' => $args,
            'orderby' => 'ordersn desc'
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }
}