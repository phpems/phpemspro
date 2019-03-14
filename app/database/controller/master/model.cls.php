<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 18:37
 */

namespace database\controller\master;
use core\app;
use core\model\apps;

class model
{
    public function __construct()
    {
        //
    }

    public function gettables()
    {
        $dbid = \route::get('dbid');
        $tables = \database\model\database::getDatabaseTables($dbid);
        foreach($tables as $p)
        {
            $table = current($p);
            echo '<option value="'.$table.'">'.$table.'</option>';
        }
    }

    public function getfields()
    {
        $dbid = \route::get('dbid');
        $table = \route::get('table');
        $fields = \database\model\database::getDatabaseFields($dbid,$table);
        foreach($fields as $p)
        {
            echo '<option value="'.$p['Field'].'">'.$p['Field'].'</option>';
        }
    }

    public function add()
    {
        if(\route::get('addmodel'))
        {
            $args = \route::get('args');
            if(\database\model\model::getModelByCode($args['modelcode']))
            {
                $message = array(
                    'statusCode' => 300,
                    "message" => "操作失败，同名模型存在"
                );
                exit(json_encode($message));
            }
            else
            {
                \database\model\model::addModel($args);
                $message = array(
                    'statusCode' => 200,
                    "message" => "操作成功",
                    "callbackType" => "forward",
                    "forwardUrl" => "index.php?database-master-model"
                );
                exit(json_encode($message));
            }
        }
        else
        {
            \tpl::getInstance()->assign('databases',\config::db);
            \tpl::getInstance()->display('model_add');
        }
    }

    public function addproperty()
    {
        $modelcode = \route::get('modelcode');
        $model = \database\model\model::getModelByCode($modelcode);
        if(\route::get('addproperty'))
        {
            $args = \route::get('args');
            $args['ppymodel'] = $modelcode;
            \database\model\model::addProperty($args);

            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?database-master-model-properties&modelcode={$modelcode}"
            );
            exit(json_encode($message));
        }
        else
        {
            $properties = \database\model\model::getAllPropertyiesByModelcode($modelcode);
            $dbid = $model['modeldb'];
            $table = $model['modeltable'];
            $fields = \database\model\database::getDatabaseFields($dbid,$table);
            $usedfields = array();
            foreach($properties as $p)
            {
                $usedfields[] = $p['ppyfield'];
            }
            \tpl::getInstance()->assign('usedfields',$usedfields);
            \tpl::getInstance()->assign('fields',$fields);
            \tpl::getInstance()->assign('model',$model);
            \tpl::getInstance()->display('model_addproperty');
        }
    }

    public function del()
    {
        $modelcode = \route::get('modelcode');
        $properties = \database\model\model::getAllPropertyiesByModelcode($modelcode);
        if($properties)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "操作失败，请先删除该模型下的属性"
            );
            exit(json_encode($message));
        }
        \database\model\model::delModel($modelcode);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function delproperty()
    {
        $ppyid = \route::get('ppyid');
        \database\model\model::delProperty($ppyid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function modifyproperty()
    {
        $ppyid = \route::get('ppyid');
        $property = \database\model\model::getPropertyById($ppyid);
        if(\route::get('modifyproperty'))
        {
            $args = \route::get('args');
            if(!$args['ppyaccess'])$args['ppyaccess'] = array();
            \database\model\model::modifyProperty($ppyid,$args);

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
            $model = \database\model\model::getModelByCode($property['ppymodel']);
            $properties = \database\model\model::getAllPropertyiesByModelcode($model['modelcode']);
            $dbid = $model['modeldb'];
            $table = $model['modeltable'];
            $fields = \database\model\database::getDatabaseFields($dbid,$table);
            $usedfields = array();
            foreach($properties as $p)
            {
                if($ppyid != $p['ppyid'])
                $usedfields[] = $p['ppyfield'];
            }
            \tpl::getInstance()->assign('usedfields',$usedfields);
            \tpl::getInstance()->assign('fields',$fields);
            \tpl::getInstance()->assign('model',$model);
            \tpl::getInstance()->assign('property',$property);
            \tpl::getInstance()->display('model_modifyproperty');
        }
    }

    public function modify()
    {
        $modelcode = \route::get('modelcode');
        $model = \database\model\model::getModelByCode($modelcode);
        if(\route::get('modifymodel'))
        {
            $args = \route::get('args');
            \database\model\model::modifyModel($modelcode,$args);

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
            $tables = \database\model\database::getDatabaseTables($model['modeldb']);
            \tpl::getInstance()->assign('databases',\config::db);
            \tpl::getInstance()->assign('tables',$tables);
            \tpl::getInstance()->assign('model',$model);
            \tpl::getInstance()->display('model_modify');
        }
    }

    public function properties()
    {
        $modelcode = \route::get('modelcode');
        $page = \route::get('page');
        $model = \database\model\model::getModelByCode($modelcode);
        $properties = \database\model\model::getAllPropertyiesByModelcode($modelcode);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('model',$model);
        \tpl::getInstance()->assign('properties',$properties);
        \tpl::getInstance()->display('model_properties');
    }

    public function preview()
    {
        $modelcode = \route::get('modelcode');
        $model = \database\model\model::getModelByCode($modelcode);
        $properties = \database\model\model::getPropertyiesByModelcode($modelcode);
        $forms = \html::buildHtml($properties);
        \tpl::getInstance()->assign('model',$model);
        \tpl::getInstance()->assign('forms',$forms);
        \tpl::getInstance()->display('model_preview');
    }

    public function orders()
    {
        if(\route::get('orderproperty'))
        {
            $ids = \route::get('ids');
            foreach($ids as $key => $p)
            {
                \database\model\model::modifyProperty($key,array('ppyorder' => $p));
            }
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
    }

    public function index()
    {
        $page = \route::get('page');
        if($page < 1)$page = 1;
        $models = \database\model\model::getModels($page);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->assign('models',$models);
        \tpl::getInstance()->display('model');
    }
}