<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:02
 */

class route
{
    static $url;
    static $get;
    static $post;
    static $cookie;
    static $files;
    static $e;

    static function isWeixin()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false)
        {
            return true;
        }
        return false;
    }

    static function isMobile()
    {
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP'])?$_SERVER['ALL_HTTP']:'';
        $mobile_browser = '0';
        if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $mobile_browser++;
        if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
            $mobile_browser++;
        if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
            $mobile_browser++;
        if(isset($_SERVER['HTTP_PROFILE']))
            $mobile_browser++;
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda','xda-'
        );
        if(in_array($mobile_ua, $mobile_agents))
            $mobile_browser++;
        if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
            $mobile_browser++;
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
            $mobile_browser=0;
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
            $mobile_browser++;
        if($mobile_browser>0)
            return true;
        else
            return false;
    }

    static private function _parseUrl()
    {
        $keys = array('app' => 0,'module' => 1,'method' => 2,'selection' => 3);
        $values = array();
        if(isset($_REQUEST['route']))
        {
            $r = explode('-',$_REQUEST['route']);
            foreach($keys as $key => $p)
            {
                $values[$keys[$key]] = urlencode($r[$p]);
            }
        }
        elseif(isset($_SERVER['QUERY_STRING']))
        {
            $tmp = explode('#',str_replace('=','',$_SERVER['QUERY_STRING']),2);
            $tp = explode('&',$tmp[0],2);
            $r = explode('-',$tp[0]);
            foreach($keys as $key => $p)
            {
                $values[$key] = urlencode($r[$p]);
            }
        }
        else return false;
        if(!$values['app'])$values['app'] = config::defaultapp;
        if(!$values['module'])
        {
            if(self::isMobile())
            {
                $values['module'] = 'mobile';
            }
            else
            {
                $values['module'] = 'app';
            }
        }
        if(!$values['method'])$values['method'] = 'index';
        if(!$values['selection'])$values['selection'] = 'index';
        tpl::getInstance()->assign('_route',$values);
        tpl::getInstance()->assign('_userhash',self::get('userhash'));
        return $values;
    }

    static function getUrl($key = 'app')
    {
        if(!self::$url)
        {
            self::$url = self::_parseUrl();
        }
        return self::$url[$key];
    }

    static private function initData($data)
    {
        //if($_SERVER['HTTP_HOST'] != '127.0.0.1')return false;
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                if(strings::isAllowKey($key) === false)
                {
                    unset($data[$key]);
                }
                else
                    $data[$key] = self::initData($value);
            }
            return $data;
        }
        else
        {
            if(is_numeric($data))
            {
                if($data[0] === 0)return self::addSlashes(htmlspecialchars($data));
                if(strlen($data) >= 11)return self::addSlashes(htmlspecialchars($data));
                if(strpos($data,'.'))return floatval($data);
                else return $data;
            }
            if(is_string($data))return self::addSlashes(htmlspecialchars($data));
            if(is_bool($data))return (bool)$data;
            return false;
        }
    }

    //去除转义字符
    static function stripSlashes($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::stripSlashes($value);
            }
        } else {
            $data = stripSlashes(trim($data));
        }

        return $data;
    }

    //添加转义字符
    static function addSlashes($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::addSlashes($value);
            }
        } else {
            $data = addSlashes(trim($data));
        }
        return $data;
    }

    //获取客户端IP
    static function getClientIp()
    {
        if(!isset(self::$e['ip']))
        {
            if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
                $ip = getenv("HTTP_CLIENT_IP");
            else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                $ip = getenv("REMOTE_ADDR");
            else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                $ip = $_SERVER['REMOTE_ADDR'];
            else
                $ip = "unknown";
            self::$e['ip'] = $ip;
        }
        return self::$e['ip'];
    }

    static function get($par)
    {
        if(self::$get == NULL)self::$get = self::initData($_REQUEST);
        if(isset(self::$get[$par]))return self::$get[$par];
        else return false;
    }

    //返回$_POST数组内的值
    static function post($par)
    {
        if(self::$post == NULL)self::$post = self::initData($_POST);
        if(isset(self::$post[$par]))return self::$post[$par];
        else return false;
    }

    //设置COOKIE
    static function setCookie($name,$value,$time=3600)
    {
        if($time)$time = TIME + $time;
        else $time = 0;
        setCookie(config::cookieprefix.$name,$value,$time,config::cookiepath,config::cookiedomain,false,false);
    }

    //获取cookie
    static function getCookie($par,$nohead = 0)
    {
        if(self::$cookie == NULL)self::$cookie = self::initData($_COOKIE);
        if(isset(self::$cookie[config::cookieprefix.$par]))return self::$cookie[config::cookieprefix.$par];
        elseif(isset(self::$cookie[$par]) && $nohead)return self::$cookie[$par];
        else return false;
    }

    //获取$_FILE
    static function getFile($par)
    {
        if(!self::$files)self::$files = $_FILES;
        if(isset(self::$files[$par]))return self::$files[$par];
        else return false;
    }
	
	static function getCityInfoByIp($ip)
	{
		$url = "http://api.map.baidu.com/location/ip?ip={$ip}&ak=GKadxMK7M5lFH7yee8jkyYDUYmRZakNK&coor=bd09ll";
		return json_decode(file_get_contents($url),true);
	}

	static function urlJump($message)
    {
        if(self::get('userhash'))
        {
            exit(json_encode($message));
        }
        else
        {
            header("location:{$message['forwardUrl']}");
            exit;
        }
    }
}