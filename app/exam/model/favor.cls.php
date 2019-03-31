<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace exam\model;

class favor
{
    static function getNoteNumberByPointid($dbid,$username,$pointid)
    {
        $data = array(
            'select' => 'count(*) as number',
            'table' => array('notes','questions'),
            'query' => array(
                array("AND","noteusername = :noteusername","noteusername",$username),
                array("AND","find_in_set(:questionpoints,questionpoints)","questionpoints",$pointid),
                array("AND","notequestionid = questionid")
            )
        );
        $r = \pepdo::getInstance($dbid)->getElement($data);
        return $r['number'];
    }

    static function delNotesByUsername($dbid,$username)
    {
        $data = array(
            'table' => 'notes',
            'query' => array(
                array("AND","noteusername = :noteusername","noteusername",$username)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function getNoteQuestionsByPointid($dbid,$username,$pointid)
    {
        $data = array(
            'select' => false,
            'table' => array('notes','questions'),
            'query' => array(
                array("AND","noteusername = :noteusername","noteusername",$username),
                array("AND","find_in_set(:questionpoints,questionpoints)","questionpoints",$pointid),
                array("AND","notequestionid = questionid")
            )
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }

    static function getNoteList($dbid,$args,$page,$number = \config::webpagenumber,$orderby = 'noteid desc')
    {
        $data = array(
            'table' => 'notes',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($dbid)->listElements($page,$number,$data);
    }

    static function getNoteByUserAndQuestionid($dbid,$username,$questionid)
    {
        $data = array(
            'table' => 'notes',
            'query' => array(
                array("AND","noteusername = :noteusername","noteusername",$username),
                array("AND","notequestionid = :notequestionid","notequestionid",$questionid)
            )
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function saveNote($dbid,$args)
    {
        $data = array(
            'table' => 'notes',
            'query' => array(
                array("AND","noteusername = :noteusername","noteusername",$args['noteusername']),
                array("AND","notequestionid = :notequestionid","notequestionid",$args['notequestionid'])
            )
        );
        $r = \pepdo::getInstance($dbid)->getElement($data);
        if($args['notecontent'])
        {
            if($r['noteid'])
            {
                $data = array(
                    'table' => 'notes',
                    'value' => $args,
                    'query' => array(array("AND","noteid = :noteid","noteid",$r['noteid']))
                );
                \pepdo::getInstance($dbid)->updateElement($data);
            }
            else
            {
                $data = array(
                    'table' => 'notes',
                    'query' => $args
                );
                \pepdo::getInstance($dbid)->insertElement($data);
            }
        }
        else
        {
            if($r['noteid'])
            {
                $data = array(
                    'table' => 'notes',
                    'query' => array(array("AND","noteid = :noteid","noteid",$r['noteid']))
                );
                \pepdo::getInstance($dbid)->delElement($data);
            }
        }
    }

    static function modifyNote($dbid,$id,$args)
    {
        $data = array(
            'table' => 'notes',
            'value' => $args,
            'query' => array(array("AND","noteid = :noteid","noteid",$id))
        );
        \pepdo::getInstance($dbid)->updateElement($data);
    }

    static function delNote($dbid,$id)
    {
        $data = array(
            'table' => 'notes',
            'query' => array(array("AND","noteid = :noteid","noteid",$id))
        );
        \pepdo::getInstance($dbid)->delElement($data);
    }

    static function saveSingleRecord($dbid,$username,$pointid,$questionid,$answer)
    {
        $data = self::getRecordSession($dbid,$username);
        $questypes = question::getQuestypesByArgs();
        $question = question::getQuestionById($dbid,$questionid);
        unset($data['recordright'][$pointid][$questionid]);
        unset($data['recordwrong'][$pointid][$questionid]);
        if($questypes[$question['questiontype']]['questsort'])
        {
            if($answer == 'A')
            {
                $data['recordright'][$pointid][$questionid] = 'A';
            }
            else
            {
                $data['recordwrong'][$pointid][$questionid] = 'B';
            }
        }
        else
        {
            if(is_array($answer))
            {
                $tmp = implode('',$answer);
            }
            else
            {
                $tmp = $answer;
            }
            if($tmp == $question['questionanswer'])
            {
                $data['recordright'][$pointid][$questionid] = $tmp;
            }
            else
            {
                $data['recordwrong'][$pointid][$questionid] = $tmp;
            }
        }
        $data['recordnumber'][$pointid] = array(
            'right' => count($data['recordright'][$pointid]),
            'wrong' => count($data['recordwrong'][$pointid])
        );
        self::setRecordSession($dbid,$username,$data);
        return true;
    }

    static function saveRecord($dbid,$username,$pointid,$questions)
    {
        $ids = array();
        foreach($questions as $key => $question)
        {
            $ids[] = $key;
        }
        $ids = implode(',',$ids);
        $answers = question::getQuestionsByArgs($dbid,array(array("AND","find_in_set(questionid,:questionid)","questionid",$ids)),false,"questionid,questiontype,questionanswer");
        $right = array();
        $wrong = array();
        $questypes = question::getQuestypesByArgs();
        foreach($answers as $p)
        {
            if($questypes[$p['questiontype']]['questsort'])
            {
                if($questions[$p['questionid']] == 'A')
                {
                    $right[$p['questionid']] = 'A';
                }
                else
                {
                    $wrong[$p['questionid']] = 'B';
                }
            }
            else
            {
                if(is_array($questions[$p['questionid']]))
                {
                    $tmp = implode('',$questions[$p['questionid']]);
                }
                else
                {
                    $tmp = $questions[$p['questionid']];
                }
                if($tmp == $p['questionanswer'])
                {
                    $right[$p['questionid']] = $tmp;
                }
                else
                {
                    $wrong[$p['questionid']] = $tmp;
                }
            }
        }
        $data = self::getRecordSession($dbid,$username);
        $data['recordright'][$pointid] = $right;
        $data['recordwrong'][$pointid] = $wrong;
        $data['recordnumber'][$pointid] = array(
            'right' => count($right),
            'wrong' => count($wrong)
        );
        self::setRecordSession($dbid,$username,$data);
        return true;
    }

    static function getRecordSession($dbid,$username)
    {
        $r = json_decode(\pedis::getInstance()->getHashData('records',$username.'-'.$dbid),true);
        if(!$r)
        {
            $r = self::getRecordByUsername($dbid,$username);
            \pedis::getInstance()->setHashData('records',$username.'-'.$dbid,json_encode($r));
        }
        return $r;
    }

    static function setRecordSession($dbid,$username,$args)
    {
        \pedis::getInstance()->setHashData('records',$username.'-'.$dbid,json_encode($args));
        if(rand(1,10) == 5)
        {
            $args['recordusername'] = $username;
            self::setRecord($dbid,$args);
        }
    }

    static function getRecordByUsername($dbid,$username)
    {
        $data = array(
            'table' => 'records',
            'query' => array(
                array("AND","recordusername = :recordusername","recordusername",$username)
            )
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function setRecord($dbid,$args)
    {
        $r = self::getRecordByUsername($dbid,$args['recordusername']);
        if($r['recordid'])
        {
            $data = array(
                'table' => 'records',
                'value' => $args,
                'query' => array(
                    array("AND","recordid = :recordid","recordid",$r['recordid'])
                )
            );
            \pepdo::getInstance($dbid)->updateElement($data);
        }
        else
        {
            $data = array(
                'table' => 'records',
                'query' => $args
            );
            \pepdo::getInstance($dbid)->insertElement($data);
        }
    }

    static function delRecord($dbid,$username)
    {
        $data = array(
            'table' => 'records',
            'query' => array(
                array("AND","recordusername = :recordusername","recordusername",$username)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function getFavorNumberByPointid($dbid,$username,$pointid)
    {
        $data = array(
            'select' => 'count(*) as number',
            'table' => array('favors','questions'),
            'query' => array(
                array("AND","favorusername = :favorusername","favorusername",$username),
                array("AND","find_in_set(:questionpoints,questionpoints)","questionpoints",$pointid),
                array("AND","favorquestionid = questionid")
            )
        );
        $r = \pepdo::getInstance($dbid)->getElement($data);
        return $r['number'];
    }

    static function getFavorQuestionsByPointid($dbid,$username,$pointid)
    {
        $data = array(
            'select' => false,
            'table' => array('favors','questions'),
            'query' => array(
                array("AND","favorusername = :favorusername","favorusername",$username),
                array("AND","find_in_set(:questionpoints,questionpoints)","questionpoints",$pointid),
                array("AND","favorquestionid = questionid")
            )
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }

    static function getFavorById($dbid,$id)
    {
        $data = array(
            'table' => 'favors',
            'query' => array(
                array("AND","favorid = :favorid","favorid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function getFavorByQuestionIds($dbid,$ids,$username)
    {
        $data = array(
            'table' => 'favors',
            'query' => array(
                array("AND","find_in_set(favorquestionid,:favorquestionid)","favorquestionid",$ids),
                array("AND","favorusername = :username","username",$username)
            ),
            'index' => 'favorquestionid'
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }

    static function favorQuestion($dbid,$username,$questionid)
    {
        $data = array(
            'table' => 'favors',
            'query' => array(
                array("AND","favorusername = :favorusername","favorusername",$username),
                array("AND","favorquestionid = :favorquestionid","favorquestionid",$questionid)
            )
        );
        $r = \pepdo::getInstance($dbid)->getElement($data);
        if(!$r['favorid'])
        {
            $args = array();
            $args['favorquestionid'] = $questionid;
            $args['favorusername'] = $username;
            $args['favortime'] = TIME;
            self::addFavor($dbid,$args);
        }
    }

    static function delFavor($dbid,$username,$questionid)
    {
        $data = array(
            'table' => 'favors',
            'query' => array(
                array("AND","favorusername = :favorusername","favorusername",$username),
                array("AND","favorquestionid = :favorquestionid","favorquestionid",$questionid)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function delFavorsByUsername($dbid,$username)
    {
        $data = array(
            'table' => 'favors',
            'query' => array(
                array("AND","favorusername = :favorusername","favorusername",$username)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function addFavor($dbid,$args)
    {
        $data = array(
            'table' => 'favors',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->insertElement($data);
    }

    static function getFavorList($dbid,$args,$page,$number = \config::webpagenumber,$orderby = 'favorid desc')
    {
        $data = array(
            'table' => 'favors',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($dbid)->listElements($page,$number,$data);
    }

    static function getExamHistoryById($dbid,$id)
    {
        $data = array(
            'table' => 'examhistory',
            'query' => array(
                array("AND","ehid = :ehid","ehid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->getElement($data);
    }

    static function getExamHistoriesByArgs($dbid,$args)
    {
        $data = array(
            'table' => 'examhistory',
            'query' => $args,
            'limit' => false
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }

    static function delExamHistory($dbid,$id)
    {
        $data = array(
            'table' => 'examhistory',
            'query' => array(
                array("AND","ehid = :ehid","ehid",$id)
            )
        );
        return \pepdo::getInstance($dbid)->delElement($data);
    }

    static function addExamHistory($dbid,$args)
    {
        $data = array(
            'table' => 'examhistory',
            'query' => $args
        );
        return \pepdo::getInstance($dbid)->insertElement($data);
    }

    static function modifyExamHistory($dbid,$id,$args)
    {
        $data = array(
            'table' => 'examhistory',
            'value' => $args,
            'query' => array(
                array("AND","ehid = :ehid","ehid",$id)
            )
        );
        \pepdo::getInstance($dbid)->updateElement($data);
    }

    static function getExamHistoryList($dbid,$args,$page,$number = \config::webpagenumber,$fields = false,$orderby = 'ehid desc')
    {
        $data = array(
            'select' => $fields,
            'table' => 'examhistory',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($dbid)->listElements($page,$number,$data);
    }

    static function getUserExamHistoryList($dbid,$args,$page,$number = \config::webpagenumber,$orderby = 'ehid desc')
    {
        $args[] = array("AND","ehusername = username");
        $data = array(
            'table' => array('examhistory','users'),
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($dbid)->listElements($page,$number,$data);
    }

    static function outUserExamHistory($dbid,$args,$fields = false,$orderby = 'ehid desc')
    {
        $args[] = array("AND","ehusername = username");
        $data = array(
            'select' => $fields,
            'table' => array('examhistory','users'),
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($dbid)->getElements($data);
    }
}