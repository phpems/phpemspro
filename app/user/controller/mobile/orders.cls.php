<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace user\controller\mobile;

class orders
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page > 1?$page:1;
        $args = array(
            array("AND","orderusername = :orderusername","orderusername",\user\mobile::$_user['sessionusername'])
        );
        $orders = \finance\model\orders::getOrderList($args,$page);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('orders',$orders);
        \tpl::getInstance()->display('orders');
    }
}