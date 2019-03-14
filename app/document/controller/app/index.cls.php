<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace core\controller\app;

class index
{
    public function __construct()
    {
        //
    }

    public function index()
    {
		$session = \session::getInstance('demo');
		echo $session->parm;
    }
}