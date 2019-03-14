<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace user\controller\app;

class orders
{
    public function __construct()
    {
        //
    }

    public function qrcode()
    {
        require_once "public/vendor/qrcode/qrcode.php";
        $data = urldecode(\route::get('data'));
        \QRcode::png($data,false,QR_ECLEVEL_L,7);
    }

    public function getstatus()
    {
        $ordersn = \route::get('ordersn');
        $order = \finance\model\orders::getOrderBySn($ordersn);
        if($order['orderstatus'] == 1)
        {
            $message = array(
                'statusCode' => 300
            );
        }
        else
        {
            $message = array(
                'statusCode' => 200,
                "message" => "支付成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?user-app-orders-detail&ordersn=".$ordersn
            );
        }
        exit(json_encode($message));
    }

    public function wxpay()
    {

        $ordersn = \route::get('ordersn');
        $order = \finance\model\orders::getOrderBySn($ordersn);
        $wxpayforurl = \wxpay::getInstance()->outQrcodeUrl($order);
        \tpl::getInstance()->assign('data',urlencode($wxpayforurl['code_url']));
        \tpl::getInstance()->assign('order',$order);
        \tpl::getInstance()->display('orders_wxpay');
    }

    public function detail()
    {
        $ordersn = \route::get('ordersn');
        $order = \finance\model\orders::getOrderBySn($ordersn);
        $alipayforurl = \alipay::getInstance()->createPagePayLink($order);
        \tpl::getInstance()->assign('alipayforurl',$alipayforurl);
        \tpl::getInstance()->assign('order',$order);
        \tpl::getInstance()->display('orders_detail');
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page > 1?$page:1;
        $args = array(
            array("AND","orderusername = :orderusername","orderusername",\user\app::$_user['sessionusername']),
            array("AND","orderstatus = 2")
        );
        $orders = \finance\model\orders::getOrderList($args,$page);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('orders',$orders);
        \tpl::getInstance()->display('orders');
    }
}