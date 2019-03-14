<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace content\controller\master;

class category
{
    public function __construct()
    {
        //
    }

    public function order()
    {
        $ids = \route::get('ids');
        foreach($ids as $key=>$p)
        {
            \core\model\category::modifyCategory($key,array('catorder' => $p));
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function modify()
    {
        $catid = \route::get('catid');
        $category = \core\model\category::getCategoryById($catid);
        if(\route::get('modifycategory'))
        {
            $args = \route::get('args');
            \core\model\category::modifyCategory($catid,$args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            $tpls = array();
            foreach(glob("app/content/view/app/category_*.tpl") as $p)
            {
                $tpls[] = substr(basename($p),0,-4);
            }
            \tpl::getInstance()->assign('category',$category);
            \tpl::getInstance()->assign('tpls',$tpls);
            \tpl::getInstance()->display('category_modify');
        }
    }

    public function del()
    {
        $catid = \route::get('catid');
        $catchild = \core\model\category::getChildCategoryString('content',$catid,false);
        if($catchild)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "操作失败，请先删除本分类下的子分类"
            );
            exit(json_encode($message));
        }
        \core\model\category::delCategory($catid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function add()
    {
        if(\route::get('addcategory'))
        {
            $args = \route::get('args');
            $args['catapp'] = 'content';
            \core\model\category::addCategory($args);
            if($args['catparent'])
            {
                $parent = \core\model\category::getCategoryById($args['catparent']);
                $parent = intval($parent['catparent']);
            }
            else $parent = 0;
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?content-master-category&parent={$parent}"
            );
            exit(json_encode($message));
        }
        else
        {
            $parent = \route::get('parent');
            $tpls = array();
            foreach(glob("app/content/view/app/category_*.tpl") as $p)
            {
                $tpls[] = substr(basename($p),0,-4);
            }
            \tpl::getInstance()->assign('parent',\core\model\category::getCategoryById($parent));
            \tpl::getInstance()->assign('tpls',$tpls);
            \tpl::getInstance()->display('category_add');
        }
    }

    public function index()
    {
        $page = intval(\route::get('page'));
        $page = $page?$page:1;
        $parent = intval(\route::get('parent'));
        $args = array();
        $args[] = array("AND","catparent = :catparent",'catparent',$parent);
        $args[] = array("AND","catapp = :catapp",'catapp','content');
        $categorys = \core\model\category::getCategoryList($args,$page);
        $categories = \core\model\category::getAllCategory('content');
        \tpl::getInstance()->assign('parent',$parent);
        \tpl::getInstance()->assign('categorys',$categorys);
        \tpl::getInstance()->assign('categories',$categories);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('category');
    }
}