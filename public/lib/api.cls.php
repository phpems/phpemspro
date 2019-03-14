<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 13:42
 */

spl_autoload_register('api::autoLoadClass');

class api
{
    static $systime = NULL;

    static function autoLoadClass($class)
    {
		$class = explode('\\',$class);
        if(count($class) == 1)
        {
            $class = $class[0];
            $path = '../public/lib/'.$class.'.cls.php';
        }
        else
        {
            $class = implode('/',$class);
            $path = '../app/'.$class.'.cls.php';
        }
        if(file_exists($path))
        {
            include $path;
        }
        else
        {
            exit(' Class not exits!');
        }
    }

    static function run()
    {
        ini_set('date.timezone',config::systimezone);
        header('P3P: CP=CAO PSA OUR; Content-Type: text/html; charset='.config::webencode);
        self::$systime = time();
        $appname = (route::getUrl()?route::getUrl():config::defaultapp).'\\'.(route::getUrl('module')?route::getUrl('module'):'app');
        //$app = new $appname();
        //$app->display();
        $appname::display();
    }
}