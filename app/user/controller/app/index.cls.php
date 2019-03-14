<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace user\controller\app;

class index
{
    public function __construct()
    {
        $this->_user = \session::getInstance()->getSessionUser();
        if(!$this->_user['sessionuserid'])
        {
            $message = array(
                'statusCode' => 300,
                "message" => "请您先登陆",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?user-app-login"
            );
            \route::urlJump($message);
        }
    }

    public function index()
    {
		header("location:index.php?user-app-user");
		exit;
    }
}