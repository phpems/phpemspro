<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 18:37
 */

namespace database\model;
class database
{
    static public $tableintros;
    static public $fieldintros;

    static function getDatabaseTables($dbid)
    {
        return \pepdo::getInstance($dbid)->fetchAll(array('sql' => "show tables"));
    }

    static function getDatabaseFields($dbid,$table)
    {
        return \pepdo::getInstance($dbid)->fetchAll(array('sql' => "SHOW FULL COLUMNS FROM `{$table}`"));
    }

    static function getTableIntro($dbid,$table)
    {
        if(self::$tableintros[$dbid][$table])return self::$tableintros[$dbid][$table];
        $args = array();
        $args[] = array("AND","dbbase = :dbbase","dbbase",$dbid);
        $args[] = array("AND","dbname = :dbname","dbname",$table);
        $args[] = array("AND","dbtable = :dbtable","dbtable",$table);
        $args[] = array("AND","dbtype = 'table'");
        $data = array(false,'database',$args);
        $sql = \pdosql::getInstance()->makeSelect($data);
        self::$tableintros[$dbid][$table] = \pepdo::getInstance()->fetch($sql);
        return self::$tableintros[$dbid][$table];
    }

    static function getTableIntros($dbid)
    {
        $args = array();
        $args[] = array("AND","dbbase = :dbbase","dbbase",$dbid);
        $args[] = array("AND","dbtype = 'table'");
        $data = array(false,'database',$args);
        $sql = \pdosql::getInstance()->makeSelect($data);
        return \pepdo::getInstance()->fetchAll($sql,'dbname');
    }

    static function delFieldIntro($dbid,$table,$field)
    {
        $args = array();
        $args[] = array("AND","dbbase = :dbbase","dbbase",$dbid);
        $args[] = array("AND","dbname = :dbname","dbname",$field);
        $args[] = array("AND","dbtable = :dbtable","dbtable",$table);
        $args[] = array("AND","dbtype = 'field'");
        $data = array(
            'table' => 'database',
            'query' => $args
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function getFieldIntro($dbid,$table,$field)
    {
        $args = array();
        $args[] = array("AND","dbbase = :dbbase","dbbase",$dbid);
        $args[] = array("AND","dbname = :dbname","dbname",$field);
        $args[] = array("AND","dbtable = :dbtable","dbtable",$table);
        $args[] = array("AND","dbtype = 'field'");
        $data = array(
            'table' => 'database',
            'query' => $args
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getFieldsIntros($dbid,$table)
    {
        if(is_array($table))
        {
            $intros = array();
            foreach($table as $t)
            {
                if(!self::$fieldintros[$dbid][$t])
                {
                    $args = array();
                    $args[] = array("AND","dbbase = :dbbase","dbbase",$dbid);
                    $args[] = array("AND","dbtable = :dbtable","dbtable",$t);
                    $args[] = array("AND","dbtype = 'field'");
                    $data = array(false,'database',$args,false,false,false);
                    $sql = \pdosql::getInstance()->makeSelect($data);
                    self::$fieldintros[$dbid][$t] = \pepdo::getInstance()->fetchAll($sql,'dbname');
                }
                foreach(self::$fieldintros[$dbid][$t] as $tmp)
                {
                    $intros[$tmp['dbname']] = $tmp;
                }
            }
            return $intros;
        }
        else
        {
            if(self::$fieldintros[$dbid][$table])return self::$fieldintros[$dbid][$table];
            $args = array();
            $args[] = array("AND","dbbase = :dbbase","dbbase",$dbid);
            $args[] = array("AND","dbtable = :dbtable","dbtable",$table);
            $args[] = array("AND","dbtype = 'field'");
            $data = array(false,'database',$args,false,false,false);
            $sql = \pdosql::getInstance()->makeSelect($data);
            self::$fieldintros[$dbid][$table] = \pepdo::getInstance()->fetchAll($sql,'dbname');
            return self::$fieldintros[$dbid][$table];
        }
    }

    static function encodeDbData($dbid,$table,$args)
    {
        $intros = self::getFieldsIntros($dbid,$table);
        if(is_array($intros))
        {
            foreach($intros as $p)
            {
                if(isset($args[$p['dbname']]))
                {
                    switch($p['dbformat'])
                    {
                        case 'json':
                            $args[$p['dbname']] = json_encode($args[$p['dbname']],JSON_UNESCAPED_UNICODE);
                            break;
                        case 'md5':
                            $args[$p['dbname']] = md5($args[$p['dbname']]);
                            break;
                        case 'base64':
                            $args[$p['dbname']] = base64_encode($args[$p['dbname']]);
                            break;
                        case 'zipbase64':
                            $args[$p['dbname']] = base64_encode(gzcompress(json_encode($args[$p['dbname']],JSON_UNESCAPED_UNICODE)));
                            break;
                        case 'split':
                            $args[$p['dbname']] = implode(',',$args[$p['dbname']]);
                            break;
                        case 'serialize':
                            $args[$p['dbname']] = serialize($args[$p['dbname']]);
                            break;
                        case 'timestamp':
                            if(!is_numeric($args[$p['dbname']]))
                            {
                                $args[$p['dbname']] = strtotime($args[$p['dbname']]);
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return $args;
    }

    static function decodeDbData($intros,$args)
    {
        foreach ($args as $key => $p)
        {
            $args[$key] = stripslashes(htmlspecialchars_decode($p));
        }
        if(is_array($intros))
        {
            foreach($intros as $p)
            {
                if(isset($args[$p['dbname']]))
                {
                    switch($p['dbformat'])
                    {
                        case 'json':
                            $args[$p['dbname']] = json_decode($args[$p['dbname']],true);
                            break;
                        case 'split':
                            $args[$p['dbname']] = explode(',',$args[$p['dbname']]);
                            break;
                        case 'base64':
                            $args[$p['dbname']] = base64_decode($args[$p['dbname']]);
                            break;
                        case 'zipbase64':
                            $args[$p['dbname']] = json_decode(gzuncompress(base64_decode($args[$p['dbname']])),true);
                            break;
                        case 'serialize':
                            $args[$p['dbname']] = unserialize($args[$p['dbname']]);
                            break;
                        case 'timestamp':
                            if(!$p['dbtimeformat'])$p['dbtimeformat'] = 'Y-m-d H:i:s';
                            $args[$p['dbname']] = date($p['dbtimeformat'],$args[$p['dbname']]);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return $args;
    }

    static function decodeDbDataAuto($dbid,$table,$args)
    {
        $intros = self::getFieldsIntros($dbid,$table);
        return self::decodeDbData($intros,$args);
    }

    static function setDbProperty($dbid,$table,$field,$args)
    {
        if($field)
        {
            $intro = self::getFieldIntro($dbid,$table,$field);
            $args['dbbase'] = $dbid;
            $args['dbtable'] = $table;
            $args['dbname'] = $field;
            $args['dbtype'] = 'field';
        }
        else
        {
            $intro = self::getTableIntro($dbid,$table);
            $args['dbbase'] = $dbid;
            $args['dbtable'] = $table;
            $args['dbname'] = $table;
            $args['dbtype'] = 'table';
            $args['dbformat'] = 'default';
        }
        $args = self::encodeDbData('default','database',$args);
        if($intro)
        {
            $data = array(
                'table' => 'database',
                'value' => $args,
                'query' => array(
                    array("AND","dbid = :dbid","dbid",$intro['dbid'])
                )
            );
            \pepdo::getInstance()->updateElement($data);
        }
        else
        {
            return \pepdo::getInstance()->insertElement(array('table' => 'database','query' => $args));
        }
    }

    static function synchfields($dbid,$table)
    {
        $sourcetable = str_replace(\config::db[$dbid]['prefix'],\config::db['default']['prefix'],$table);
        $sourceintros = self::getFieldsIntros('default',$sourcetable);
        $sourcetableintro = self::getTableIntro('default',$sourcetable);
        if($sourcetableintro)
        {
            $sourcetableintro['dbname'] = str_replace(\config::db['default']['prefix'],\config::db[$dbid]['prefix'],$sourcetableintro['dbname']);
            self::setDbProperty($dbid,$table,NULL,$sourcetableintro);
        }
        $intros = self::getFieldsIntros($dbid,$table);
        foreach($intros as $intro)
        {
            if(!$sourceintros[$intro['dbname']])
            {
                self::delFieldIntro($dbid,$table,$intro['dbname']);
            }
        }
        foreach($sourceintros as $key => $intro)
        {
            $intro['dbtable'] = str_replace(\config::db['default']['prefix'],\config::db[$dbid]['prefix'],$table);
            if($intro != $intros[$key])
            {
                self::setDbProperty($dbid,$table,$intro['dbname'],$intro);
            }
        }
        return true;
    }

    static function synchdata($dbid,$table)
    {
        $table = str_replace(\config::db[$dbid]['prefix'],'',$table);
        $sql = array('sql' => "TRUNCATE `".\config::db[$dbid]['prefix']."{$table}`");
        $data = array(false,$table,array(),false,false,false);
        $sql = \pdosql::getInstance()->makeSelect($data);
        $rs = \pepdo::getInstance()->fetchAll($sql);
        foreach($rs as $r)
        {
            $data = array($table,$r);
            \pepdo::getInstance($dbid)->exec(\pdosql::getInstance($dbid)->makeInsert($data));
        }
        return true;
    }
}