<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace core\controller\master;

class index
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $catid = \route::get('catid');
        $categories = \core\model\category::getAllCategory('lesson');
        $les = array();
        \core\model\category::levelCategory($les,0,\core\model\category::$tidyCategory['lesson'],$catid,'index.php?lesson-master-lessons&catid=');
        \core\model\category::resetCategoryIndex($les);
        \tpl::getInstance()->assign('les',$les);
        
        $categories = \core\model\category::getAllCategory('content');
        $con = array();
        \core\model\category::levelCategory($con,0,\core\model\category::$tidyCategory['content'],$catid,'index.php?content-master-contents&catid=');
        \core\model\category::resetCategoryIndex($con);
        \tpl::getInstance()->assign('con',$con);
        \tpl::getInstance()->display('index');
    }

    public function welcome()
    {
        $args['uname'] = php_uname();
        $args['sapi'] = php_sapi_name();
        $args['version'] = PHP_VERSION;
        $args['server'] = GetHostByName($_SERVER['SERVER_NAME']);
        $args['servername'] = $_SERVER['HTTP_HOST'];
        $args['software'] = $_SERVER['SERVER_SOFTWARE'];
        $args['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $args['up_size'] = get_cfg_var("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件";
        $args['up_time'] = get_cfg_var("max_execution_time")."秒 ";
        $args['memory'] = get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无";
        \tpl::getInstance()->assign('args',$args);
        \tpl::getInstance()->display('welcome');
    }

}