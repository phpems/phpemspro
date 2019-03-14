<?php
/*
 * redis类，初次使用，错误较多，如有建议欢迎加QQ探讨
 */
class pedis
{
    public static $instance;
    public $parm;
    private $redis;

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

    public function __construct($parm)
    {
        $this->parm = $parm;
        $this->redis = new Redis();
        $this->redis->connect(config::redis[$parm]['host']);
        if(config::redis[$parm]['pass'])
        {
            $this->redis->auth(config::redis[$parm]['pass']);
        }
        $this->redis->select(intval(config::redis[$parm]['name']));
    }

    public function setStringData($key,$value,$expire = 0)
    {
        $this->redis->set($key,$value);
        if($expire)
        {
            $this->redis->expire($key,$expire);
        }
    }

    public function delData($key)
    {
        $this->redis->del($key);
    }

    public function getStringData($key)
    {
        if($this->redis->ttl($key) > 0)
        {
            return $this->redis->get($key);
        }
        else
        {
            return false;
        }
    }

    public function setHashData($key,$field,$value,$expire = 0)
    {
        $this->redis->hset($key,$field,$value);
        if($expire)
        {
            $this->redis->expire($key,$expire);
        }
    }

    public function getHashData($key,$field)
    {
        if($this->redis->ttl($key) > 0)
        {
            return $this->redis->hget($key,$field);
        }
        elseif($this->redis->ttl($key) == -1)
        {
            return $this->redis->hget($key,$field);
        }
        else
        {
            return false;
        }
    }

    public function delHashData($key,$field = null)
    {
        if($field)
        {
            return $this->redis->hdel($key,$field);
        }
        else
        {
            return $this->redis->del($key);
        }
    }
}
?>