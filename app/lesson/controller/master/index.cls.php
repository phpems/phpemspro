<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace lesson\controller\master;

class index
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        \tpl::getInstance()->display('index');
    }
}