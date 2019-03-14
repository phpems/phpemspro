<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace finance\controller\agent;

class records
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
        $args[] = array("AND","ordertype = 'recharge'");
        $args[] = array("AND","orderstatus = 2");
        $args[] = array("AND","orderusername = :orderusername","orderusername",\finance\agent::$_user['sessionusername']);
        $orders = \finance\model\orders::getOrderList($args,$page);
        \tpl::getInstance()->assign('orders',$orders);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('records');
    }
}