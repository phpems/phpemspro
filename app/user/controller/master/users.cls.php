<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/25
 * Time: 21:24
 */

namespace user\controller\master;

use database\model\model;

class users
{
    public function __construct()
    {
        $search = \route::get('search');
        if($search)
        {
            $this->u = '';
            $this->search = $search;
            \tpl::getInstance()->assign('search',$search);
            foreach($search as $key => $arg)
            {
                $this->u .= "&search[{$key}]={$arg}";
            }
            unset($search);
        }
    }

    static function import()
    {
        if(\route::get('insertUser'))
        {
            $uploadfile = \route::get('uploadfile');
            if(!file_exists($uploadfile))
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "上传文件不存在"
                );
                exit(json_encode($message));
            }
            else
            {
                setlocale(LC_ALL,'zh_CN');
                $handle = fopen($uploadfile,"r");
                $defaultgroup = \user\model\users::getDefaultGroup();
                $app = \core\model\apps::getAppByCode('user');
                $tpfields = explode(',',$app['appsetting']['regfields']);
                while ($data = fgetcsv($handle,200))
                {
                    if($data[0] && $data[1])
                    {
                        $args = array();
                        $args['username'] = iconv("GBK","UTF-8",$data[0]);
                        if(\strings::isUserName($args['username']))
                        {
                            $u = \user\model\users::getUserByUserName($args['username']);
                            if(!$u)
                            {
                                $args['userphone'] = $data[1];
                                if(\strings::isCellphone($args['userphone']))
                                {
                                    $u = \user\model\users::getUserByPhone($args['userphone']);
                                    if(!$u)
                                    {
                                        $args['useremail'] = $data[2];
                                        if(!$data[3])$data[3] = '111111';
                                        $args['userpassword'] = md5($data[3]);
                                        $args['usergroupcode'] = $defaultgroup['groupcode'];
                                        $i = 4;
                                        foreach($tpfields as $p)
                                        {
                                            $args[$p] = iconv("GBK","UTF-8",$data[$i]);
                                            $i++;
                                        }
                                        \user\model\users::addUser($args);
                                    }
                                }
                            }
                        }
                    }
                }
                fclose($handle);
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功",
                    "callbackType" => "forward",
                    "forwardUrl" => "index.php?user-master-users"
                );
                exit(json_encode($message));
            }
        }
        else
        {
            \tpl::getInstance()->display('users_import');
        }
    }

    public function add()
    {
        if(\route::get('adduser'))
        {
            $args = \route::get('args');
            $u = \user\model\users::getUserByUsername($args['username']);
            print_r($u);
            if($u)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "这个用户名已经存在"
                );
                exit(json_encode($message));
            }
            $u = \user\model\users::getUserByEmail($args['useremail']);
            if($u)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "这个邮箱已经被注册了"
                );
                exit(json_encode($message));
            }
            $u = \user\model\users::getUserByPhone($args['userphone']);
            if($u)
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "这个手机号码已经被注册了"
                );
                exit(json_encode($message));
            }
            $group = \user\model\users::getGroupByCode($args['usergroupcode']);
            $properties = \database\model\model::getAllowPropertiesByModelcode($group['groupmodel'],1);
            $args = \database\model\model::callModelFieldsFilter($args,$properties);
            \user\model\users::addUser($args);
            $message = array(
                'statusCode' => 200,
                "message" => "注册成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?user-master-users"
            );
            exit(json_encode($message));
        }
        else
        {
            $models = \database\model\model::getModelsByApp('user');
            \tpl::getInstance()->assign('models',$models);
            \tpl::getInstance()->display('users_add');
        }
    }

    public function modify()
    {
        $userid = \route::get('userid');
        $user = \user\model\users::getUserById($userid);
        $group = \user\model\users::getGroupByCode($user['usergroupcode']);
        $modelcode = $group['groupmodel'];
        if(\route::get('modifyuser'))
        {
            $args = \route::get('args');
            if(!$args['userpassword'])unset($args['userpassword']);
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode,1);
            $args = \database\model\model::callModelFieldsFilter($args,$properties);
            \user\model\users::modifyUser($userid,$args);
            $message = array(
                'statusCode' => 200,
                "message" => "修改成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode,1);
            unset($user['userpassword']);
            $forms = \html::buildHtml($properties,$user);
            \tpl::getInstance()->assign('user',$user);
            \tpl::getInstance()->assign('forms',$forms);
            \tpl::getInstance()->display('users_modify');
        }
    }

    public function del()
    {
        $userid = \route::get('userid');
        \user\model\users::delUser($userid);
        $message = array(
            'statusCode' => 200,
            "message" => "删除成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function batdel()
    {
        $delids = \route::get('delids');
        foreach($delids as $userid => $p)
        {
            \user\model\users::delUser($userid);
        }
        $message = array(
            'statusCode' => 200,
            "message" => "删除成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function index()
    {
        $page = \route::get('page');
        $page = $page >= 1?$page:1;
        $args = array();
        if($this->search)
        {
            if($this->search['userid'])$args[] = array('AND',"userid = :userid",'userid',$this->search['userid']);
            if($this->search['username'])$args[] = array('AND',"username LIKE :username",'username','%'.$this->search['username'].'%');
            if($this->search['useremail'])$args[] = array('AND',"useremail  LIKE :useremail",'useremail','%'.$this->search['useremail'].'%');
            if($this->search['userphone'])$args[] = array('AND',"userphone  LIKE :userphone",'userphone','%'.$this->search['userphone'].'%');
            if($this->search['groupcode'])$args[] = array('AND',"usergroupcode = :usergroupcode",'usergroupcode',$this->search['groupcode']);
            if($this->search['stime'] || $this->search['etime'])
            {
                if(!is_array($args))$args = array();
                if($this->search['stime']){
                    $stime = strtotime($this->search['stime']);
                    $args[] = array('AND',"userregtime >= :userregtime",'userregtime',$stime);
                }
                if($this->search['etime']){
                    $etime = strtotime($this->search['etime']);
                    $args[] = array('AND',"userregtime <= :userregtime",'userregtime',$etime);
                }
            }
        }
        $users = \user\model\users::getUsersList($args,$page);
        $groups = \user\model\users::getGroups();
        \tpl::getInstance()->assign('users',$users);
        \tpl::getInstance()->assign('groups',$groups);
        \tpl::getInstance()->display('users');
    }
}