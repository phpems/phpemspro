<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace finance\controller\agent;

use exam\model\exams;
use exam\model\points;
use exam\model\training;
use user\model\users;

class basics
{
    public function __construct()
    {
        $this->trainings = training::getTrainingsByArgs();
        \tpl::getInstance()->assign('trainings',$this->trainings);
        $this->user = users::getUserByUsername(\finance\agent::$_user['sessionusername']);
        $this->rate = $this->user['userrate']/100;
        if($this->rate < 0)$rate = 1;
        if($this->rate > 1)$rate = 1;
    }

    public function cancel()
    {
        if((TIME - $_SESSION['onlytime']) < 1)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "请勿多次提交"
            );
            \route::urlJump($message);
        }
        $_SESSION['onlytime'] = TIME;
        $ordersn = \route::get('ordersn');
        $order = \finance\model\orders::getOrderBySn($ordersn);
        if($order['ordersn'])
        {
            if(TIME - strtotime($order['ordertime']) > 432000)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => '该订单已下单超过5天，不能退款！'
                );
                \route::urlJump($message);
            }
            if(strtotime($order['orderactivetime']) || $order['orderstatus'] != 2)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => '该订单未付款或已经激活使用，不能退款！'
                );
                \route::urlJump($message);
            }
            $coin = $this->user['usercoin'] + $order['orderprice'];
            users::modifyUser($this->user['userid'],array('usercoin' => $coin));
            \finance\model\orders::modifyOrder($ordersn,array('orderstatus' => 99));
            $actives = \finance\model\orders::getActivesByArgs(array(array("AND","activeorder = :activeorder","activeorder",$ordersn),array("AND","activestatus = 1")));
            if($actives)
            {
                foreach($actives as $active)
                {
                    $daytime = $active['activetime'] * 3600 * 24;
                    $subject = points::getSubjectById($active['activesubjectid']);
                    $r = \exam\model\exams::getIsMember($subject['subjectdb'],$active['activeusername'],$active['activebasicid']);
                    $endtime = strtotime($r['obendtime']);
                    if($endtime && $endtime > TIME)
                    {
                        $obendtime = $endtime - $daytime;
                        if($obendtime < TIME)$obendtime = TIME;
                        \exam\model\exams::modifyBasicMember($subject['subjectdb'],$r['obid'],array("obendtime" => $obendtime));
                    }
                }
            }
            $query = array(array("AND","activeorder = :activeorder","activeorder",$ordersn));
            \finance\model\orders::modifyActives($query,array('activestatus' => 99));
        }
        $message = array(
            'statusCode' => 200,
            "message" => '取消成功',
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        \route::urlJump($message);
    }

    public function openpackage()
    {
        if((TIME - $_SESSION['onlytime']) < 1)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "请勿多次提交"
            );
            \route::urlJump($message);
        }
        $_SESSION['onlytime'] = TIME;
        $userphone = \route::get('phonenumber');
        $userrealname = \route::get('name');
        $useremail = \route::get('email').'@qq.com';
        $u = users::getUserByPhone($userphone);
        if(!$u['userid'])
        {
            $u = users::getUserByEmail($useremail);
            if($u['userid'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "邮箱已被其他用户注册，请更换邮箱"
                );
                \route::urlJump($message);
            }
            else
            {
                $args = array(
                    'username' => $userphone,
                    'userphone' => $userphone,
                    'useremail' => $useremail,
                    'userrealname' => $userrealname,
                    'userpassword' => 'biguotiku100'
                );
                $group = users::getDefaultGroup();
                $args['usergroupcode'] = $group['groupcode'];
                users::addUser($args);
            }
        }

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
                    'price' => floatval($tmp[3]) * $this->rate
                );
                $prices[] = $price;
            }
        }

        $paytype = \route::get('paytype');
        $opentype = intval(\route::get('opentype'));
        $args = array();
        $args['orderprice'] = floatval($prices[$opentype]['price']);
        if($this->user['usercoin'] < $args['orderprice'])
        {
            $message = array(
                'statusCode' => 300,
                "message" => "余额不足，请充值"
            );
            \route::urlJump($message);
        }
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
        $args['orderusername'] = $userphone;
        $args['ordertime'] = TIME;
        $args['ordertype'] = 'exam';
        $args['orderagent'] = $this->user['username'];
        $args['orderstatus'] = 2;
        $args['orderactive'] = 0;
        \finance\model\orders::addOrder($args);
        $coin = $this->user['usercoin'] - $args['orderprice'];
        users::modifyUser($this->user['userid'],array('usercoin' => $coin));
        $message = array(
            'statusCode' => 200,
            "message" => '购买成功',
            "callbackType" => "forward",
            "forwardUrl" => "index.php?finance-agent-orders"
        );
        \route::urlJump($message);
    }

    public function openbasic()
    {
        if((TIME - $_SESSION['onlytime']) < 1)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "请勿多次提交"
            );
            \route::urlJump($message);
        }
        $_SESSION['onlytime'] = TIME;
        $userphone = \route::get('phonenumber');
        $userrealname = \route::get('name');
        $useremail = \route::get('email').'@qq.com';
        $u = users::getUserByPhone($userphone);
        if(!$u['userid'])
        {
            $u = users::getUserByEmail($useremail);
            if($u['userid'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "邮箱已被其他用户注册，请更换邮箱"
                );
                \route::urlJump($message);
            }
            else
            {
                $args = array(
                    'username' => $userphone,
                    'userphone' => $userphone,
                    'useremail' => $useremail,
                    'userrealname' => $userrealname,
                    'userpassword' => 'biguotiku100'
                );
                $group = users::getDefaultGroup();
                $args['usergroupcode'] = $group['groupcode'];
                users::addUser($args);
            }
        }

        $prices = 0;
        $subjectid = \route::get('subjectid');
        $basicid = \route::get('basicid');
        $subject = points::getSubjectById($subjectid);
        $basic = exams::getBasicById($subject['subjectdb'],$basicid);
        if(trim($basic['basicprice']))
        {
            $prices = array();
            $basic['basicprice'] = explode("\n",$basic['basicprice']);
            foreach($basic['basicprice'] as $p)
            {
                if($p)
                {
                    $p = explode(":",$p);
                    $prices[] = array('name'=>$p[0],'time'=>$p[1],'price'=>floatval($p[2]) * $this->rate);
                }
            }
            \tpl::getInstance()->assign('prices',$prices);
        }
        $paytype = \route::get('paytype');
        $opentype = intval(\route::get('opentype'));
        $args = array();
        $args['orderprice'] = floatval($prices[$opentype]['price']);
        $args['ordername'] = "{$basic['basic']}{$prices[$opentype]['name']}";
        $args['orderitems'] = array(
            array(
                'subjectid' => $subject['subjectid'],
                'basicid' => $basic['basicid'],
                'basicname' => $basic['basic'],
                'time' => $prices[$opentype]['time'],
                'price' => $prices[$opentype]['price']
            )
        );
        $args['ordersn'] = date('YmdHi').rand(100,999);
        $args['orderusername'] = $userphone;
        $args['ordertime'] = TIME;
        $args['ordertype'] = 'exam';
        $args['orderagent'] = $this->user['username'];
        $args['orderstatus'] = 2;
        $args['orderactive'] = 0;
        \finance\model\orders::addOrder($args);
        $coin = $this->user['usercoin'] - $args['orderprice'];
        users::modifyUser($this->user['userid'],array('usercoin' => $coin));
        $message = array(
            'statusCode' => 200,
            "message" => '购买成功',
            "callbackType" => "forward",
            "forwardUrl" => "index.php?finance-agent-orders"
        );
        \route::urlJump($message);
    }

    public function recharge()
    {
        if(\route::get('recharge'))
        {
            $money = \route::get('money');
            if($money < 1)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "最低充值1元"
                );
                \route::urlJump($message);
            }
            $money = round($money,2);
            $args = array();
            $args['orderprice'] = $money;
            $args['ordername'] = '代理充值'.$money.'元';
            $args['orderitems'] = array();
            $args['ordersn'] = date('YmdHi').rand(100,999);
            $args['orderstatus'] = 1;
            $args['orderusername'] = \finance\agent::$_user['sessionusername'];
            $args['ordertime'] = TIME;
            $args['ordertype'] = 'recharge';
            \finance\model\orders::addOrder($args);
            $payforurl = \alipay::getInstance()->createPagePayLink($args);
            $message = array(
                'statusCode' => 201,
                "message" => "下单成功！",
                "callbackType" => "forward",
                "forwardUrl" => $payforurl
            );
            \route::urlJump($message);
        }
        else
        \tpl::getInstance()->display('recharge');
    }

    public function index()
    {
        $trid = \route::get('trid');
        if(!$trid)$trid = current($this->trainings)['trid'];
        $training = $this->trainings[$trid];
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
                    'price' => floatval($tmp[3]),
                    'agentprice' => floatval($tmp[3]) * $this->rate
                );
                $prices[] = $price;
            }
        }
        $bprices = array();
        $subjects = points::getSubjects(array(array("AND","subjecttrid = :trid","trid",$training['trid'])));
        foreach($subjects as $subject)
        {
            $basics[$subject['subjectid']] = exams::getBasicsByArgs($subject['subjectdb'],array(array("AND","basicsubject = :basicsubject","basicsubject",$subject['subjectid'])));
            foreach($basics[$subject['subjectid']] as $basic)
            {

                $price = explode("\n",$basic['basicprice']);
                foreach($price as $p)
                {
                    if($p)
                    {
                        $p = explode(":",$p);
                        $bprices[$basic['basicid']][] = array('name'=>$p[0],'time'=>$p[1],'price'=>floatval($p[2]),'agentprice' => floatval($p[2]) * $this->rate);
                    }
                }
            }
        }
        \tpl::getInstance()->assign('subjects',$subjects);
        \tpl::getInstance()->assign('basics',$basics);
        \tpl::getInstance()->assign('bprices',$bprices);
        \tpl::getInstance()->assign('training',$training);
        \tpl::getInstance()->assign('bprices',$bprices);
        \tpl::getInstance()->assign('prices',$prices);
        \tpl::getInstance()->assign('trid',$trid);
        \tpl::getInstance()->display('basics');
    }
}