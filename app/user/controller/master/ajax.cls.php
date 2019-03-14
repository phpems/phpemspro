<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/12/8
 * Time: 10:47
 */

namespace user\controller\master;


class ajax
{
    static public function getGroupsByModelCode()
    {
        $modelcode = \route::get('modelcode');
        $groups = \user\model\users::getGroupsByModelCode($modelcode);
        foreach ($groups as $p) {
            echo "<option value='{$p['groupcode']}'>{$p['groupname']}</option>";
        }
        return;
    }

    static public function index()
    {
        return;
    }
}