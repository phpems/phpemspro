<?php
/*
 * Created on 2014-12-10
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class pepdo
{
 	private $queryid = 0;
	private $linkid = 0;
	private $log = config::dblog;
	static $instance;
	public $parm;

	public function __construct($parm)
    {
        $this->parm = $parm;
        $this->connect(config::db[$parm]);
    }

     /**
      * @param string $parm
      * @return static
      */
	static function getInstance($parm = 'default')
	{
        if(self::$instance[$parm] == NULL)
        {
            self::$instance[$parm] = new static($parm);//new self();
        }
        return self::$instance[$parm];
	}

    private function _log($sql,$query)
    {
    	if($this->log)
    	{
    		$fp = fopen('public/data/error.log','a');
			fputs($fp,print_r($sql,true).print_r($query->errorInfo(),true));
			fclose($fp);
    	}
    }

    public function connect($setting = config::db['default'])
    {
    	$dsn="mysql:host={$setting['host']};dbname={$setting['name']};";
    	$this->linkid = new PDO($dsn,$setting['user'],$setting['pass']);
    	if(config::webencode == 'utf-8')
    	$this->linkid->query("set names utf8");
    	else
    	$this->linkid->query("set names gbk");
    }

    public function commit()
    {
    	if(!$this->linkid)$this->connect($this->parm);
    	$this->linkid->commit();
    }

    public function beginTransaction()
    {
    	if(!$this->linkid)$this->connect($this->parm);
    	$this->linkid->beginTransaction();
    }

    public function rollback()
    {
    	if(!$this->linkid)$this->connect($this->parm);
    	$this->linkid->rollback();
    }

    public function fetchAll($sql,$index = false,$unserialize = false)
    {
    	if(!is_array($sql))return false;
    	if(!$this->linkid)$this->connect($this->parm);
    	$query = $this->linkid->prepare($sql['sql']);
    	$rs = $query->execute($sql['v']);
    	$this->_log($sql,$query);
		if ($rs) {
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$r = array();
			while($tmp = $query->fetch())
			{
				if($index)
				{
					$r[$tmp[$index]] = $tmp;
				}
				else
				$r[] = $tmp;
			}
			return $r;
		}
		else
		return false;
    }

    public function fetch($sql,$unserialize = false)
    {
    	if(!is_array($sql))return false;
    	if(!$this->linkid)$this->connect($this->parm);
    	$query = $this->linkid->prepare($sql['sql']);
    	$rs = $query->execute($sql['v']);
    	$this->_log($sql,$query);
    	if ($rs) {
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$tmp = $query->fetch();
			return $tmp;
		}
		else
		return false;
    }

    public function query($sql)
    {
    	if(!$sql)return false;
    	if(!$this->linkid)$this->connect($this->parm);
    	return $this->linkid->query($sql);
    }

    public function exec($sql)
    {
    	$this->affectedRows = 0;
    	if(!is_array($sql))return false;
    	if(!$this->linkid)$this->connect($this->parm);
    	if($sql['dim'])
    	return $this->dimexec($sql);
    	else
    	$query = $this->linkid->prepare($sql['sql']);
    	$rs = $query->execute($sql['v']);
		$this->_log($sql,$query);
		$this->affectedRows = $rs;
    	return $rs;
    }

    public function dimexec($sql)
    {
    	if(!is_array($sql))return false;
    	if(!$this->linkid)$this->connect($this->parm);
    	$query = $this->linkid->prepare($sql['sql']);
    	foreach($sql['v'] as $p)
    	$rs = $query->execute($p);
    	return $rs;
    }

    public function lastInsertId()
    {
    	return $this->linkid->lastInsertId();
    }

    private function _fixtables($tables,$prefix = null)
	{
        if(!$prefix)
		{
            $prefix = \config::db[$this->parm]['prefix'];
		}
		if(is_array($tables))
        {
            $table = array();
            foreach($tables as $p)
			{
                $table[] = $prefix.$p;
			}
			return $table;
        }
        else
		{
			return $prefix.$tables;
		}
	}

    public function getElement($args)
	{
        $data = array($args['select'],$args['table'],$args['query'],$args['groupby'],$args['orderby'],false);
        $sql = pdosql::getInstance($this->parm)->makeSelect($data);
        $r = $this->fetch($sql);
		return \database\model\database::decodeDbDataAuto('default',$this->_fixtables($args['table']),$r);
	}

     public function getElements($args)
     {
         $data = array($args['select'],$args['table'],$args['query'],$args['groupby'],$args['orderby'],$args['limit']);
         $sql = pdosql::getInstance($this->parm)->makeSelect($data);
         $rs = $this->fetchAll($sql,$args['index']);
         $intros = \database\model\database::getFieldsIntros('default',$this->_fixtables($args['table']));
         foreach($rs as $key => $p)
		 {
             $rs[$key] = \database\model\database::decodeDbData($intros,$p);
		 }
         return $rs;
     }

    public function insertElement($args)
	{
		$args['query'] = \database\model\database::encodeDbData($this->parm,$this->_fixtables($args['table']),$args['query']);
		$data = array($args['table'],$args['query']);
        $intro = \database\model\database::getTableIntro('default',$this->_fixtables($args['table']));
        if($intro['dbsynch'])
        {
            foreach(\config::db as $dbid => $db)
            {
                $sql = pdosql::getInstance($dbid)->makeInsert($data);
                self::getInstance($dbid)->exec($sql);
            }
        }
        else
        {
            $sql = pdosql::getInstance($this->parm)->makeInsert($data);
            $this->exec($sql);
        }
		return $this->lastInsertId();
	}

    public function listElements($page,$number = 20,$args)
	{
		if(!is_array($args))return false;
		$page = $page > 0?$page:1;
        $args['limit'] = array(intval($page-1)*$number,$number);
		$r = array();
		$r['data'] = $this->getElements($args);
		$data = array('count(*) AS number',$args['table'],$args['query']);
		$sql = pdosql::getInstance($this->parm)->makeSelect($data);
		$t = $this->fetch($sql);
		$pages = pg::outPage(pg::getPagesNumber($t['number'],$number),$page);
		$r['pages'] = $pages;
		$r['number'] = $t['number'];
		return $r;
	}

	public function delElement($args)
	{
		$data = array($args['table'],$args['query'],$args['orderby'],$args['limit']);
		$intro = \database\model\database::getTableIntro('default',$this->_fixtables($args['table']));
		if($intro['dbsynch'])
		{
			foreach(\config::db as $dbid => $db)
			{
                $sql = pdosql::getInstance($dbid)->makeDelete($data);
                $rs = self::getInstance($dbid)->exec($sql);
			}
			return $rs;
		}
		else
		{
			$sql = pdosql::getInstance($this->parm)->makeDelete($data);
            return $this->exec($sql);
        }
	}

	public function updateElement($args)
	{
        $args['query'] = \database\model\database::encodeDbData($this->parm,$this->_fixtables($args['table']),$args['query']);
        $args['value'] = \database\model\database::encodeDbData($this->parm,$this->_fixtables($args['table']),$args['value']);
        $data = array($args['table'],$args['value'],$args['query'],$args['limit']);
        $intro = \database\model\database::getTableIntro('default',$args['table']);
        if($intro['dbsynch'])
        {
            foreach(\config::db as $dbid => $db)
            {
                $sql = pdosql::getInstance($dbid)->makeUpdate($data);
                $rs = self::getInstance($dbid)->exec($sql);
            }
            return $rs;
        }
        else
        {
            $sql = pdosql::getInstance($this->parm)->makeUpdate($data);
            return $this->exec($sql);
        }
	}

	public function affectedRows()
	{
		return $this->affectedRows;
	}
 }
?>
