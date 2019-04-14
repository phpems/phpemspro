<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace lesson\controller\master;

use database\model\database;
use database\model\model;

class lessons
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
        $categories = \core\model\category::getAllCategory('lesson');
        $r = array();
        \core\model\category::levelCategory($r,0,\core\model\category::$tidyCategory['lesson'],$catid,'index.php?lesson-master-lessons&catid=');
        \core\model\category::resetCategoryIndex($r);
        echo 'var treeData = '.json_encode($r);
        exit();
    }

    public function delvideo()
    {
        $videoid = \route::get('videoid');
        \lesson\model\lessons::delVideo($videoid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function modifyvideo()
    {
        $videoid = \route::get('videoid');
        $video = \lesson\model\lessons::getVideoById($videoid);
        $model = model::getModelByCode($video['videomodelcode']);
        $properties = \database\model\model::getAllowPropertiesByModelcode($video['videomodelcode'],1);
        if(\route::get('modifyvideo'))
        {
            $args = \route::get('args');
            $args = \database\model\model::callModelFieldsFilter($args,$properties);
            \lesson\model\lessons::modifyVideo($videoid,$args);
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
            foreach(glob("app/lesson/view/app/video_*.tpl") as $p)
            {
                $tpls[] = substr(basename($p),0,-4);
            }
            $forms = \html::buildHtml($properties,$video);
            $lesson = \lesson\model\lessons::getLessonById($video['videolesson']);
            \tpl::getInstance()->assign('lesson',$lesson);
            \tpl::getInstance()->assign('forms',$forms);
            \tpl::getInstance()->assign('model',$model);
            \tpl::getInstance()->assign('video',$video);
            \tpl::getInstance()->assign('tpls',$tpls);
            \tpl::getInstance()->display('video_modify');
        }
    }

    public function addvideo()
    {
        $lessonid = \route::get('lessonid');
        $lesson = \lesson\model\lessons::getLessonById($lessonid);
        $modelcode = \route::get('modelcode');
        $model = model::getModelByCode($modelcode);
        if(\route::get('addvideo'))
        {
            $args = \route::get('args');
            $args['videoauthor'] = \content\master::$_user['sessionusername'];
            $args['videomodelcode'] = $modelcode;
            $args['videolesson'] = $lessonid;
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode,1);
            $args = \database\model\model::callModelFieldsFilter($args,$properties);
            \lesson\model\lessons::addVideo($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?lesson-master-lessons-videos&lessonid={$lessonid}"
            );
            exit(json_encode($message));
        }
        else
        {
            $tpls = array();
            foreach(glob("app/lesson/view/app/video_*.tpl") as $p)
            {
                $tpls[] = substr(basename($p),0,-4);
            }
            $properties = \database\model\model::getAllowPropertiesByModelcode($modelcode,1);
            $forms = \html::buildHtml($properties);
            \tpl::getInstance()->assign('forms',$forms);
            \tpl::getInstance()->assign('model',$model);
            \tpl::getInstance()->assign('lesson',$lesson);
            \tpl::getInstance()->assign('tpls',$tpls);
            \tpl::getInstance()->display('video_add');
        }
    }

    public function addpage()
    {
        $lessonid = \route::get('lessonid');
        $models = model::getModelsByApp('lesson');
        $categories = \core\model\category::getAllCategory('lesson');
        \tpl::getInstance()->assign('categories',$categories);
        \tpl::getInstance()->assign('lessonid',$lessonid);
        \tpl::getInstance()->assign('models',$models);
        \tpl::getInstance()->display('video_addpage');
    }

    public function ordervideo()
    {
        if(\route::get('ordervideo'))
        {
            switch(\route::get('action'))
            {
                case 'order':
                    $ids = \route::get('ids');
                    foreach($ids as $key => $value)
                    {
                        \lesson\model\lessons::modifyVideo($key,array('videoorder' => $value));
                    }
                    break;

                case 'delete':
                    $delids = \route::get('delids');
                    foreach($delids as $key => $id)
                    {
                        \lesson\model\lessons::delVideo($key);
                    }
                    break;

                default:
                    break;
            }
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
    }

    public function videos()
    {
        $page = intval(\route::get('page'));
        $page = $page >1?$page:1;
        $lessonid = \route::get('lessonid');
        $lesson = \lesson\model\lessons::getLessonById($lessonid);
        $args = array(
            array("AND","videolesson = :videolesson","videolesson",$lessonid)
        );
        $videos = \lesson\model\lessons::getVideoList($args,$page);
        \tpl::getInstance()->assign('lesson',$lesson);
        \tpl::getInstance()->assign('videos',$videos);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('video');
    }

    public function del()
    {
        $lessonid = \route::get('lessonid');
        $number = \lesson\model\lessons::getVideosNumber($lessonid);
        if($number)
        {
            $message = array(
                'statusCode' => 300,
                "message" => "请先删除此课程下所有课件"
            );
            exit(json_encode($message));
        }
        \lesson\model\lessons::delLesson($lessonid);
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
        $lessonid = \route::get('lessonid');
        $lesson = \lesson\model\lessons::getLessonById($lessonid);
        if(\route::get('modifylesson'))
        {
            $args = \route::get('args');
            \lesson\model\lessons::modifyLesson($lessonid,$args);
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
            \tpl::getInstance()->assign('lesson',$lesson);
            \tpl::getInstance()->display('lesson_modify');
        }
    }

    public function add()
    {
        if(\route::get('addlesson'))
        {
            $args = \route::get('args');
            $args['lessontime'] = TIME;
            \lesson\model\lessons::addLesson($args);
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "index.php?lesson-master-lessons"
            );
            exit(json_encode($message));
        }
        else
        {
            $parentcat = \core\model\category::getCategoriesByArgs(array(array("AND","catparent = 0"),array("AND","catapp = 'lesson'")));
            \tpl::getInstance()->assign('parentcat',$parentcat);
            \tpl::getInstance()->display('lesson_add');
        }
    }

    public function order()
    {
        if(\route::get('orderlesson'))
        {
            switch(\route::get('action'))
            {
                case 'order':
                    $ids = \route::get('ids');
                    foreach($ids as $key => $value)
                    {
                        \lesson\model\lessons::modifyLesson($key,array('lessonorder' => $value));
                    }
                    break;

                case 'delete':
                    $delids = \route::get('delids');
                    foreach($delids as $key => $id)
                    {
                        $number = \lesson\model\lessons::getVideosNumber($key);
                        if($number)
                        {
                            $message = array(
                                'statusCode' => 300,
                                "message" => "操作失败，请删除课程下的所有课件"
                            );
                            exit(json_encode($message));
                        }
                        \lesson\model\lessons::delLesson($key);
                    }
                    break;

                default:
                    break;
            }
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
    }

    public function removemember()
    {
        $oplid = \route::get('oplid');
        \lesson\model\lessons::delLessonMember($oplid);
        $message = array(
            'statusCode' => 200,
            "message" => "操作成功",
            "callbackType" => "forward",
            "forwardUrl" => "reload"
        );
        exit(json_encode($message));
    }

    public function addmember()
    {
        $lessonid = \route::get('lessonid');
        $lesson = \lesson\model\lessons::getLessonById($lessonid);
        if(\route::get('addmember'))
        {
            $delids = \route::get('delids');
            $days = \route::get('days');
            $number = array('new' => 0,'old' => 0);
            foreach($delids as $key => $p)
            {
                $user = \user\model\users::getUserById($key);
                $r = \lesson\model\lessons::openLesson($user['username'],$lessonid,$days);
                if($r)
                $number['old']++;
                else
                $number['new']++;
            }
            $message = array(
                'statusCode' => 200,
                "message" => "操作成功，新开通{$number['new']}人，延长时间{$number['old']}人",
                "callbackType" => "forward",
                "forwardUrl" => "reload"
            );
            exit(json_encode($message));
        }
        else
        {
            $page = \route::get('page');
            $page = $page >= 1?$page:1;
            $args = array();
            if($this->search['userid'])$args[] = array('AND',"userid = :userid",'userid',$this->search['userid']);
            if($this->search['username'])$args[] = array('AND',"username LIKE :username",'username','%'.$this->search['username'].'%');
            if($this->search['useremail'])$args[] = array('AND',"useremail  LIKE :useremail",'useremail','%'.$this->search['useremail'].'%');
            if($this->search['userphone'])$args[] = array('AND',"userphone  LIKE :userphone",'userphone','%'.$this->search['userphone'].'%');
            if($this->search['groupcode'])$args[] = array('AND',"usergroupcode = :usergroupcode",'usergroupcode',$this->search['groupcode']);
            if($this->search['stime'] || $this->search['etime'])
            {
                if(!is_array($args))$args = array();
                if($this->search['stime']){
                    $stime = strtotime($this->search['stime']);
                    $args[] = array('AND',"userregtime >= :stime",'stime',$stime);
                }
                if($this->search['etime']){
                    $etime = strtotime($this->search['etime']);
                    $args[] = array('AND',"userregtime <= :etime",'etime',$etime);
                }
            }
            $users = \user\model\users::getUsersList($args,$page);
            $groups = \user\model\users::getGroups();
            \tpl::getInstance()->assign('lesson',$lesson);
            \tpl::getInstance()->assign('users',$users);
            \tpl::getInstance()->assign('groups',$groups);
            \tpl::getInstance()->display('lesson_addmember');
        }
    }

    public function members()
    {
        $lessonid = \route::get('lessonid');
        $lesson = \lesson\model\lessons::getLessonById($lessonid);
        $page = \route::get('page');
        $page = $page > 0?$page:1;
        $groups = \user\model\users::getGroups();
        $args = array();
        $args[] = array("AND","opllessonid = :opllessonid","opllessonid",$lessonid);
        if($this->search['stime'])
        {
            $args[] = array("AND",'opltime >= :stime','stime',strtotime($this->search['stime']));
        }
        if($this->search['etime'])
        {
            $args[] = array("AND",'opltime >= :etime','etime',strtotime($this->search['etime']));
        }
        if($this->search['username'])
        {
            $args[] = array("AND",'oplusername LIKE :username','username','%'.$this->search['username'].'%');
        }
        $members = \lesson\model\lessons::getLessonMemberList($args,$page);
        \tpl::getInstance()->assign('groups',$groups);
        \tpl::getInstance()->assign('lesson',$lesson);
        \tpl::getInstance()->assign('members',$members);
        \tpl::getInstance()->display('lesson_members');
    }

    public function index()
    {
        $catid = intval(\route::get('catid'));
        $page = intval(\route::get('page'));
        $page = $page?$page:1;
        if(!$catid)$catid = $this->search['lessoncatid'];
        $categories = \core\model\category::getAllCategory('lesson');
        $parentcat = \core\model\category::getCategoriesByArgs(array(array("AND","catparent = 0"),array("AND","catapp = 'lesson'")));
        if($catid)
        {
            $childstring = \core\model\category::getChildCategoryString('lesson',$catid);
            $args = array(array("AND","find_in_set(lessoncatid,:lessoncatid)",'lessoncatid',$childstring));
        }
        else $args = array();
        if($this->search['lessonid'])
        {
            $args[] = array("AND","lessonid = :lessonid",'lessonid',$this->search['lessonid']);
        }
        else
        {
            if($this->search['lessoncatid'])$args[] = array("AND","contentcatid = :contentcatid",'lessoncatid',$this->search['lessoncatid']);
            if($this->search['lessonmodelid'])$args[] = array("AND","contentmodelid = :contentmodelid",'lessonmodelid',$this->search['lessonmodelid']);
            if($this->search['stime'])$args[] = array("AND","contenttime >= :scontentinputtime",'scontentinputtime',strtotime($this->search['stime']));
            if($this->search['etime'])$args[] = array("AND","contenttime <= :econtentinputtime",'econtentinputtime',strtotime($this->search['etime']));
            if($this->search['keyword'])$args[] = array("AND","contenttitle LIKE :contenttitle",'lessontitle',"%{$this->search['keyword']}%");
            if($this->search['username'])
            {
                $args[] = array("AND","contentauthor = :contentauthor",'lessonauthor',$this->search['username']);
            }
        }
        $lessons = \lesson\model\lessons::getLessonList($args,$page);
        $catlevel = 1;
        if($catid)
        {
            $pos = \core\model\category::getCategoryPos('lesson',$catid);
            if(count($pos))
            {
                $catlevel = count($pos) + 1;
            }
        }
        \tpl::getInstance()->assign('catlevel',$catlevel);
        \tpl::getInstance()->assign('catid',$catid);
        \tpl::getInstance()->assign('lessons',$lessons);
        \tpl::getInstance()->assign('parentcat',$parentcat);
        \tpl::getInstance()->assign('categories',$categories);
        \tpl::getInstance()->assign('page',$page);
        \tpl::getInstance()->display('lesson');
    }
}