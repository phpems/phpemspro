<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\controller\mobile;

use exam\model\exams;
use exam\model\points;
use exam\model\training;
use exam\model\favor;
use exam\model\question;
use finance\model\orders;

class basic
{
    public function __construct()
    {
        if(!\exam\mobile::$_user['currentsubject'])
        {
            $message = array(
                'statusCode' => 300,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?content-mobile"
            );
            \route::urlJump($message);
        }
        $this->subject = points::getSubjectById(\exam\mobile::$_user['currentsubject']);
        $this->basic = exams::getBasicById($this->subject['subjectdb'],\exam\mobile::$_user['currentbasic']);
        $this->status = exams::getIsMember($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername'],\exam\mobile::$_user['currentbasic']);
        if(strtotime($this->status['obendtime']) >= TIME)
        {
            $this->status['status'] = true;
        }
        \tpl::getInstance()->assign('subject',$this->subject);
        \tpl::getInstance()->assign('basic',$this->basic);
        \tpl::getInstance()->assign('status',$this->status);
        if($this->basic['basicexam']['model'] == 2)
        {
            $message = array(
                'statusCode' => 200,
                "callbackType" => "forward",
                "forwardUrl" => "index.php?exam-mobile-exam"
            );
            \route::urlJump($message);
        }
    }

    public function package()
    {
        $trid = \route::get('trid');
        $training = training::getTrainingById($trid);
        $package = trim($training['trpackage']);
        $packprice = explode("\n",$package);
        $prices = array();
        foreach($packprice as $p)
        {
            $tmp = explode(':',$p);
            if($tmp[3])
            {
                $price = array(
                    'name' => $tmp[0],
                    'package' => $tmp[1],
                    'time' => $tmp[2],
                    'price' => $tmp[3]
                );
                $prices[] = $price;
            }
        }
        if(\route::get('openbasic'))
        {
            $paytype = \route::get('paytype');
            $opentype = intval(\route::get('opentype'));
            if(\route::isWeixin())
            {
                $paytype = 'wxpay';
            }
            $args = array();
            $args['orderprice'] = floatval($prices[$opentype]['price']);
            $args['ordername'] = $prices[$opentype]['name'];
            $prices[$opentype]['package'] = explode(',',trim($prices[$opentype]['package']));
            $args['orderitems'] = array();
            foreach($prices[$opentype]['package'] as $pack)
            {
                $pk = explode('-',$pack);
                $subject = points::getSubjectById($pk[0]);
                $basic = exams::getBasicById($subject['subjectdb'],$pk[1]);
                $args['orderitems'][] = array(
                    'subjectid' => $pk[0],
                    'basicid' => $pk[1],
                    'basicname' => $basic['basic'],
                    'time' => $prices[$opentype]['time']
                );
            }
            $args['ordersn'] = date('YmdHi').rand(100,999);
            $args['orderstatus'] = 1;
            $args['orderusername'] = \exam\mobile::$_user['sessionusername'];
            $args['ordertime'] = TIME;
            $args['ordertype'] = 'exam';
            orders::addOrder($args);
            if($paytype == 'wxpay')
            {
                if(\route::isMobile())
                {
                    if (\route::isWeixin())
                    {
                        $message = array(
                            'statusCode' => 200,
                            "message" => "下单成功！",
                            "callbackType" => "forward",
                            "forwardUrl" => 'index.php?user-mobile-user-wxpay&ordersn='.$args['ordersn']
                        );
                        \route::urlJump($message);
                    }
                    else
                    {
                        $result = \wxpay::getInstance()->outMwebUrl($args);
                        $message = array(
                            'statusCode' => 201,
                            "message" => "下单成功！",
                            "callbackType" => "forward",
                            //"forwardUrl" => 'index.php?user-mobile-user-wxh5pay&ordersn='.$args['ordersn']
                            "forwardUrl" => $result['mweb_url']
                        );
                        \route::urlJump($message);
                    }
                }
                else
                {
                    $message = array(
                        'statusCode' => 200,
                        "message" => "下单成功！",
                        "callbackType" => "forward",
                        "forwardUrl" => 'index.php?user-mobile-user-wxpay&ordersn='.$args['ordersn']
                    );
                    \route::urlJump($message);
                }
            }
            else
            {
                if(\route::isMobile())
                {
                    $payforurl = \alipay::getInstance()->createWapPayLink($args);
                    $message = array(
                        'statusCode' => 201,
                        "message" => "下单成功！",
                        "callbackType" => "forward",
                        "forwardUrl" => $payforurl
                    );
                    \route::urlJump($message);
                }
                else
                {
                    $payforurl = \alipay::getInstance()->createPagePayLink($args);
                    $message = array(
                        'statusCode' => 201,
                        "message" => "下单成功！",
                        "callbackType" => "forward",
                        "forwardUrl" => $payforurl
                    );
                    \route::urlJump($message);
                }
            }
        }
        else
        {
            \tpl::getInstance()->assign('prices',$prices);
            \tpl::getInstance()->assign('training',$training);
            \tpl::getInstance()->display('basic_package');
        }
    }

    public function open()
    {
        $prices = 0;
        if(trim($this->basic['basicprice']))
        {
            $prices = array();
            $this->basic['basicprice'] = explode("\n",$this->basic['basicprice']);
            foreach($this->basic['basicprice'] as $p)
            {
                if($p)
                {
                    $p = explode(":",$p);
                    $prices[] = array('name'=>$p[0],'time'=>$p[1],'price'=>floatval($p[2]));
                }
            }
            \tpl::getInstance()->assign('prices',$prices);
        }
        if(\route::get('openbasic'))
        {
            $paytype = \route::get('paytype');
            $opentype = intval(\route::get('opentype'));
            if(\route::isWeixin())
            {
                $paytype = 'wxpay';
            }
            $args = array();
            $args['orderprice'] = floatval($prices[$opentype]['price']);
            $args['ordername'] = "{$this->basic['basic']}{$prices[$opentype]['name']}";
            $args['orderitems'] = array(
                array(
                    'subjectid' => $this->subject['subjectid'],
                    'basicid' => $this->basic['basicid'],
                    'basicname' => $this->basic['basic'],
                    'time' => $prices[$opentype]['time'],
                    'price' => $prices[$opentype]['price']
                )
            );
            $args['ordersn'] = date('YmdHi').rand(100,999);
            $args['orderstatus'] = 1;
            $args['orderusername'] = \exam\mobile::$_user['sessionusername'];
            $args['ordertime'] = TIME;
            $args['ordertype'] = 'exam';
            orders::addOrder($args);
            if($paytype == 'wxpay')
            {
                if(\route::isMobile())
                {
                    if (\route::isWeixin())
                    {
                        $message = array(
                            'statusCode' => 200,
                            "message" => "下单成功！",
                            "callbackType" => "forward",
                            "forwardUrl" => 'index.php?user-mobile-user-wxpay&ordersn='.$args['ordersn']
                        );
                        \route::urlJump($message);
                    }
                    else
                    {
                        $result = \wxpay::getInstance()->outMwebUrl($args);
                        $message = array(
                            'statusCode' => 201,
                            "message" => "下单成功！",
                            "callbackType" => "forward",
                            //"forwardUrl" => 'index.php?user-mobile-user-wxh5pay&ordersn='.$args['ordersn']
                            "forwardUrl" => $result['mweb_url']
                        );
                        \route::urlJump($message);
                    }
                }
                else
                {
                    $message = array(
                        'statusCode' => 200,
                        "message" => "下单成功！",
                        "callbackType" => "forward",
                        "forwardUrl" => 'index.php?user-mobile-user-wxpay&ordersn='.$args['ordersn']
                    );
                    \route::urlJump($message);
                }
            }
            else
            {
                if(\route::isMobile())
                {
                    $payforurl = \alipay::getInstance()->createWapPayLink($args);
                    $message = array(
                        'statusCode' => 201,
                        "message" => "下单成功！",
                        "callbackType" => "forward",
                        "forwardUrl" => $payforurl
                    );
                    \route::urlJump($message);
                }
                else
                {
                    $payforurl = \alipay::getInstance()->createPagePayLink($args);
                    $message = array(
                        'statusCode' => 201,
                        "message" => "下单成功！",
                        "callbackType" => "forward",
                        "forwardUrl" => $payforurl
                    );
                    \route::urlJump($message);
                }
            }
        }
        else
        {
            $training = training::getTrainingById($this->subject['subjecttrid']);
            $package = trim($training['trpackage']);
            $packprice = explode("\n",$package);
            $package = null;
            $lestprice = 0;
            foreach($packprice as $p)
            {
                $tmp = explode(':',$p);
                if($tmp[3])
                {
                    $price = array(
                        'name' => $tmp[0],
                        'package' => $tmp[1],
                        'time' => $tmp[2],
                        'price' => $tmp[3]
                    );
                    $package[] = $price;
                    if(!$lestprice){
                        $lestprice = $price['price'];
                    }
                    else{
                        if($lestprice > $price['price']){
                            $lestprice = $price['price'];
                        }
                    }
                }
            }
            \tpl::getInstance()->assign('lestprice',$lestprice);
            \tpl::getInstance()->assign('package',$package);
            \tpl::getInstance()->display('basic_open');
        }
    }

    public function index()
    {
        $points = points::getPointsBySubjectid($this->subject['subjectid']);
        $sections = $points['sections'];
        $points = $points['points'];
        $record = favor::getRecordSession($this->subject['subjectdb'],\exam\mobile::$_user['sessionusername']);
        $lastquestion = json_decode(\pedis::getInstance()->getHashData('lastquestion',\exam\mobile::$_user['sessionusername'].'-'.\exam\mobile::$_user['currentbasic']),true);
        $pointid = key($lastquestion);
        $index = $lastquestion[$pointid];
        $wrong = array();
        $right = array();
        $favor = array();
        $note = array();
        $numbers = array();
        foreach($points as $key => $point)
        {
            $rt = 0;
            $wg = 0;
            foreach($point as $p)
            {
                if($this->basic['basicpoints'][$key][$p['pointid']])
                {
                    $numbers[$p['pointid']] = question::getQuestionNumberByPointid($this->subject['subjectdb'],$p['pointid']);
                    $favor[$key] += intval(\pedis::getInstance()->getHashData('favornumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p['pointid']));
                    $note[$key] += intval(\pedis::getInstance()->getHashData('notenumber',\exam\mobile::$_user['sessionusername'].'-'.$this->subject['subjectdb'].'-'.$p['pointid']));
                    $rt += $record['recordnumber'][$p['pointid']]['right'];
                    $wg += $record['recordnumber'][$p['pointid']]['wrong'];
                    if($p['pointid'] == $pointid)
                    {
                        $thispoint = $p;
                    }
                }
            }
            $wrong[$key] = intval($wg);
            $right[$key] = intval($rt);
        }
        unset($record);
        \tpl::getInstance()->assign('sections',$sections);
        \tpl::getInstance()->assign('allnumber',array('right' => array_sum($right),'wrong' => array_sum($wrong),'all' => array_sum($numbers)));
        \tpl::getInstance()->assign('wrong',$wrong);
        \tpl::getInstance()->assign('favor',$favor);
        \tpl::getInstance()->assign('note',$note);
        \tpl::getInstance()->assign('points',$points);
        \tpl::getInstance()->assign('point',$thispoint);
        \tpl::getInstance()->assign('index',$index+1);
        \tpl::getInstance()->display('basic');
    }
}