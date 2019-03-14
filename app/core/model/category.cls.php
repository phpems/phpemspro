<?php

namespace core\model;

class category
{
	static public $tidyCategory;
	static public $categories;

	static public function addCategory($args)
	{
        $data = array(
            'table' => 'category',
            'query' => $args
        );
        return \pepdo::getInstance()->insertElement($data);
	}

	static public function getCategoryById($id)
	{
        $data = array(
            'table' => 'category',
            'query' => array(
                array("AND","catid = :catid","catid",$id)
            )
        );
        return \pepdo::getInstance()->getElement($data);
	}

	static public function getCategoryList($args,$page,$number = \config::webpagenumber,$orderby = 'catorder desc')
	{
        $data = array(
            'table' => 'category',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->listElements($page,$number,$data);
	}

	static public function getCategoriesByArgs($args,$orderby = 'catorder desc')
	{
        $data = array(
            'table' => 'category',
            'query' => $args,
            'orderby' => $orderby
        );
        return \pepdo::getInstance()->getElements($data);
	}

    static public function delCategory($id)
	{
        $data = array(
            'table' => 'category',
            'query' => array(
                array("AND","catid = :catid","catid",$id)
            )
        );
        return \pepdo::getInstance()->delElement($data);
	}

    static public function modifyCategory($id,$args)
	{
        $data = array(
            'table' => 'category',
            'value' => $args,
            'query' => array(
                array("AND","catid = :catid","catid",$id)
            )
        );
        \pepdo::getInstance()->updateElement($data);
	}

    static public function getAllCategory($appcode)
	{
		if(self::$categories[$appcode] === null)
		{
            $data = array(
                'table' => 'category',
                'query' => array(
                    array('AND',"catapp = :catapp",'catapp',$appcode)
                ),
				'index' => 'catid',
				'orderby' => "catorder DESC,catid DESC"
            );
            self::$categories[$appcode] = \pepdo::getInstance()->getElements($data);
            self::$tidyCategory[$appcode] = self::tidyCategory($appcode);
		}
		return self::$categories[$appcode];
	}

	static private function tidyCategory($appcode)
	{
		if(self::$tidyCategory[$appcode] === null)
		{
			self::getAllCategory($appcode);
			$categories = array();
			foreach(self::$categories[$appcode] as $p)
			{
				$categories[$p['catparent']][] = $p;
			}
			self::$tidyCategory[$appcode] = $categories;
		}
		return self::$tidyCategory[$appcode];
	}

    static public function getChildCategory($appcode,$id)
	{
		$categories = self::tidyCategory($appcode);
		$child = $categories[$id];
		return $child;
	}

    static public function getChildCategoryString($appcode,$id,$withself = 1)
	{
        $r = self::getChildCategory($appcode,$id);
        $s = array();
        foreach($r as $p)
		{
            $s[] = $p['catid'];
		}
		$s = implode(',',$s);

		if($withself)
		{
			if($s)$s = $id.','.$s;
			else $s = $id;
		}
		return $s;
	}

    static public function getCategoryPos($appcode,$id)
	{
		self::tidyCategory($appcode);
		if(self::$categories[$appcode][$id])
		{
			$categories = array();
			while(self::$categories[$appcode][$id]['catparent'])
			{
				$categories[] = self::$categories[$appcode][self::$categories[$appcode][$id]['catparent']];
				$id = self::$categories[$appcode][$id]['catparent'];
			}
			krsort($categories);
			return $categories;
		}
		else return false;
	}

    static public function levelCategory(&$t,$index,$allcats,$selected,$hrefpre)
	{
		if(is_array($allcats[$index]))
		{
			foreach($allcats[$index] as $p)
			{
                if($selected && $selected == $p['catid'])
                $t[$p['catid']] = array('text' => $p['catname'],'href' => $hrefpre.$p['catid'],'color' => '#FFFFFF',"backColor" => '#428bca');
                else
				$t[$p['catid']] = array('text' => $p['catname'],'href' => $hrefpre.$p['catid']);
				self::levelCategory($t[$p['catid']]['nodes'],$p['catid'],$allcats,$selected,$hrefpre);
			}
		}
	}

	static public function resetCategoryIndex(&$t)
	{
        $t = array_values($t);
		foreach($t as $key => $p)
		{
			if($p['nodes'])
			{
				self::resetCategoryIndex($t[$key]['nodes']);
			}
		}
	}
}

?>
