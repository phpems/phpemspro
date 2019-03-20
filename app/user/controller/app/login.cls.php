<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/12/7
 * Time: 10:50
 */

namespace user\controller\app;

use core\model\apps;
use user\model\users;
class login
{
    public function __construct()
    {
        //
    }

    public function logout()
    {
        \session::getInstance()->clearSessionUser();
        $message = array(
            'statusCode' => 200,
            "message" => "退出成功",
            "callbackType" => "forward",
            "forwardUrl" => "index.php?content-app",
            'callback' => 'cleardata'
        );
        \route::urlJump($message);
    }

    public function findpassword()
    {
        if(\route::get('userfindpassword'))
        {
            $randcode = \route::get('randcode');
            $args = \route::get('args');
            $phone = $args['userphone'];
            if((!$randcode) || ($randcode != $_SESSION['phonerandcode']['findpassword']) || ($phone != $_SESSION['phonerandcode']['findpasswordphonenumber']))
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "验证码错误"
                );
                exit(json_encode($message));
            }
            else
            {
                $_SESSION['phonerandcode']['findpassword'] = 0;
            }
            $user = users::getUserByPhone($phone);
            if(!$user)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "手机号未注册"
                );
                exit(json_encode($message));
            }
            $password = $args['userpassword'];
            users::modifyUser($user['userid'],array('userpassword' => $password));
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => 'forward',
                "forwardUrl" => "back"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->display('login_findpassword');
        }
    }

    public function register()
    {
        if(\route::get('userregister'))
        {
            $app = apps::getAppByCode('user');
            if($app['appsetting']['closeregist'])
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "管理员禁止了用户注册"
                );
                $this->G->R($message);
            }
            $fob = array('admin','管理员','站长');
            $args = \route::get('args');
            if(!$args['username'])
            {
                $args['username'] = $args['userphone'];
            }
            $defaultgroup = users::getDefaultGroup();
            if(!$defaultgroup['groupid'] || !trim($args['username']))
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "用户不能注册"
                );
                exit(json_encode($message));
            }
            $randcode = \route::get('randcode');
            if((!$randcode) || ($randcode != $_SESSION['phonerandcode']['reg']) || ($args['userphone'] != $_SESSION['phonerandcode']['regphonenumber']))
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "验证码错误"
                );
                exit(json_encode($message));
            }
            else
            {
                $_SESSION['phonerandcode']['reg'] = 0;
            }
            $username = $args['username'];
            foreach($fob as $f)
            {
                if(strpos($username,$f) !== false)
                {
                    $message = array(
                        'statusCode' => 300,
                        'errorinput' => 'args[username]',
                        "message" => "用户已经存在"
                    );
                    exit(json_encode($message));
                }
            }
            $user = users::getUserByUserName($username);
            if($user)
            {
                $message = array(
                    'statusCode' => 300,
                    'errorinput' => 'args[username]',
                    "message" => "用户已经存在"
                );
                exit(json_encode($message));
            }
            $email = $args['useremail'];
            $user = users::getUserByEmail($email);
            if($user)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "邮箱已经被注册"
                );
                exit(json_encode($message));
            }
            $phone = $args['userphone'];
            $user = users::getUserByPhone($phone);
            if($user)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "手机号已经被注册"
                );
                exit(json_encode($message));
            }
            $fargs = array('username' => $username,'userphone' => $phone,'usergroupcode' => $defaultgroup['groupcode'],'userpassword' => $args['userpassword'],'useremail' => $email);
            $id = users::addUser($fargs);
            \session::getInstance()->setSessionUser(array('sessionuserid'=>$id,'sessionpassword'=>md5($args['userpassword']),'sessionip'=>\route::getClientIp(),'sessiongroupid'=>$defaultgroup['groupid'],'sessionlogintime'=>TIME,'sessionusername'=>$username));
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => 'forward',
                "forwardUrl" => "index.php?content-app"
            );
            exit(json_encode($message));
        }
        else
        {
            \tpl::getInstance()->display('login_register');
        }
    }

    public function index()
    {
        if(\route::get('userlogin'))
        {
            $args = \route::get('args');
            $user = \user\model\users::getUserByUsername($args['username']);
            if($user)
            {
                if($user['userpassword'] == md5($args['userpassword']))
                {
                    $sessionuser = array(
                        'sessionuserid' => $user['userid'],
                        'sessionusername' => $user['username'],
                        'sessionpassword' => $user['userpassword'],
                        'sessiongroupcode' => $user['usergroupcode']
                    );
                    \session::getInstance()->setSessionUser($sessionuser);
                    $message = array(
                        'statusCode' => 200,
                        "message" => "登陆成功",
                        "callbackType" => "forward",
                        "forwardUrl" => "index.php?content-app",
                        'callback' => 'cleardata'
                    );
                    \route::urlJump($message);
                }
            }
            $message = array(
                'statusCode' => 300,
                "message" => "用户名或密码错误"
            );
            \route::urlJump($message);
        }
        else
        {
            \tpl::getInstance()->display('login');
        }
    }
}