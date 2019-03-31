<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace user\controller\mobile;

class user
{
    public function __construct()
    {
        //
    }

    public function wxpay()
    {
        $ordersn = \route::get('ordersn');
        $order = \finance\model\orders::getOrderBySn($ordersn);
        if($order['orderstatus'] == 1)
        {
            $jsApiParameters = \wxpay::getInstance()->outJsPay($order);
            \tpl::getInstance()->assign('jsApiParameters',$jsApiParameters);
        }
        \tpl::getInstance()->assign('order',$order);
        \tpl::getInstance()->display('wxpay');
    }

    public function password()
    {
        if(\route::get('modifypassword'))
        {
            $oldpassword = \route::get('oldpassword');
            $newpassword = \route::get('newpassword');
            $userid = \user\mobile::$_user['sessionuserid'];
            $user = \user\model\users::getUserById($userid);
            if(md5($oldpassword) != $user['userpassword'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "操作失败，原密码验证失败"
                );
                \route::urlJump($message);
            }
            if($userid)
            {
                $id = \user\model\users::modifyUser($userid,array('userpassword' => $newpassword));
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功",
                    "callbackType" => 'forward',
                    "forwardUrl" => "index.php?user-mobile-login-logout"
                );
                \route::urlJump($message);
            }
            else
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "操作失败"
                );
                \route::urlJump($message);
            }
        }
        else
        {
            \tpl::getInstance()->display('user_password');
        }
    }

    public function index()
    {
        $user = \user\model\users::getUserById(\user\mobile::$_user['sessionuserid']);
        $group = \user\model\users::getGroupByCode($user['usergroupcode']);
        $modelcode = $group['groupmodel'];
        if(\route::get('modifyuser'))
        {
            $args = \route::get('args');
            if(!$args['userpassword'])unset($args['userpassword']);
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode);
            $args = \database\model\model::callModelFieldsFilter($args,$properties);
            \user\model\users::modifyUser($user['userid'],$args);
            $message = array(
                'statusCode' => 200,
                "message" => "修改成功"
            );
            exit(json_encode($message));
        }
        else
        {
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode);
            unset($user['userpassword']);
            $forms = \html::buildHtml($properties,$user);
            \tpl::getInstance()->assign('user',$user);
            \tpl::getInstance()->assign('forms',$forms);
            \tpl::getInstance()->display('user');
        }
    }
}