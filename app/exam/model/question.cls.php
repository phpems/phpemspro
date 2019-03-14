<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/12/10
 * Time: 18:29
 */

namespace exam\model;


class question
{
    static function getQuestypeById($id)
    {
        $data = array(
            'table' => 'questypes',
            'query' => array(
                array("AND","questid = :questid","questid",$id)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }

    static function getQuestypesByArgs($args = array())
    {
        $data = array(
            'table' => 'questypes',
            'query' => $args,
            'index' => 'questcode',
            'orderby' => 'questid asc',
            'limit' => false
        );
        return \pepdo::getInstance()->getElements($data);
    }

    static function modifyQuestypeById($id,$args)
    {
        $data = array(
            'table' => 'questypes',
            'value' => $args,
            'query' => array(
                array("AND","questid = :questid","questid",$id)
            )
        );
        return \pepdo::getInstance()->updateElement($data);
    }

    static function addQuestype($args)
    {
        $data = array(
            'table' => 'questypes',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static function delQuestype($id)
    {
        $data = array(
            'table' => 'questypes',
            'query' => array(
                array("AND","questid = :questid","questid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function getQuestionList($db,$args,$page,$number = \config::webpagenumber,$orderby = 'questionid desc')
    {
        $data = array(
            'table' => 'questions',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($db)->listElements($page,$number,$data);
    }

    static function getQuestionRowsList($db,$args,$page,$number = \config::webpagenumber,$orderby = 'qrid desc')
    {
        $data = array(
            'table' => 'questionrows',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance($db)->listElements($page,$number,$data);
    }

    static function getQuestionIdsByPoint($db,$pointid)
    {
        $result = json_decode(\pedis::getInstance()->getHashData('subjectquestions',$db.'-'.$pointid),true);
        if($result)
        {
            return $result;
        }
        $data = array(
            'select' => 'questionid,questiontype,questionlevel',
            'table' => 'questions',
            'query' => array(array('AND','find_in_set(:pointid,questionpoints)','pointid',$pointid),array("AND","questionparent = 0"),array("AND","questionstatus = 1"))
        );
        $r = \pepdo::getInstance($db)->getElements($data);
        $rs = array();
        foreach($r as $p)
        {
            $rs[$p['questiontype']][$p['questionlevel']][] = $p['questionid'];
        }
        \pedis::getInstance()->setHashData('subjectquestions',$db.'-'.$pointid,json_encode($rs));
        return $rs;
    }

    static function getQuestionRowsIdsByPoint($db,$pointid)
    {
        $result = json_decode(\pedis::getInstance()->getHashData('subjectquestionrows',$db.'-'.$pointid),true);
        if($result)
        {
            return $result;
        }
        $data = array(
            'select' => 'qrid,qrtype,qrlevel,qrnumber',
            'table' => 'questionrows',
            'query' => array(array('AND','find_in_set(:pointid,qrpoints)','pointid',$pointid),array("AND","qrstatus = 1"))
        );
        $r = \pepdo::getInstance($db)->getElements($data);
        $rs = array();
        foreach($r as $p)
        {
            $rs[$p['qrtype']][$p['qrlevel']][$p['qrnumber']][] = $p['qrid'];
        }
        \pedis::getInstance()->setHashData('subjectquestionrows',$db.'-'.$pointid,json_encode($rs));
        return $rs;
    }

    static function getQuestionById($db,$questionid)
    {
        $data = array(
            'table' => 'questions',
            'query' => array(
                array("AND","questionid = :questionid","questionid",$questionid)
            )
        );
        return \pepdo::getInstance($db)->getElement($data);
    }

    static function getQuestionsByArgs($db,$args,$orderby = "questionparent asc,questionorder asc,questionid desc",$select = false)
    {
        $data = array(
            'select' => $select,
            'table' => 'questions',
            'query' => $args,
            'orderby' => $orderby,
            'limit' => false
        );
        return \pepdo::getInstance($db)->getElements($data);
    }

    static function getQuestionRowsByArgs($db,$args,$orderby = "qrid desc")
    {
        $data = array(
            'table' => 'questionrows',
            'query' => $args,
            'orderby' => $orderby,
            'limit' => false
        );
        return \pepdo::getInstance($db)->getElements($data);
    }

    static function getQuestionRowsById($db,$qrid,$withchilid = true)
    {
        $data = array(
            'table' => 'questionrows',
            'query' => array(
                array("AND","qrid = :qrid","qrid",$qrid)
            )
        );
        $r = \pepdo::getInstance($db)->getElement($data);
        if($withchilid)
        $r['data'] = self::getQuestionsByArgs($db,array(array("AND","questionparent = :questionparent","questionparent",$qrid),array("AND","questionstatus = 1")));
        return $r;
    }

    static function modifyQuestion($db,$id,$args)
    {
        $data = array(
            'table' => 'questions',
            'value' => $args,
            'query' => array(
                array("AND","questionid = :questionid","questionid",$id)
            )
        );
        \pepdo::getInstance($db)->updateElement($data);
    }

    static function modifyQuestionRows($db,$id,$args)
    {
        $data = array(
            'table' => 'questionrows',
            'value' => $args,
            'query' => array(
                array("AND","qrid = :qrid","qrid",$id)
            )
        );
        \pepdo::getInstance($db)->updateElement($data);
    }

    static function addQuestion($db,$args)
    {
        $args['questiontime'] = TIME;
        $args['questionstatus'] = 1;
        $data = array(
            'table' => 'questions',
            'query' => $args
        );
        return \pepdo::getInstance($db)->insertElement($data);
    }

    static function addQuestionRows($db,$args)
    {
        $args['qrtime'] = TIME;
        $args['qrstatus'] = 1;
        $data = array(
            'table' => 'questionrows',
            'query' => $args
        );
        return \pepdo::getInstance($db)->insertElement($data);
    }

    static function hideQuestion($db,$id)
    {
        $data = array(
            'table' => 'questions',
            'value' => array('questionstatus' => 0),
            'query' => array(
                array("AND","questionid = :questionid","questionid",$id)
            )
        );
        return \pepdo::getInstance($db)->updateElement($data);
    }

    static function recoverQuestion($db,$id)
    {
        $data = array(
            'table' => 'questions',
            'value' => array('questionstatus' => 1),
            'query' => array(
                array("AND","questionid = :questionid","questionid",$id)
            )
        );
        return \pepdo::getInstance($db)->updateElement($data);
    }

    static function delQuestion($db,$id)
    {
        $question = self::getQuestionById($db,$id);
        $data = array(
            'table' => 'questions',
            'query' => array(
                array("AND","questionid = :questionid","questionid",$id)
            )
        );
        $r = \pepdo::getInstance($db)->delElement($data);
        if($question['questionparent'])
        {
            self::resetRowsQuestionNumber($db,$question['questionparent']);
        }
        return $r;
    }

    static function hideQuestionrows($db,$id)
    {
        $data = array(
            'table' => 'questionrows',
            'value' => array('qrstatus' => 0),
            'query' => array(
                array("AND","qrid = :qrid","qrid",$id)
            )
        );
        return \pepdo::getInstance($db)->updateElement($data);
    }

    static function delQuestionRows($db,$id)
    {
        $data = array(
            'table' => 'questionrows',
            'query' => array(
                array("AND","qrid = :qrid","qrid",$id)
            )
        );
        return \pepdo::getInstance($db)->delElement($data);
    }

    static function recoverQuestionrows($db,$id)
    {
        $data = array(
            'table' => 'questionrows',
            'value' => array('qrstatus' => 1),
            'query' => array(
                array("AND","qrid = :qrid","qrid",$id)
            )
        );
        return \pepdo::getInstance($db)->updateElement($data);
    }

    static function resetRowsQuestionNumber($db,$qrid)
    {
        $data = array(
            'select' => 'count(*) as number',
            'table' => 'questions',
            'query' => array(
                array("AND","questionparent = :qrid","qrid",$qrid),
                array("AND","questionstatus = 1")
            )
        );
        $r = \pepdo::getInstance($db)->getElement($data);
        self::modifyQuestionRows($db,$qrid,array('qrnumber' => $r['number']));
        return true;
    }

    static function importQuestions($uploadfile,$subject)
    {
        $handle = fopen($uploadfile,"r");
        $qrid = 0;
        $number = array('question' => 0,'questionrows' => 0,'childquestion' => 0);
        while ($question = fgetcsv($handle))
        {
            $args = array();
            if(count($question) >= 6)
            {
                $isqr = intval(trim($question[8]," \n\t"));
                if($isqr)
                {
                    $istitle = intval(trim($question[9]," \n\t"));
                    if($istitle)
                    {
                        if($qrid)
                        {
                            self::resetRowsQuestionNumber($subject['subjectdb'],$qrid);
                        }
                        $args['qrtype'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[0])," \n\t"));
                        $args['qrquestion'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[1])," \n\t"));
                        $args['qrlevel'] = $question[7];
                        $args['qrtime'] = TIME;
                        $args['qrauthor'] = \exam\app::$_user['sessionusername'];
                        $args['qrpoints'] = explode(',',$question[6]);
                        $args['qrsubject'] = $subject['subjectid'];

                        $qrid = self::addQuestionRows($subject['subjectdb'],$args);
                        if($qrid)$number['questionrows']++;
                    }
                    else
                    {
                        $args['questiontype'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[0])," \n\t"));
                        $args['question'] = iconv("GBK","UTF-8//IGNORE",trim($question[1]," \n\t"));
                        $args['questionselect'] = iconv("GBK","UTF-8//IGNORE",trim($question[2]," \n\t"));
                        $args['questionselectnumber'] = intval(trim($question[3]," \n\t"));
                        $args['questionanswer'] = iconv("GBK","UTF-8//IGNORE",trim($question[4]," \n\t"));
                        $args['questionintro'] = iconv("GBK","UTF-8//IGNORE",trim($question[5]," \n\t"));
                        if($qrid)$args['questionparent'] = $qrid;
                        $args['questionlevel'] = intval(trim($question[7]," \n\t"));
                        $args['questiontime'] = TIME;
                        $args['questionusername'] = \exam\app::$_user['sessionusername'];
                        $args['questionsubject'] = $subject['subjectid'];
                        $id = self::addQuestion($subject['subjectdb'],$args);
                        if($id)$number['childquestion']++;
                    }
                }
                else
                {
                    $args['questiontype'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[0])," \n\t"));;
                    $args['question'] = iconv("GBK","UTF-8//IGNORE",trim($question[1]," \n\t"));
                    $args['questionselect'] = iconv("GBK","UTF-8//IGNORE",trim($question[2]," \n\t"));
                    $args['questionselectnumber'] = intval(trim($question[3]," \n\t"));
                    $args['questionanswer'] = iconv("GBK","UTF-8//IGNORE",trim($question[4]," \n\t"));
                    $args['questionintro'] = iconv("GBK","UTF-8//IGNORE",trim($question[5]," \n\t"));
                    $args['questionusername'] = \exam\app::$_user['sessionusername'];;
                    $args['questionpoints'] = explode(',',$question[6]);
                    $args['questionlevel'] = intval(trim($question[7]," \n\t"));
                    $args['questiontime'] = TIME;
                    $args['questionsubject'] = $subject['subjectid'];
                    $id = self::addQuestion($subject['subjectdb'],$args);
                    if($id)$number['question']++;
                }
            }
        }
        if($qrid)
        {
            self::resetRowsQuestionNumber($subject['subjectdb'],$qrid);
        }
        return $number;
    }

    static function importCsvQuestions($file)
    {
        setlocale(LC_ALL,'zh_CN');
        $handle = fopen($file,"r");
        $questions = array();
        $rindex = 0;
        $index = 0;
        while ($data = fgetcsv($handle))
        {
            $targs = array();
            $question = $data;
            if(count($question) >= 5)
            {
                $isqr = intval(trim($question[6]," \n\t"));
                if($isqr)
                {
                    $istitle = intval(trim($question[7]," \n\t"));;
                    if($istitle)
                    {
                        $rindex ++;
                        $targs['qrid'] = 'qr_'.$rindex;
                        $targs['qrtype'] = $question[0];
                        $targs['qrquestion'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[1])," \n\t"));
                        $targs['qrcreatetime'] = TIME;
                        $questionrows[$targs['qrtype']][intval($rindex - 1)] = $targs;
                    }
                    else
                    {
                        $index ++;
                        $targs['questionid'] = 'q_'.$index;
                        $targs['questiontype'] = $question[0];
                        $targs['question'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[1])," \n\t"));
                        $targs['questionselect'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[2])," \n\t"));
                        if(!$targs['questionselect'] && $targs['questiontype'] == 3)
                        {
                            $targs['questionselect'] = '<p>A、对<p><p>B、错<p>';
                        }
                        $targs['questionselectnumber'] = $question[3];
                        $targs['questionanswer'] = iconv("GBK","UTF-8//IGNORE",trim($question[4]," \n\t"));
                        $targs['questiondescribe'] = iconv("GBK","UTF-8//IGNORE",trim($question[5]," \n\t"));
                        $targs['questioncreatetime'] = TIME;
                        $questionrows[$targs['questiontype']][intval($rindex - 1)]['data'][] = $targs;
                    }
                }
                else
                {
                    $index++;
                    $targs['questionid'] = 'q_'.$index;
                    $targs['questiontype'] = $question[0];
                    $targs['question'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[1])," \n\t"));
                    $targs['questionselect'] = iconv("GBK","UTF-8//IGNORE",trim(nl2br($question[2])," \n\t"));
                    if(!$targs['questionselect'] && $targs['questiontype'] == 3)
                    {
                        $targs['questionselect'] = '<p>A、对<p><p>B、错<p>';
                    }
                    $targs['questionselectnumber'] = intval($question[3]);
                    $targs['questionanswer'] = iconv("GBK","UTF-8//IGNORE",trim($question[4]," \n\t"));
                    $targs['questiondescribe'] = iconv("GBK","UTF-8//IGNORE",trim($question[5]," \n\t"));
                    $targs['questioncreatetime'] = TIME;
                    $questions[$targs['questiontype']][] = $targs;
                }
            }
        }
        return array('questions' => $questions,'questionrows' => $questionrows);
    }

    static function exportQuestions($db,$args)
    {
        $questions = self::getQuestionsByArgs($db,$args);
        $r = array();
        foreach($questions as $p)
        {
            $r[] = array(
                'questiontype' => $p['questiontype'],
                'question' => iconv("UTF-8","GBK",html_entity_decode($p['question'])),
                'questionselect' => iconv("UTF-8","GBK",html_entity_decode($p['questionselect'])),
                'questionselectnumber' => iconv("UTF-8","GBK",$p['questionselectnumber']),
                'questionanswer' => iconv("UTF-8","GBK",html_entity_decode($p['questionanswer'])),
                'questionintro' => iconv("UTF-8","GBK",html_entity_decode($p['questionintro'])),
                'questionpoints' => implode(',',$p['questionpoints']),
                'questionlevel' => $p['questionlevel']
            );
        }
        return $r;
    }

    static function exportQuestionRows($db,$args)
    {
        $questionrows = self::getQuestionRowsByArgs($db,$args);
        $r = array();
        foreach($questionrows as $p)
        {
            $r[] = array(
                'qrtype' => $p['qrtype'],
                'qrquestion' => html_entity_decode(iconv("UTF-8","GBK",$p['qrquestion'])),
                'qrselect' => '',
                'qrselectnumber' => '',
                'qranswer' => '',
                'qrintro' => '',
                'qrpoints' => implode(',',$p['qrpoints']),
                'qrlevel' => $p['qrlevel'],
                'isrows' => '1',
                'istitle' => '1'
            );
            $rs = self::getQuestionsByArgs($db,array(array("AND","questionparent = :questionparent","questionparent",$p['qrid'])));
            foreach($rs as $p)
            {
                $r[] = array(
                    'questiontype' => $p['questiontype'],
                    'question' => html_entity_decode(iconv("UTF-8","GBK",$p['question'])),
                    'questionselect' => html_entity_decode(iconv("UTF-8","GBK",$p['questionselect'])),
                    'questionselectnumber' => iconv("UTF-8","GBK",$p['questionselectnumber']),
                    'questionanswer' => html_entity_decode(iconv("UTF-8","GBK",$p['questionanswer'])),
                    'questionintro' => html_entity_decode(iconv("UTF-8","GBK",$p['questionintro'])),
                    'questionpoints' => implode(',',$p['questionpoints']),
                    'questionlevel' => $p['questionlevel'],
                    'isrows' => '1',
                    'istitle' => 0
                );
            }
        }
        return $r;
    }

    static function getExamQuestionNumber($db,$setting)
    {
        $questions = trim($setting['questions']," ,");
        $questionrows = trim($setting['questionrows']," ,");
        if($questions)
        {
            $data = array('count(*) as number','questions',array(array("AND","find_in_set(questionid,:questionid)",'questionid',$questions),array("AND","questionstatus = 1")));
            $sql = \pdosql::getInstance($db)->makeSelect($data);
            $r = \pepdo::getInstance($db)->fetch($sql);
            $number = intval($r['number']);
        }
        else
        {
            $number = 0;
        }
        if($questionrows)
        {
            $data = array('sum(qrnumber) as number','questionrows',array(array("AND","find_in_set(qrid,:qrid)",'qrid',$questionrows),array("AND","qrstatus = 1")));
            $sql = \pdosql::getInstance($db)->makeSelect($data);
            $r = \pepdo::getInstance($db)->fetch($sql);
            $number += intval($r['number']);
        }
        return $number;
    }

    static function getQuestionNumberByPointid($db,$pointid)
    {
        $numbers = json_decode(\pedis::getInstance()->getHashData('number',$db),true);
        if($numbers[$pointid])return $numbers[$pointid];
        else
        {
            $data = array('count(*) as number','questions',array(array("AND","find_in_set(:questionpoints,questionpoints)",'questionpoints',$pointid),array("AND","questionstatus = 1")));
            $sql = \pdosql::getInstance($db)->makeSelect($data);
            $r = \pepdo::getInstance($db)->fetch($sql);
            $number = intval($r['number']);
            $data = array('sum(qrnumber) as number','questionrows',array(array("AND","find_in_set(:qrpoints,qrpoints)",'qrpoints',$pointid),array("AND","qrstatus = 1")));
            $sql = \pdosql::getInstance($db)->makeSelect($data);
            $r = \pepdo::getInstance($db)->fetch($sql);
            $number += intval($r['number']);
            $numbers[$pointid] = $number;
            \pedis::getInstance()->setHashData('number',$db,json_encode($numbers));
            return $number;
        }
    }

    static function getQuestionidsByPointid($db,$pointid)
    {
        $questionids = json_decode(\pedis::getInstance()->getHashData('questions',$db),true);
        $qrids = json_decode(\pedis::getInstance()->getHashData('questionrows',$db),true);
        if(!$questionids[$pointid])
        {
            $ids = array();
            $data = array('questionid','questions',array(array("AND","find_in_set(:questionpoints,questionpoints)",'questionpoints',$pointid),array("AND","questionstatus = 1")),false,false,false);
            $sql = \pdosql::getInstance($db)->makeSelect($data);
            $r = \pepdo::getInstance($db)->fetchAll($sql);
            foreach($r as $p)
            {
                $ids[] = $p['questionid'];
            }
            $questionids[$pointid] = $ids;
            \pedis::getInstance()->setHashData('questions',$db,json_encode($questionids));
        }
        if(!$qrids[$pointid])
        {
            $ids = array();
            $data = array('qrid,questionid',array('questions','questionrows'),array(array("AND","find_in_set(:qrpoints,qrpoints)",'qrpoints',$pointid),array("AND","questionparent = qrid"),array("AND","qrstatus = 1"),array("AND","questionstatus = 1")),false,"questionorder desc",false);
            $sql = \pdosql::getInstance($db)->makeSelect($data);
            $r = \pepdo::getInstance($db)->fetchAll($sql);
            foreach($r as $p)
            {
                $ids[$p['qrid']][] = $p['questionid'];
            }
            $qrids[$pointid] = $ids;
            \pedis::getInstance()->setHashData('questionrows',$db,json_encode($qrids));
        }
        $ids = $questionids[$pointid];
        foreach($qrids[$pointid] as $p)
        {
            foreach($p as $id)
            {
                $ids[] = $id;
            }
        }
        return $ids;
    }

    static private function _getRangeQuestionids($db,$points)
    {
        $ids = array();
        foreach($points as $p)
        {
            $questions = self::getQuestionIdsByPoint($db,$p);
            $questionrows = self::getQuestionRowsIdsByPoint($db,$p);
            foreach($questions as $qtype => $question)
            {
                foreach($question as $key => $id)
                {
                    if(!$ids['questions'][$qtype][$key])$ids['questions'][$qtype][$key] = array();
                    $ids['questions'][$qtype][$key] = array_unique(array_merge($ids['questions'][$qtype][$key],$id));
                }
            }
            foreach($questionrows as $qtype => $question)
            {
                foreach($question as $key => $qnumber)
                {
                    foreach($qnumber as $qn => $id)
                    {
                        if(!$ids['questionrows'][$qtype][$key][$qn])$ids['questionrows'][$qtype][$key][$qn] = array();
                        $ids['questionrows'][$qtype][$key][$qn] = array_unique(array_merge($ids['questionrows'][$qtype][$key][$qn],$id));
                    }
                }
            }
        }
        return $ids;
    }

    static function selectscalequestions($db,$paper,$points)
    {
        $questionids = array();
        $questionrowsids = array();
        foreach($paper['papersetting']['paperscale'] as $questype => $setting)
        {
            if($setting)
            {
                $steps = explode("\n", $setting);
                foreach ($steps as $step)
                {
                    $query = explode(":", trim($step, "\n\r"));
                    $points = explode(',', $query[0]);
                    $ids = self::_getRangeQuestionids($db, $points);
                    if ($query[2])
                    {
                        $number = explode(',', $query[2]);
                        $level = array(1 => $number[0], $number[1], $number[2]);
                        foreach ($level as $key => $p)
                        {
                            if($p)
                            {
                                $uqonly = 0;
                                $uqronly = 0;
                                if ($ids['questions'][$questype][$key] || $ids['questionrows'][$questype][$key])
                                {
                                    if (!$ids['questions'][$questype][$key]) $uqronly = 1;
                                    if (!$ids['questionrows'][$questype][$key]) $uqonly = 1;
                                    if ($uqonly)
                                    {
                                        if (count($ids['questions'][$questype][$key]) >= $p)
                                        {
                                            $arr = array_rand($ids['questions'][$questype][$key],$p);
                                            foreach($arr as $i)
                                            {
                                                $questionids[$questype][] = $ids['questions'][$questype][$key][$i];
                                            }
                                        }
                                        else
                                        {
                                            $questionids[$questype] = array_merge($questionids[$questype], $ids['questions'][$questype][$key]);
                                        }
                                    }
                                    elseif ($uqronly)
                                    {
                                        $tmp = array();
                                        $qrids = array();
                                        foreach ($ids['questionrows'][$questype][$key] as $nkey => $qrid)
                                        {
                                            if ($nkey <= $p) {
                                                foreach ($qrid as $rid)
                                                {
                                                    $tmp[] = $rid;
                                                    $qrids[$rid] = $nkey;
                                                }
                                            }
                                        }
                                        if (count($tmp) >= $p)
                                        {
                                            $arr = array_rand($tmp,$p);
                                            $tmparr = array();
                                            foreach($arr as $i)
                                            {
                                                $tmparr[] = $tmp[$i];
                                            }
                                            $tmp = $tmparr;
                                        }
                                        $t = $p;
                                        while ($t > 0)
                                        {
                                            if ($tmp)
                                            {
                                                $ti = array_pop($tmp);
                                                $questionrowsids[$questype][] = $ti;
                                                $t -= $qrids[$ti];
                                            }
                                            else
                                            {
                                                break;
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $tmp = array();
                                        $qrids = array();
                                        foreach ($ids['questionrows'][$questype][$key] as $nkey => $qrid) {
                                            if ($nkey <= $p) {
                                                foreach ($qrid as $rid) {
                                                    $tmp[] = $rid;
                                                    $qrids[$rid] = $nkey;
                                                }
                                            }
                                        }
                                        if (count($tmp) >= $p) {
                                            $arr = array_rand($tmp,$p);
                                            $tmparr = array();
                                            foreach($arr as $i)
                                            {
                                                $tmparr[] = $tmp[$i];
                                            }
                                            $tmp = $tmparr;
                                        }
                                        $t = $p;
                                        while ($t > 0) {
                                            if ($tmp) {
                                                $ti = array_pop($tmp);
                                                $questionrowsids[$questype][] = $ti;
                                                $t -= $qrids[$ti];
                                            } else {
                                                break;
                                            }
                                            if (count($ids['questions'][$questype][$key]) >= $t) {
                                                if (rand(0, 1)) {
                                                    break;
                                                }
                                            }
                                        }
                                        if ($t > 0) {
                                            $arr = array_rand($ids['questions'][$questype][$key],$t);
                                            foreach($arr as $i)
                                            {
                                                $questionids[$questype][] = $ids['questions'][$questype][$key][$i];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $number = $query[1];
                        if($number)
                        {
                            $uqonly = 0;
                            $uqronly = 0;
                            $tmpqids = array();
                            $tmpqrids = array();
                            $qrids = array();
                            foreach($ids['questions'][$questype] as $p)
                            {
                                $tmpqids = array_merge($tmpqids,$p);
                            }
                            foreach($ids['questionrows'][$questype] as $p)
                            {
                                foreach($p as $nkey => $qis)
                                {
                                    foreach($qis as $qi)
                                    {
                                        $tmpqrids[] = $qi;
                                        $qrids[$qi] = $nkey;
                                    }
                                }
                            }
                            if($tmpqids || $tmpqrids)
                            {
                                if(!$tmpqids)$uqronly = 1;
                                if(!$tmpqrids)$uqonly = 1;
                                if($uqonly)
                                {
                                    if(count($tmpqids) >= $number)
                                    {
                                        $arr = array_rand($tmpqids, $number);
                                        foreach($arr as $i)
                                        {
                                            $questionids[$questype][] = $tmpqids[$i];
                                        }
                                    }
                                    else
                                    {
                                        $questionids[$questype] = array_merge($questionids[$questype], $tmpqids);
                                    }
                                }
                                elseif($uqronly)
                                {
                                    if (count($tmpqrids) >= $p)
                                    {
                                        $arr = array_rand($tmpqrids,$p);
                                        $tmp = array();
                                        foreach($arr as $i)
                                        {
                                            $tmp[] = $tmpqrids[$i];
                                        }
                                    }
                                    else
                                    {
                                        $tmp = $tmpqrids;
                                    }
                                    $t = $p;
                                    while ($t > 0)
                                    {
                                        if ($tmp)
                                        {
                                            $ti = array_pop($tmp);
                                            $questionrowsids[$questype][] = $ti;
                                            $t -= $qrids[$ti];
                                        }
                                        else
                                        {
                                            break;
                                        }
                                    }
                                }
                                else
                                {
                                    if (count($tmpqrids) >= $p)
                                    {
                                        $arr = array_rand($tmpqrids,$p);
                                        $tmp = array();
                                        foreach($arr as $i)
                                        {
                                            $tmp[] = $tmpqrids[$i];
                                        }
                                    }
                                    else
                                    {
                                        $tmp = $tmpqrids;
                                    }
                                    $t = $p;
                                    while ($t > 0) {
                                        if ($tmp)
                                        {
                                            $ti = array_pop($tmp);
                                            $questionrowsids[$questype][] = $ti;
                                            $t -= $qrids[$ti];
                                        } else {
                                            break;
                                        }
                                        if (count($tmpqids) >= $t) {
                                            if (rand(0, 1)) {
                                                break;
                                            }
                                        }
                                    }
                                    if ($t > 0) {
                                        $arr = array_rand($tmpqids,$t);
                                        foreach($arr as $i)
                                        {
                                            $questionids[$questype][] = $tmpqids[$i];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return array('ids' => $questionids, 'qrids' => $questionrowsids);
    }

    static function selectquestions($db,$paper,$points)
    {
        if($paper['papersetting']['scalemodel'])return self::selectscalequestions($db,$paper,$points);
        $ids = self::_getRangeQuestionids($db,$points);
        $questionids = array();
        $questionrowsids = array();
        foreach($paper['papersetting']['questype'] as $questype => $setting)
        {
            if($setting['number'])
            {
                $questionids[$questype] = array();
                $questionrowsids[$questype] = array();
                $level = array(1 => $setting['easynumber'], $setting['middlenumber'],$setting['hardnumber']);
                foreach($level as $key => $p)
                {
                    if($p)
                    {
                        $uqonly = 0;
                        $uqronly = 0;
                        if($ids['questions'][$questype][$key] || $ids['questionrows'][$questype][$key])
                        {
                            if(!$ids['questions'][$questype][$key])$uqronly = 1;
                            if(!$ids['questionrows'][$questype][$key])$uqonly = 1;
                            if($uqonly)
                            {
                                if(count($ids['questions'][$questype][$key]) >= $p)
                                {
                                    $arr = array_rand($ids['questions'][$questype][$key],$p);
                                    foreach($arr as $i)
                                    {
                                        $questionids[$questype][] = $ids['questions'][$questype][$key][$i];
                                    }
                                }
                                else
                                {
                                    $questionids[$questype] = array_merge($questionids[$questype],$ids['questions'][$questype][$key]);
                                }
                            }
                            elseif($uqronly)
                            {
                                $tmp = array();
                                foreach($ids['questionrows'][$questype][$key] as $nkey => $qrid)
                                {
                                    if($nkey <= $p)
                                    {
                                        foreach($qrid as $rid)
                                        {
                                            $tmp[] = $rid;
                                            $qrids[$rid] = $nkey;
                                        }
                                    }
                                }
                                if(count($tmp) >= $p)
                                {
                                    $arr = array_rand($tmp,$p);
                                    $tmparr = array();
                                    foreach($arr as $i)
                                    {
                                        $tmparr[] = $tmp[$i];
                                    }
                                    $tmp = $tmparr;
                                }
                                $t = $p;
                                while($t > 0)
                                {
                                    if($tmp)
                                    {
                                        $ti = array_pop($tmp);
                                        $questionrowsids[$questype][] = $ti;
                                        $t -= $qrids[$ti];
                                    }
                                    else
                                    {
                                        break;
                                    }
                                }
                            }
                            else
                            {
                                $tmp = array();
                                foreach($ids['questionrows'][$questype][$key] as $nkey => $qrid)
                                {
                                    if($nkey <= $p)
                                    {
                                        foreach($qrid as $rid)
                                        {
                                            $tmp[] = $rid;
                                            $qrids[$rid] = $nkey;
                                        }
                                    }
                                }
                                if(count($tmp) >= $p)
                                {
                                    $arr = array_rand($tmp,$p);
                                    $tmparr = array();
                                    foreach($arr as $i)
                                    {
                                        $tmparr[] = $tmp[$i];
                                    }
                                    $tmp = $tmparr;
                                }
                                $t = $p;
                                while($t > 0)
                                {
                                    if($tmp)
                                    {
                                        $ti = array_pop($tmp);
                                        $questionrowsids[$questype][] = $ti;
                                        $t -= $qrids[$ti];
                                    }
                                    else
                                    {
                                        break;
                                    }
                                    if(count($ids['questions'][$questype][$key]) >= $t)
                                    {
                                        if(rand(0,1))
                                        {
                                            break;
                                        }
                                    }
                                }
                                if($t > 0)
                                {
                                    $arr = array_rand($ids['questions'][$questype][$key],$t);
                                    foreach($arr as $i)
                                    {
                                        $questionids[$questype][] = $ids['questions'][$questype][$key][$i];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                unset($ids['questions'][$questype]);
                unset($ids['questionrows'][$questype]);
            }
        }
        return array('ids' => $questionids, 'qrids' => $questionrowsids);
    }

    static function submitpaper($dbid,$question,$paper,$username)
    {
        $scorelist = array();
        $questypes = self::getQuestypesByArgs();
        $needteacher = 0;
        foreach($paper['question']['questions'] as $key => $qs)
        {
            if(!$needteacher && $questypes[$key]['questsort'])
            {
                $needteacher = 1;
            }
            if(!$questypes[$key]['questsort'])
            {
                foreach($qs as $q) {
                    if ($question[$q['questionid']]) {
                        if ($questypes[$key]['questchoice'] == 3) {
                            if (is_array($question[$q['questionid']])) {
                                asort($question[$q['questionid']]);
                                $answer = implode('', $question[$q['questionid']]);
                                if ($answer == $q['questionanswer']) {
                                    $scorelist[$q['questionid']] = $paper['setting']['papersetting']['questype'][$key]['score'];
                                } else {
                                    $i = 0;
                                    foreach ($question[$q['questionid']] as $p) {
                                        if (strpos($q['questionanswer'], $p) === false) {
                                            $i = 0;
                                            break;
                                        } else {
                                            $i++;
                                        }
                                    }
                                    $scorelist[$q['questionid']] = round($i / strlen($q['questionanswer']), 1);
                                }
                            } else {
                                $scorelist[$q['questionid']] = 0;
                            }
                        } else {
                            if (is_array($question[$q['questionid']])) {
                                asort($question[$q['questionid']]);
                                $answer = implode('', $question[$q['questionid']]);
                                if ($answer == $q['questionanswer']) {
                                    $scorelist[$q['questionid']] = $paper['setting']['papersetting']['questype'][$key]['score'];
                                } else {
                                    $scorelist[$q['questionid']] = 0;
                                }
                            } else {
                                if ($question[$q['questionid']] == $q['questionanswer']) {
                                    $scorelist[$q['questionid']] = $paper['setting']['papersetting']['questype'][$key]['score'];
                                } else {
                                    $scorelist[$q['questionid']] = 0;
                                }
                            }
                        }
                    } else {
                        $scorelist[$q['questionid']] = 0;
                    }
                }
            }
            foreach($paper['question']['questionrows'] as $key => $qrs)
            {
                foreach($qrs as $qr)
                {
                    foreach($qr['data'] as $q)
                    {
                        if(!$needteacher && $questypes[$q['questiontype']]['questsort'])
                        {
                            $needteacher = 1;
                        }
                        if(!$questypes[$q['questiontype']]['questsort'])
                        {
                            if($question[$q['questionid']])
                            {
                                if($questypes[$key]['questchoice'] == 3)
                                {
                                    if(is_array($question[$q['questionid']]))
                                    {
                                        asort($question[$q['questionid']]);
                                        $answer = implode('',$question[$q['questionid']]);
                                        if($answer == $q['questionanswer'])
                                        {
                                            $scorelist[$q['questionid']] = $paper['setting']['papersetting']['questype'][$key]['score'];
                                        }
                                        else
                                        {
                                            $i = 0;
                                            foreach($question[$q['questionid']] as $p)
                                            {
                                                if(strpos($q['questionanswer'],$p) === false)
                                                {
                                                    $i = 0;
                                                    break;
                                                }
                                                else
                                                {
                                                    $i++;
                                                }
                                            }
                                            $scorelist[$q['questionid']] = round($i/strlen($q['questionanswer']),1);
                                        }
                                    }
                                    else
                                    {
                                        $scorelist[$q['questionid']] = 0;
                                    }
                                }
                                else
                                {
                                    if(is_array($question[$q['questionid']]))
                                    {
                                        asort($question[$q['questionid']]);
                                        $answer = implode('',$question[$q['questionid']]);
                                        if($answer == $q['questionanswer'])
                                        {
                                            $scorelist[$q['questionid']] = $paper['setting']['papersetting']['questype'][$key]['score'];
                                        }
                                        else
                                        {
                                            $scorelist[$q['questionid']] = 0;
                                        }
                                    }
                                    else
                                    {
                                        if($question[$q['questionid']] == $q['questionanswer'])
                                        {
                                            $scorelist[$q['questionid']] = $paper['setting']['papersetting']['questype'][$key]['score'];
                                        }
                                        else
                                        {
                                            $scorelist[$q['questionid']] = 0;
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $scorelist[$q['questionid']] = 0;
                            }
                        }
                    }
                }
            }
        }
        $score = array_sum($scorelist);
        $args = array();
        $args['ehpaperid'] = $paper['key'];
        $args['ehbasicid'] = $paper['basic'];
        $args['ehexam'] = $paper['name'];
        $args['ehtype'] = $paper['type'];
        $args['ehquestion'] = $paper['question'];
        $args['ehsetting'] = $paper['setting'];
        $args['ehscorelist'] = $scorelist;
        $args['ehuseranswer'] = $question;
        $args['ehtime'] = TIME - $paper['starttime'];
        if($args['ehtime'] > $paper['time']*60)$args['ehtime'] = $paper['time']*60;
        $args['ehscore'] = $score;
        $args['ehusername'] = $username;
        $args['ehstarttime'] = $paper['starttime'];
        if($needteacher)
        {
            $args['ehstatus'] = 0;
        }
        else
        {
            $args['ehstatus'] = 1;
        }
        if($score >= $paper['setting']['papersetting']['passscore'])
        {
            $args['ehispass'] = 1;
        }
        else
        {
            $args['ehispass'] = 0;
        }
        $ehid = favor::addExamHistory($dbid,$args);
        return array('needteacher' => $needteacher , 'ehid' => $ehid);
    }

    static public function addErros($args)
    {
        $data = array(
            'table' => 'errors',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
    }

    static public function delErrors($erid)
    {
        $data = array(
            'table' => 'errors',
            'query' => array(
                array("AND","erid = :erid","erid",$erid)
            )
        );
        return \pepdo::getInstance()->delElement($data);
    }

    static function modifyErrors($erid,$args)
    {
        $data = array(
            'table' => 'errors',
            'value' => $args,
            'query' => array(
                array("AND","erid = :erid","erid",$erid)
            )
        );
        \pepdo::getInstance()->updateElement($data);
    }

    static function getErrorsList($args,$page,$number = \config::webpagenumber,$orderby = 'erstatus asc,erid desc')
    {
        $data = array(
            'table' => 'errors',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
    }

    static function getErrorById($erid)
    {
        $data = array(
            'table' => 'errors',
            'query' => array(
                array("AND","erid = :erid","erid",$erid)
            )
        );
        return \pepdo::getInstance()->getElement($data);
    }
}