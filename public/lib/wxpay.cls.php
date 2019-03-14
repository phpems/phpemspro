<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2019/1/14
 * Time: 21:16
 */

require_once PEP_PATH."/public/vendor/wechat/WxPay.Config.Interface.php";
require_once PEP_PATH."/public/vendor/wechat/WxPay.Config.php";
require_once PEP_PATH."/public/vendor/wechat/WxPay.Exception.php";
require_once PEP_PATH."/public/vendor/wechat/WxPay.Data.php";
require_once PEP_PATH."/public/vendor/wechat/WxPay.Api.php";
require_once PEP_PATH."/public/vendor/wechat/WxPay.Notify.php";
require_once PEP_PATH."/public/vendor/wechat/WxPay.JsApiPay.php";


class wxpay extends WxPayNotify
{
    static $instance;

    static function getInstance()
    {
        if(self::$instance == NULL)
        {
            self::$instance = new static();//亦可写为 new self();
        }
        return self::$instance;
    }

    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $config = new WxPayConfig();
        $result = WxPayApi::orderQuery($config, $input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($objData,$config,&$msg)
    {
        $data = $objData->GetValues();
        //TODO 1、进行参数校验
        if(!array_key_exists("return_code", $data) ||(array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS"))
        {
            //TODO失败,不是支付成功的通知
            //如果有需要可以做失败时候的一些清理处理，并且做一些监控
            $msg = "异常异常";
            return false;
        }
        if(!array_key_exists("transaction_id", $data))
        {
            $msg = "输入参数不正确";
            return false;
        }
        //TODO 2、进行签名验证
        try {
            $checkResult = $objData->CheckSign($config);
            if($checkResult == false){
                //签名错误
                return false;
            }
        } catch(Exception $e) {
            //
        }
        //TODO 3、处理业务逻辑
        $notfiyOutput = array();
        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }

        $ordersn = $data["out_trade_no"];
        $order = \finance\model\orders::getOrderBySn($ordersn);
        if($order && $order['orderstatus'] != 2)
        {
            \finance\model\orders::modifyOrder($order['ordersn'],array('orderstatus' => 2,'orderpaytype' => 'wxpay'));
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
        return true;
    }

    public function getwxopenid()
    {
        if(!$_SESSION['openid'])
        {
            $tools = new JsApiPay();
            $_SESSION['openid'] = $tools->GetOpenid();
        }
        return $_SESSION['openid'];
    }

    public function outJsPay($order)
    {
        $openid = $this->getwxopenid();
        $tools = new JsApiPay();
        $config = new WxPayConfig();
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order['ordername']);
        $input->SetAttach("购买课程、题库");
        $input->SetOut_trade_no($order['ordersn']);
        $input->SetTotal_fee(intval($order['orderprice'] * 100));
        //$input->SetTotal_fee(intval($order['orderprice']));
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url(\config::webpath."api/wxnotify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openid);
        $order = WxPayApi::unifiedOrder($config,$input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        return $jsApiParameters;
    }

/*    public function GetPrePayUrl($productId)
    {
        $biz = new WxPayBizPayUrl();
        $biz->SetProduct_id($productId);
        $values = WxpayApi::bizpayurl($biz);
        $url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
        return $url;
    }

    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    public function outUrl1($order)
    {
        return $this->GetPrePayUrl($order['ordersn']);
    }*/

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param UnifiedOrderInput $input
     */
    public function GetPayUrl($input)
    {
        if($input->GetTrade_type() == "NATIVE" || $input->GetTrade_type() == "MWEB")
        {
            $result = WxPayApi::unifiedOrder(new WxPayConfig(),$input);
            return $result;
        }
    }

    public function outQrcodeUrl($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order['ordername']);
        $input->SetAttach("购买课程、题库");
        //$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetOut_trade_no($order['ordersn']);
        $price = intval($order['orderprice']*100);
        $input->SetTotal_fee($price);
        //$input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($order['ordername']);
        $input->SetNotify_url(\config::webpath."api/wxnotify.php");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($order['ordersn']);
        $result = $this->GetPayUrl($input);
        return $result;
    }

    public function outMwebUrl($order)
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order['ordername']);
        $input->SetAttach("购买课程、题库");
        $input->SetOut_trade_no($order['ordersn']);
        $price = intval($order['orderprice']*100);
        $input->SetTotal_fee($price);
        //$input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($order['ordername']);
        $input->SetNotify_url(\config::webpath."api/wxnotify.php");
        $input->SetTrade_type("MWEB");
        $input->SetProduct_id($order['ordersn']);
        $result = $this->GetPayUrl($input);
        return $result;
    }
}

?>