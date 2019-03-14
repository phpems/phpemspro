<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 18:37
 */

namespace database\model;
class model
{
    static function getModels($page,$number = \config::webpagenumber)
    {
        $args = array(
            'select' => false,
            'table' => 'models',
            'orderby' => 'modelapp asc'
        );
        return \pepdo::getInstance()->listElements($page,$number,$args);
    }

    static public function getModelsByApp($appcode)
    {
        $data = array(
            'select' => false,
            'table' => 'models',
            'query' => array(
                array("AND","modelapp = :modelapp","modelapp",$appcode)
            )
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function getModelById($modelid)
    {
        $args = array();
        $args[] = array("AND","modelid = :modelid","modelid",$modelid);
        $data = array(
            'select' => false,
            'table' => 'models',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getModelByCode($modelcode)
    {
        $args = array();
        $args[] = array("AND","modelcode = :modelcode","modelcode",$modelcode);
        $data = array(
            'select' => false,
            'table' => 'models',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function addModel($args)
    {
        $args = database::encodeDbData('default','models',$args);
        $data = array('table' => 'models','query' => $args);
        return \pepdo::getInstance()->insertElement($data);
    }

    static function modifyModel($modelcode,$args)
    {
        $args = database::encodeDbData('default','models',$args);
        $data = array(
            'table' => 'models',
            'value' => $args,
            'query' => array(
                array("AND","modelcode = :modelcode","modelcode",$modelcode)
            )
        );
        return \pepdo::getInstance()->updateElement($data);
    }

    static function delModel($modelcode)
    {
        $data = array(
            'table' => 'model',
            'query' => array(
                array("AND","modelcode = :modelcode","modelcode",$modelcode)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function getPropertyiesByModelcode($modelcode)
    {
        $args = array(
            'select' => false,
            'table' => 'properties',
            'orderby' => 'ppyorder desc,ppyid desc',
            'query' => array(array("AND","ppymodel = :ppymodel","ppymodel",$modelcode),array("AND","ppyislock = 0"))
        );
        return \pepdo::getInstance()->getElements($args);
    }

    static function getAllowPropertiesByModelcode($modelcode,$access = -1)
    {
        $properties = self::getPropertyiesByModelcode($modelcode);
        foreach($properties as $key => $p)
        {
            if(in_array($access,$p['ppyaccess']))
            {
                unset($properties[$key]);
            }
        }
        return $properties;
    }

    static function callModelFieldsFilter($args,$properties)
    {
        $vars = array();
        foreach($properties as $p)
        {
            if(isset($args[$p['ppyfield']]))
            {
                $vars[$p['ppyfield']] = $args[$p['ppyfield']];
            }
        }
        unset($args);
        return $vars;
    }

    static function getAllPropertyiesByModelcode($modelcode)
    {
        $args = array(
            'select' => false,
            'table' => 'properties',
            'orderby' => 'ppyorder desc,ppyid desc',
            'query' => array(array("AND","ppymodel = :ppymodel","ppymodel",$modelcode))
        );
        return \pepdo::getInstance()->getElements($args);
    }

    static function getPropertyById($ppyid)
    {
        $args = array(array("AND","ppyid = :ppyid","ppyid",$ppyid));
        $data = array(
            'select' => false,
            'table' => 'properties',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function addProperty($args)
    {
        $data = array('table' => 'properties','query' => $args);
        return \pepdo::getInstance()->insertElement($data);
    }

    static function modifyProperty($id,$args)
    {
        $args = database::encodeDbData('default','properties',$args);
        $data = array(
            'table' => 'properties',
            'value' => $args,
            'query' => array(
                array("AND","ppyid = :ppyid","ppyid",$id)
            )
        );
        return \pepdo::getInstance()->updateElement($data);
    }

    static function delProperty($id)
    {
        $data = array(
            'table' => 'properties',
            'query' => array(
                array("AND","ppyid = :ppyid","ppyid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }
}