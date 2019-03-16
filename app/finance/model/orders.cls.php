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