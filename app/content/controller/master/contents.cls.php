<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace content\controller\master;

use content\model\content;
use database\model\database;
use database\model\model;

class contents
{
    public function __construct()
    {
        $search = \route::get('search');
        if($search)
        {
            $this->u = '';
            $this->search = $search;
            \tpl::getInstance()->assign('search',$search);
            foreach($search as $key => $arg)
            {
                $this->u .= "&search[{$key}]={$arg}";
            }
            unset($search);
        }
    }

    public function catsmenu()
    {
        $catid = \route::get('catid');
        $categories = \core\model\category::getAllCategory('content');
        $r = array();
        \core\model\category::levelCategory($r,0,\core\model\category::$tidyCategory['content'],$catid,'index.php?content-master-contents&catid=');
        \core\model\category::resetCategoryIndex($r);
        echo 'var treeData = '.json_encode($r);
        exit();
    }

    public function movecategory()
    {
        $contentids = explode(',',\route::get('contentids'));
        $targetcatid = \route::get('targetcatid');
        if($targetcatid) {
            foreach ($contentids as $key => $id) {
                if ($id) content::modifyContent($id, array('contentcatid' => $targetcatid));
            }
        }
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function order()
    {
        if(\route::get('ordercontent'))
        {
            switch(\route::get('action'))
            {
                case 'order':
                    $ids = \route::get('ids');
                    foreach($ids as $key=>$p)
                    {
                        content::modifyContent($key,array('contentorder' => $p));
                    }
                    break;

                case 'move':
                    $contentids = array();
                    $ids = \route::get('delids');
                    foreach($ids as $key => $id)
                    {
                        if($key)$contentids[] = $key;
                    }
                    $contentids = implode(',',$contentids);
                    $parentcat = \core\model\category::getCategoriesByArgs(array(array("AND","catparent = 0"),array('AND',"catapp = 'content'")));
                    \tpl::getInstance()->assign('parentcat',$parentcat);
                    \tpl::getInstance()->assign('contentids',$contentids);
                    \tpl::getInstance()->display('content_move');
                    exit;
                    break;

                case 'delete':
                    $ids = \route::get('delids');
                    foreach($ids as $key=>$p)
                    {
                        content::delContent($key);
                    }
                    break;

                default:
                    break;
            }
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
        $contentid = \route::get('contentid');
        $content = content::getContentById($contentid);
        $model = model::getModelByCode($content['contentmodelcode']);
        $properties = \database\model\model::getAllowPropertiesByModelcode($content['contentmodelcode'],1);
        if(\route::get('modifycontent'))
        {
            $args = \route::get('args');
            $args = \database\model\model::callModelFieldsFilter($args,$properties);
            content::modifyContent($contentid,$args);
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
            foreach(glob("app/content/view/app/content_*.tpl") as $p)
            {
                $tpls[] = substr(basename($p),0,-4);
            }
            $forms = \html::buildHtml($properties,$content);
            \tpl::getInstance()->assign('forms',$forms);
            \tpl::getInstance()->assign('model',$model);
            \tpl::getInstance()->assign('content',$content);
            \tpl::getInstance()->assign('tpls',$tpls);
            \tpl::getInstance()->display('content_modify');
        }
    }

    public function del()
    {
        $contentid = \route::get('contentid');
        content::delContent($contentid);
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
        $modelcode = \route::get('modelcode');
        $model = model::getModelByCode($modelcode);
        if(\route::get('addcontent'))
        {
            $args = \route::get('args');
            $args['contentauthor'] = \content\master::$_user['sessionusername'];
            $args['contentmodelcode'] = $modelcode;
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode,1);
            $args = \database\model\model::callModelFieldsFilter($args,$properties);
            content::addContent($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?content-master-contents"
            );
            exit(json_encode($message));
        }
        else
        {
            $tpls = array();
            foreach(glob("app/content/view/app/content_*.tpl") as $p)
            {
                $tpls[] = substr(basename($p),0,-4);
            }
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode,1);
            $forms = \html::buildHtml($properties);
            \tpl::getInstance()->assign('forms',$forms);
            \tpl::getInstance()->assign('model',$model);
            \tpl::getInstance()->assign('tpls',$tpls);
            \tpl::getInstance()->display('content_add');
        }
    }

    public function addpage()
    {
        $models = model::getModelsByApp('content');
        $categories = \core\model\category::getAllCategory('content');
        \tpl::getInstance()->assign('categories',$categories);
        \tpl::getInstance()->assign('models',$models);
        \tpl::getInstance()->display('content_addpage');
    }

    public function index()
    {
        $catid = intval(\route::get('catid'));
        $page = intval(\route::get('page'));
        $page = $page?$page:1;
        if(!$catid)$catid = $this->search['contentcatid'];
        $categories = \core\model\category::getAllCategory('content');
        $parentcat = \core\model\category::getCategoriesByArgs(array(array("AND","catparent = 0"),array("AND","catapp = 'content'")));
        if($catid)
        {
            $childstring = \core\model\category::getChildCategoryString('content',$catid);
            $args = array(array("AND","find_in_set(contentcatid,:contentcatid)",'contentcatid',$childstring));
        }
        else $args = array();
        if($this->search['contentid'])
        {
            $args[] = array("AND","contentid = :contentid",'contentid',$this->search['contentid']);
        }
        else
        {
            if($this->search['contentcatid'])$args[] = array("AND","contentcatid = :contentcatid",'contentcatid',$this->search['contentcatid']);
            if($this->search['contentmodelid'])$args[] = array("AND","contentmodelid = :contentmodelid",'contentmodelid',$this->search['contentmodelid']);
            if($this->search['stime'])$args[] = array("AND","contenttime >= :scontentinputtime",'scontentinputtime',strtotime($this->search['stime']));
            if($this->search['etime'])$args[] = array("AND","contenttime <= :econtentinputtime",'econtentinputtime',strtotime($this->search['etime']));
            if($this->search['keyword'])$args[] = array("AND","contenttitle LIKE :contenttitle",'contenttitle',"%{$this->search['keyword']}%");
            if($this->search['username'])
            {
                $args[] = array("AND","contentauthor = :contentauthor",'contentauthor',$this->search['username']);
            }
        }
        $contents = \content\model\content::getContentList($args,$page);
        $models = model::getModelsByApp('content');
        $catlevel = 1;
        if($catid)
        {
            $pos = \core\model\category::getCategoryPos('content',$catid);
            if(count($pos))
            {
                $catlevel = count($pos) + 1;
            }
        }
        \tpl::getInstance()->assign('catlevel',$catlevel);
        \tpl::getInstance()->assign('models',$models);
        \tpl::getInstance()->assign('catid',$catid);
        \tpl::getInstance()->assign('contents',$contents);
        \tpl::getInstance()->assign('parentcat',$parentcat);
        \tpl::getInstance()->assign('categories',$categories);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('content');
    }
}