<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/20
 * Time: 23:10
 */

namespace core\model;


class apps
{

    //根据应用名获取应用信息
    static function getAppById($appid)
    {
        $args = array(array("AND","appid = :appid","appid",$appid));
        $data = array(
            'select' => false,
            'table' => 'apps',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getAppByCode($appcode)
    {
        $args = array(array("AND","appcode = :appcode","appcode",$appcode));
        $data = array(
            'select' => false,
            'table' => 'apps',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    //修改应用信息
    static function modifyApp($appid,$args)
    {
        $args = \database\model\database::encodeDbData('default','apps',$args);
        $data = array(
            'table' => 'apps',
            'value' => $args,
            'query' => array(
                array("AND","appid = :appid","appid",$appid)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    //修改应用信息
    static function modifyAppByCode($appcode,$args)
    {
        $args = \database\model\database::encodeDbData('default','apps',$args);
        $data = array(
            'table' => 'apps',
            'value' => $args,
            'query' => array(
                array("AND","appcode = :appcode","appcode",$appcode)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    //添加应用信息
    static function addApp($args)
    {
        $args = \database\model\database::encodeDbData('default','apps',$args);
        $data = array('table' => 'apps','query' => $args);
        \pepdo::getInstance()->insertElement($data);
    }

    //获取本地应用列表
    static function getLocalAppList()
    {
        return files::listDir('app');
    }

    //获取数据库内应用列表
    static function getAppList($args = 1)
    {
        $data = array(
            'select' => false,
            'table' => 'apps',
            'query' => $args,
            'index' => 'appcode'
        );
        $rs = \pepdo::getInstance()->getElements($data);
        foreach($rs as $key => $p)
        {
            if(!file_exists('app/'.$key))unset($rs[$key]);
        }
        return $rs;
    }
}