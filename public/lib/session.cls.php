<?php

class session
{
	static public $sessionname = 'pepuser';
	public $sessionuser = false;
	public $sessionid;
	public static $instance;

    public function __construct($parm)
    {
        $this->parm = $parm;
    	$this->sessionid = $this->getSessionId();
    }

    /**
     * @param string $parm
     * @return static
     */
    static function getInstance($parm = 'default')
	{
        if(self::$instance == NULL)
        {
            self::$instance = new static($parm);//亦可写为 new self();
        }
        else
		{
			self::$instance->parm = $parm;
		}
        return self::$instance;
	}

    private function _getOnlySessionid()
    {
        $code = uniqid(\route::getClientIp().print_r($_SERVER,true).microtime()).rand(100000,999999);
        $this->sessionid = md5($code);
        if($this->getSessionValue($this->sessionid))
        {
            $this->_getOnlySessionid();
        }
    }

    //获取会话ID
    public function getSessionId()
    {
        if(!$this->sessionid)
    	{
			$cookie = strings::decode(route::getCookie(self::$sessionname));
			if($cookie)
			{
				$this->sessionid = $cookie['sessionid'];
			}
    	}
        if(!$this->sessionid)
        {
            $this->_getOnlySessionid();
            pedis::getInstance($this->parm)->setHashData('session',$this->sessionid,json_encode(array('sessionip'=>route::getClientIp())));
            route::setCookie(self::$sessionname,strings::encode(array('sessionid' => $this->sessionid,'sessionip'=>route::getClientIp())));
        }
    	if(!$this->getSessionValue($this->sessionid))
		{
			pedis::getInstance($this->parm)->setHashData('session',$this->sessionid,json_encode(array('sessionip'=>route::getClientIp())));
            route::setCookie(self::$sessionname,strings::encode(array('sessionid' => $this->sessionid,'sessionip'=>route::getClientIp())));
		}
    	return $this->sessionid;
    }

    //设置随机参数
    public function setRandCode($randCode)
    {
    	if(!$randCode)
    	{
	    	$array = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
    		$randCode = '';
    		for($i=0;$i<4;$i++)
    		{
    			$randCode .= $array[intval(rand(0,35))];
	    	}
    	}
    	if(!$this->sessionid)$this->getSessionId();
    	$this->setSessionUser(array('randcode' => $randCode));
        return $randCode;
    }

    //获取随机参数
    public function getRandCode()
    {
    	if(!$this->sessionid)$this->getSessionId();
    	$r = $this->getSessionValue();
    	return $r['randcode'];
    }

    //获取会话内容
    public function getSessionValue($sessionid = NULL)
    {
    	if(!$sessionid)
    	{
    		if(!$this->sessionid)$this->getSessionId();
    		$sessionid = $this->sessionid;
    	}
    	return json_decode(pedis::getInstance($this->parm)->getHashData('session',$sessionid),true);
    }

    //设置会话用户信息
    public function setSessionUser($args = NULL)
    {
    	if(!$args)return false;
    	else
    	{
	    	if(!$args['sessiontimelimit'])$args['sessiontimelimit'] = TIME;
	    	if(!$this->sessionid)$this->getSessionId();
	    	$data = $this->getSessionValue();
	    	foreach($data as $key => $p)
			{
				if(!isset($args[$key]))
				{
                    $args[$key] = $p;
				}
			}
			if($args['sessionuserid'])
			{
				$sid = pedis::getInstance()->getHashData('users',$args['sessionuserid']);
				if($sid && $sid != $this->sessionid)
				{
					pedis::getInstance($this->parm)->delHashData('session',$sid);
				}
                pedis::getInstance($this->parm)->setHashData('users',$args['sessionuserid'],$this->sessionid);
			}
            pedis::getInstance($this->parm)->setHashData('session',$this->sessionid,json_encode($args));
	    	$args['sessionid'] = $this->sessionid;
            route::setCookie(self::$sessionname,strings::encode($args));
	    	return true;
    	}
    }

    //获取会话用户
    public function getSessionUser()
    {
    	if($this->sessionuser)return $this->sessionuser;
        $cookie = strings::decode(route::getCookie(self::$sessionname));
    	if($cookie['sessionuserid'])
    	{
    		$user = $this->getSessionValue();
    		if($cookie['sessionuserid'] == $user['sessionuserid'] && $cookie['sessionpassword'] == $user['sessionpassword'])
    		{
    			$this->sessionuser = $user;
    			return $user;
    		}
    	}
		return false;
    }

    //清除会话用户
    public function clearSessionUser()
    {
    	if(!$this->sessionid)$this->getSessionId();
    	route::setCookie($this->sessionname,NULL);
    	$u = $this->getSessionValue();
    	if($u['sessionuserid'])
		{
			pedis::getInstance($this->parm)->delHashData('users',$u['sessionuserid']);
		}
		pedis::getInstance($this->parm)->delHashData('session',$this->sessionid);
		return true;
    }

    public function offOnlineUser($userid)
    {
        $u = json_decode(pedis::getInstance()->getHashData('users',$userid),true);
    	pedis::getInstance($this->parm)->delHashData('users',$userid);
        pedis::getInstance($this->parm)->delHashData('session',$u['sessionid']);
    	return true;
    }

    //清除所有会话
    public function clearSession()
    {
        pedis::getInstance($this->parm)->delHashData('users');
        pedis::getInstance($this->parm)->delHashData('session');
        return true;
    }

    //清除超时用户
    public function clearOutTimeUser($time)
    {
    	//
    }

    public function __destruct()
    {
    	//
    }
}
?>
