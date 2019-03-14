<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/12/8
 * Time: 10:47
 */

namespace lesson\controller\master;

class ajax
{

    public function getchildcategory()
    {
        $catid = \route::get('catid');
        $out = '';
        if($catid)
        {
            $child = \core\model\category::getCategoriesByArgs(array(array("AND","catparent = :catparent",':catparent',$catid)));
            foreach($child as $c)
            {
                $out .= '<option value="'.$c['catid'].'">'.$c['catname'].'</option>';
            }
        }
        if($out)
        {
            $message = array(
                'statusCode' => 200,
                "html" => $out
            );
            exit(json_encode($message));
        }
        else
        {
            $message = array(
                'statusCode' => 300
            );
            exit(json_encode($message));
        }
    }

    public function index()
    {
        return;
    }
}