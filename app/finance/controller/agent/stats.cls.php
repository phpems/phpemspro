<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace finance\controller\agent;

class stats
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page > 1?$page:1;
        $args = array();
        $args[] = array("AND","users.username = orders.orderagent");
        $args[] = array("AND","users.useragent = :useragent","useragent",\finance\agent::$_user['sessionusername']);
        $args[] = array("AND","orders.ordertype in ('exam','lesson')");
        $args[] = array("AND","orders.orderstatus = 2");
        $orders = \finance\model\orders::getRegOrderList($args,$page);
        \tpl::getInstance()->assign('orders',$orders);
        \tpl::getInstance()->display('stats');
    }
}