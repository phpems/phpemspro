<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/25
 * Time: 21:24
 */

namespace user\controller\master;

class groups
{
    public function __construct()
    {
        $search = \route::get('search');
        if($search)
        {
            $this->u = '';
            $this->search = $search;
            $this->tpl->assign('search',$search);
            foreach($search as $key => $arg)
            {
                $this->u .= "&search[{$key}]={$arg}";
            }
            unset($search);
        }
    }

    public function add()
    {
        if(\route::get('addgroup'))
        {
            $args = \route::get('args');
            $group = \user\model\users::getGroupByCode($args['groupcode']);
            if($group)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "操作成功"
                );
                exit(json_encode($message));
            }
            $id = \user\model\users::addGroup($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?user-master-groups"
            );
            exit(json_encode($message));
        }
        else
        {
            $models = \database\model\model::getModelsByApp(\route::getUrl('app'));
            \tpl::getInstance()->assign('models',$models);
            \tpl::getInstance()->display('groups_add');
        }
    }

    public function modify()
    {
        $groupid = \route::get('groupid');
        $group = \user\model\users::getGroupById($groupid);
        if(\route::get('modifygroup'))
        {
            $args = \route::get('args');
            \user\model\users::modifyGroup($groupid,$args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            $models = \database\model\model::getModelsByApp(\route::getUrl('app'));
            \tpl::getInstance()->assign('group',$group);
            \tpl::getInstance()->assign('models',$models);
            \tpl::getInstance()->display('groups_modify');
        }
    }

    public function setdefault()
    {
        $groupid = \route::get('groupid');
        \user\model\users::setDefaultGroup($groupid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function del()
    {
        $groupid = \route::get('groupid');
        $group = \user\model\users::getGroupById($groupid);
        if($group)
        {
            $args = array(
                array("AND","usergroupcode = :usergroupcode","usergroupcode",$group['groupcode'])
            );
            if(\user\model\users::getUserNumberByArgs($groupid))
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "删除失败，请先删除本用户组所有用户"
                );
                exit(json_encode($message));
            }
            \user\model\users::delGroup($groupid);
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function index()
    {
        $groups = \user\model\users::getGroups();
        \tpl::getInstance()->assign('groups',$groups);
        \tpl::getInstance()->display('groups');
    }
}