<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace finance\controller\master;

class orders
{
    public function __construct()
    {
        $orderstatus = array(1=>'待付款',2=>'已完成',99=>'已撤单');
        \tpl::getInstance()->assign('orderstatus',$orderstatus);
    }

    public function del()
    {
        $ordersn = \route::get('ordersn');
        $order = \finance\model\orders::getOrderBySn($ordersn);
        if($order['orderstatus'] != 99)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "只有作废的订单才能删除"
            );
            \route::urlJump($message);
        }
        \finance\model\orders::delOrder($ordersn);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => 'forward',
            "forwardUrl" => "reload"
        );
        \route::urlJump($message);
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page > 1?$page:1;
        $args = array();
        $orders = \finance\model\orders::getOrderList($args,$page);
        \tpl::getInstance()->assign('orders',$orders);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('orders');
    }
}