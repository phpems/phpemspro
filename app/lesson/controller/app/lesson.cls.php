<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace lesson\controller\app;

use finance\model\orders;
use lesson\model\lessons;

class lesson
{
    public function __construct()
    {
        //
    }

    public function open()
    {
        $lessonid = \route::get('lessonid');
        $lesson = lessons::getLessonById($lessonid);
        $prices = 0;
        if(trim($lesson['lessonprice']))
        {
            $prices = array();
            $lesson['lessonprice'] = explode("\n",$lesson['lessonprice']);
            foreach($lesson['lessonprice'] as $p)
            {
                if($p)
                {
                    $p = explode(":",$p);
                    $prices[] = array('name'=>$p[0],'time'=>$p[1],'price'=>floatval($p[2]));
                }
            }
            \tpl::getInstance()->assign('prices',$prices);
        }
        if(\route::get('openlesson'))
        {
            $paytype = \route::get('paytype');
            $opentype = intval(\route::get('opentype'));
            $args = array();
            $args['orderprice'] = floatval($prices[$opentype]['price']);
            $args['ordername'] = "{$lesson['lessonname']}{$prices[$opentype]['name']}";
            $args['orderitems'] = array(
                array(
                    'lessonid' => $lesson['lessonid'],
                    'lessonname' => $lesson['lessonname'],
                    'time' => $prices[$opentype]['time'],
                    'price' => $prices[$opentype]['price']
                )
            );
            $args['ordersn'] = date('YmdHi').rand(100,999);
            $args['orderstatus'] = 1;
            $args['orderusername'] = \lesson\app::$_user['sessionusername'];
            $args['ordertime'] = TIME;
            $args['ordertype'] = 'lesson';
            orders::addOrder($args);
            $message = array(
                'statusCode' => 200,
                "message" => "下单成功！",
                "callbackType" => "forward",
                "forwardUrl" => 'index.php?user-app-orders-detail&ordersn='.$args['ordersn']
            );
            \route::urlJump($message);
        }
        else
        {
            \tpl::getInstance()->assign('lesson',$lesson);
            \tpl::getInstance()->display('lesson');
        }
    }

    public function index()
    {
        $lessonid = \route::get('lessonid');
        $videoid = \route::get('videoid');
        $lesson = lessons::getLessonById($lessonid);
        if($lesson['lessondemo'])
        {
            $status = true;
        }
        else
        {
            $status = lessons::isLessonMember(\lesson\app::$_user['sessionusername'],$lessonid);
            if($status && strtotime($status['oplendtime']) >= TIME)
            {
                $status = true;
            }
            else
            {
                $status = false;
            }
        }
        if(!$status && $videoid)
        {
            $message = array(
                'statusCode' => 200,
                "message" => "您需要开通课程才能继续学习！",
                "callbackType" => "forward",
                "forwardUrl" => 'index.php?lesson-app-lesson-open&lessonid='.$lessonid
            );
            \route::urlJump($message);
        }
        $args = array(
            array("AND","videolesson = :videolesson","videolesson",$lessonid)
        );
        $videos = lessons::getVideosByArgs($args);
        foreach($videos as $v)
        {
            if(!$videoid)
            {
                $video = $v;
                break;
            }
            else
            {
                if($videoid == $v['videoid'])
                {
                    $video = $v;
                }
            }
        }
        \tpl::getInstance()->assign('videoid',$videoid);
        \tpl::getInstance()->assign('video',$video);
        \tpl::getInstance()->assign('videos',$videos);
        \tpl::getInstance()->assign('lesson',$lesson);
        \tpl::getInstance()->assign('status',$status);
        \tpl::getInstance()->display('video_default');
    }
}