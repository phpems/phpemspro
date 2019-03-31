<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 13:42
 */

session_start();
spl_autoload_register('base::autoLoadClass');

class base
{
    static $systime = NULL;

    static function autoLoadClass($class)
    {
        $class = explode('\\',$class);
        if(count($class) == 1)
        {
            $class = $class[0];
            $path = PEP_PATH.'/public/lib/'.$class.'.cls.php';
        }
        else
        {
            $class = implode('/',$class);
            $path = PEP_PATH.'/app/'.$class.'.cls.php';
        }
        if(file_exists($path))
        {
            include $path;
        }
    }

    static function run()
    {
        ini_set('date.timezone',config::systimezone);
        header('P3P: CP=CAO PSA OUR; Content-Type: text/html; charset='.config::webencode);
        /**
		if(\route::isWeixin())
        {
            wxpay::getInstance()->getwxopenid();
            $user = \session::getInstance()->getSessionUser();
            if(!$user['sessionuserid'] && $_SESSION['openid'])
            {
                $u = \user\model\users::getUserByOpenid($_SESSION['openid']);
                if($u)
                {
                    $sessionuser = array(
                        'sessionuserid' => $u['userid'],
                        'sessionuserphone' => $u['userphone'],
                        'sessionusername' => $u['username'],
                        'sessionpassword' => $u['userpassword'],
                        'sessiongroupcode' => $u['usergroupcode']
                    );
                    \session::getInstance()->setSessionUser($sessionuser);
                }
            }
        }
		**/
        self::$systime = time();
        $appname = (route::getUrl()?route::getUrl():config::defaultapp).'\\'.(route::getUrl('module')?route::getUrl('module'):'app');
        //$app = new $appname();
        //$app->display();
        $appname::display();
    }
}