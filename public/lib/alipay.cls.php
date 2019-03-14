<?php

require_once PEP_PATH."/public/vendor/alipay/AopSdk.php";
require_once PEP_PATH."/public/vendor/alipay/AlipayTradeService.php";
require_once PEP_PATH."/public/vendor/alipay/AlipayTradePagePayContentBuilder.php";
require_once PEP_PATH."/public/vendor/alipay/AlipayTradeWapPayContentBuilder.php";

class alipay
{
	static $instance;
	public $config = array (
        //应用ID,您的APPID。
        'app_id' => \config::aliappid,
        //商户私钥，您的原始格式RSA私钥
        'merchant_private_key' => \config::alikey,
        //异步通知地址
        'notify_url' => \config::webpath."api/alinotify.php",
        //同步跳转
        'return_url' => \config::webpath."api/alireturn.php",
        //编码格式
        'charset' => "UTF-8",
        //签名方式
        'sign_type'=>"RSA2",//RSA2
        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => \config::alipub,
    );

    static function getInstance()
    {
        if(self::$instance == NULL)
        {
            self::$instance = new static();//亦可写为 new self();
        }
        return self::$instance;
    }

    public function createPagePayLink($order)
    {
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody("购买课程，开通考场");
        $payRequestBuilder->setSubject($order['ordername']);
        $payRequestBuilder->setOutTradeNo($order['ordersn']);
        $payRequestBuilder->setTotalAmount($order['orderprice']);

        $payResponse = new AlipayTradeService($this->config);
        return $payResponse->pagePay($payRequestBuilder,$this->config['return_url'],$this->config['notify_url']);
    }

    public function createWapPayLink($order)
    {
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody("购买课程，开通考场");
        $payRequestBuilder->setSubject($order['ordername']);
        $payRequestBuilder->setOutTradeNo($order['ordersn']);
        $payRequestBuilder->setTotalAmount($order['orderprice']);

        $payResponse = new AlipayTradeService($this->config);
        return $payResponse->wapPay($payRequestBuilder,$this->config['return_url'],$this->config['notify_url']);
    }

    public function notify()
    {
        $alipaySevice = new AlipayTradeService($this->config);
        //$alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($_POST);
        if($result)
        {
            $sn = \route::get('out_trade_no');
            $order = \finance\model\orders::getOrderBySn($sn);
            if($order && $order['orderstatus'] != 2)
            {
                \finance\model\orders::modifyOrder($sn,array('orderstatus' => 2,'orderpaytype' => 'alipay'));
                if($order['ordertype'] == 'exam')
                {
                    foreach($order['orderitems'] as $item)
                    {
                        $subjectid = $item['subjectid'];
                        $subject = \exam\model\points::getSubjectById($subjectid);
                        $basicid = $item['basicid'];
                        $r = \exam\model\exams::getIsMember($subject['subjectdb'],$order['orderusername'],$basicid);
                        if(!$r)
                        {
                            $args = array(
                                'obbasicid' => $basicid,
                                'obusername' => $order['orderusername'],
                                'obtime' => TIME,
                                'obendtime' => TIME + 24*3600*$item['time']
                            );
                            \exam\model\exams::addBasicMember($subject['subjectdb'],$args);
                        }
                        elseif(strtotime($r['obendtime']) < TIME)
                        {
                            $args = array(
                                'obendtime' => TIME + 24*3600*$item['time']
                            );
                            \exam\model\exams::modifyBasicMember($subject['subjectdb'],$r['obid'],$args);
                        }
                        elseif(strtotime($r['obendtime']) >= TIME)
                        {
                            $args = array(
                                'obendtime' => strtotime($r['obendtime']) + 24*3600*$item['time']
                            );
                            \exam\model\exams::modifyBasicMember($subject['subjectdb'],$r['obid'],$args);
                        }
                    }
                }
                elseif($order['ordertype'] == 'lesson')
                {
                    foreach($order['orderitems'] as $item)
                    {
                        $lessonid = $item['lessonid'];
                        $time = $item['time'];
                        \lesson\model\lessons::openLesson($order['orderusername'], $lessonid, $time);
                    }
                }
                elseif($order['ordertype'] == 'recharge')
                {
                    $user = \user\model\users::getUserByUsername($order['orderusername']);
                    $coin = $user['usercoin'] + $order['orderprice'];
                    \user\model\users::modifyUser($user['userid'],array('usercoin' => $coin));
                }
            }
            echo "success";
        }
        else
        {
            echo "fail";
        }
    }

    public function reback()
    {
        $alipaySevice = new AlipayTradeService($this->config);
        //$alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($_GET);
        if($result)
        {
            $sn = \route::get('out_trade_no');
            $order = \finance\model\orders::getOrderBySn($sn);
            if($order['ordertype'] == 'exam')
            {
                header("location:../index.php?exam-app-basic");
            }
            elseif($order['ordertype'] == 'lesson')
            {
                $item = current($order['orderitems']);
                header("location:../index.php?lesson-app-lesson&lessonid={$item['lessonid']}");
            }
            elseif($order['ordertype'] == 'recharge')
            {
                header("location:../index.php?finance-agent-basics");
            }
            exit;
        }
        else
        {
            //
        }
    }
}

?>