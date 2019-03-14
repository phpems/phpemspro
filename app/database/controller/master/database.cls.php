<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace database\controller\master;

class database
{
    public function __construct()
    {
        //
    }

    public function setting()
    {
        $dbid = \route::get('dbid');
        $table = \route::get('table');
        $field = \route::get('field');
        if(\route::get('setfield'))
        {
            $args = \route::get('args');
            \database\model\database::setDbProperty($dbid,$table,$field,$args);
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
            $intro = \database\model\database::getFieldIntro($dbid,$table,$field);
            if(!$intro['dbformat'])
            {
                $intro['dbformat'] = 'default';
            }
            \tpl::getInstance()->assign('dbid',$dbid);
            \tpl::getInstance()->assign('table',$table);
            \tpl::getInstance()->assign('field',$field);
            \tpl::getInstance()->assign('formats',\config::dataformat);
            \tpl::getInstance()->assign('intro',$intro);
            \tpl::getInstance()->display('database_setting');
        }
    }

    public function intro()
    {
        $dbid = \route::get('dbid');
        $table = \route::get('table');
        if(\route::get('settable'))
        {
            $args = \route::get('args');
            \database\model\database::setDbProperty($dbid,$table,null,$args);
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
            $intro = \database\model\database::getTableIntro($dbid,$table,null);
            \tpl::getInstance()->assign('dbid',$dbid);
            \tpl::getInstance()->assign('table',$table);
            \tpl::getInstance()->assign('intro',$intro);
            \tpl::getInstance()->display('database_intro');
        }
    }

    public function fields()
    {
        $dbid = \route::get('dbid');
        $table = \route::get('table');
        if(\config::db[$dbid])
        {
            $fields = \database\model\database::getDatabaseFields($dbid,$table);
        }
        else
        {
            $fields = null;
        }
        $intros = \database\model\database::getFieldsIntros($dbid,$table);
        \tpl::getInstance()->assign('dbid',$dbid);
        \tpl::getInstance()->assign('table',$table);
        \tpl::getInstance()->assign('fields',$fields);
        \tpl::getInstance()->assign('intros',$intros);
        \tpl::getInstance()->display('database_fields');
    }

    public function tables()
    {
        $dbid = \route::get('dbid');
        if(\config::db[$dbid])
        {
            $tables = \database\model\database::getDatabaseTables($dbid);
        }
        else
        {
            $tables = null;
        }
        $intros = \database\model\database::getTableIntros($dbid);
        \tpl::getInstance()->assign('dbid',$dbid);
        \tpl::getInstance()->assign('tables',$tables);
        \tpl::getInstance()->assign('intros',$intros);
        \tpl::getInstance()->display('database_tables');
    }

    public function synch()
    {
        $dbid = \route::get('dbid');
        $table = \route::get('table');
        $intro = \database\model\database::getTableIntro($dbid,$table);
        \tpl::getInstance()->assign('dbid',$dbid);
        \tpl::getInstance()->assign('table',$table);
        \tpl::getInstance()->assign('intro',$intro);
        \tpl::getInstance()->display('database_synch');
    }

    public function synchfields()
    {
        $dbid = \route::get('dbid');
        $table = \route::get('table');
        \database\model\database::synchfields($dbid,$table);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function synchdata()
    {
        $dbid = \route::get('dbid');
        $table = \route::get('table');
        \database\model\database::synchdata($dbid,$table);
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
        \tpl::getInstance()->assign('databases',\config::db);
        \tpl::getInstance()->display('database');
    }
}