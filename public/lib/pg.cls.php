<?php

class pg
{
	static $pre = '<li>';
    static $end = '</li>';
    static $number;
    static $target;

    static function setUrlTarget($target = NULL)
    {
    	self::$target = $target;
    }

    static function setBlock($pre,$end)
    {
    	self::$pre = $pre;
    	self::$end = $end;
    }

	//获取总页数
    static function getPagesNumber($number,$sepnumber = config::webpagenumber)
	{
		if(!$sepnumber)$sepnumber = config::webpagenumber;
		self::$number = $number;
		if($number % $sepnumber)
		return intval($number/$sepnumber)+1;
		else
		return intval($number/$sepnumber);
	}

    static function outPhonePage($pages,$cpage,$url = false,$separate = "&page=")
	{
		if($pages <2)
		{
			return false;
		}
		if(!$url)
		{
			$url = 'index.php?'.$_SERVER['QUERY_STRING'];
			$url = str_replace('&page='.$cpage,'',$url);
			if(is_array(route::post('search')))
			{
				foreach(route::post('search') as $key => $p)
				{
					if(strlen($p) < 1024)
					$url .= '&search['.$key.']='.$p;
				}
			}
		}
		if($cpage > 1)
		{
			$pageString = self::$pre.'<a '.self::$target.' href="'.$url.$separate.'1">'.'第一页'.'</a>'.self::$end;
			$pageString .= self::$pre.'<a '.self::$target.' href="'.$url.$separate.intval($cpage - 1).'">'.'上一页'.'</a>'.self::$end;
		}
		else
		$pageString = self::$pre.'<a class="current">'.'第一页'.'</a>'.self::$end;
		$pageString .= self::$pre.'<a>共'.self::$number.'条数据</a>'.self::$end;
		if($cpage < $pages)
		{
			$pageString .= self::$pre.'<a '.self::$target.' href="'.$url.$separate.intval($cpage + 1).'">'.'下一页'.'</a>'.self::$end;
			$pageString .= self::$pre.'<a '.self::$target.' href="'.$url.$separate.$pages.'">'.'末页'.'</a>'.self::$end;
		}
		else
		$pageString .= self::$pre.'<a>'.'末页'.'</a>'.self::$end;
		return $pageString;
	}
	//生成分页HTML
    static function outPage($pages,$cpage,$url = false,$separate = "&page=")
	{
		if(route::isMobile())return self::outPhonePage($pages,$cpage,$url,$separate);
		if(!$url)
		{
			$url = 'index.php?'.$_SERVER['QUERY_STRING'];
			$url = str_replace('&page='.$cpage,'',$url);
			if(is_array(route::post('search')))
			{
				foreach(route::post('search') as $key => $p)
				{
					if(strlen($p) < 1024)
					$url .= '&search['.$key.']='.$p;
				}
			}
		}
		$pageString = '';
		if($pages <2)
		{
			return false;
		}
		elseif($pages <= 10)
		{
			for($p = 1; $p <= $pages; $p++)
			{
				if($p == $cpage)$t = self::$pre.'<a href="#" class="current">'.$p.'</a>'.self::$end;
				else $t = self::$pre.'<a target="'.self::$target.'" href="'.$url.$separate.$p.'">'.$p.'</a>'.self::$end;
				$pageString .= $t;
			}
			$pageString .= self::$pre.'<a>共'.self::$number.'条数据</a>'.self::$end;
			return $pageString;
		}else
		{
			$pageString = self::$pre.'<a target="'.self::$target.'" href="'.$url.$separate.'1">|&lsaquo;</a>'.self::$end;
			if($cpage <= 5)
			{
				$start = 1;
				$end = 10;
				$endString = self::$pre.'<a target="'.self::$target.'" href="'.$url.$separate.'11"> >> </a>'.self::$end;
			}
			else
			{
				$start = $cpage - 5;
				if($start>1)$startString = self::$pre.'<a target="'.self::$target.'" href="'.$url.$separate.intval($start-1).'"> << </a>'.self::$end;
				if($pages - $cpage >= 5)
				{
					$end = $cpage + 4;
					$endString = self::$pre.'<a target="'.self::$target.'" href="'.$url.$separate.intval($end+1).'"> >> </a>'.self::$end;
				}
				else
				{
					$start = $pages - 9;
					$end = $pages;
				}
			}
			if(isset($startString))$pageString .= $startString;
			for($start;$start<=$end;$start++)
			{
				if($start == $cpage)$t = self::$pre.'<a href="#" class="current">'.$start.'</a>'.self::$end;
				else $t = self::$pre.'<a target="'.self::$target.'" href="'.$url.$separate.$start.'">'.$start.'</a>'.self::$end;
				$pageString .= $t;
			}
			if(isset($endString))$pageString .= $endString;
			$pageString .= self::$pre.'<a target="'.self::$target.'" href="'.$url.$separate.$pages.'">&rsaquo;|</a>'.self::$end;
			$pageString .= self::$pre.'<a>共'.self::$number.'条数据</a>'.self::$end;
			return $pageString;
		}
	}
}
?>