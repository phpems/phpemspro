<?php
/*
 * Created on 2007-9-3
 *
 *
 * STRING CLASS
 */

class strings
{

	static function isEmail($str)
	{
		$j = "/^[\w|\.]+@\w+\.\w+/i";
		if(preg_match($j,$str))return $str;
		else return false;
	}

	static function isTelphone($str)
	{
		$j = "/^\d+-?\d+/i";
		if(preg_match($j,$str))return $str;
		else return false;
	}

	static function isZipCode($str)
	{
		$j = "/^\d{6}/i";
		if(preg_match($j,$str))return $str;
		else return false;
	}

	static function isUserName($str)
	{
		if(config::webencode == 'utf-8')
		{
			//if(eregi('^[\u0391-\uFFE5|\w]{2,40}$',$str))
			if(preg_match('/^[\x7f-\xff|\w]{2,40}$/i',$str))
			return $str;
			else return false;
		}
		else return true;
	}

	static function isAllowKey($str)
	{
		//$j = "/^[\w|\[|\]|\-|_]+$/i";
		$j = "/^[\w|\-|_]+$/i";
		if(preg_match($j,$str))return $str;
		else return false;
	}

	static function isPassword($str)
	{
		if(strlen($str)>=6)
		return $str;
		else return false;
	}

	static function isUrl($str)
	{
		$j = "/^http:\/\/.+/i";
		if(preg_match($j,$str))return $str;
		else return false;
	}

	static function isCellphone($str)
	{
		$j = "/^1[3,4,5,6,7,8,9]\d{9}/i";
		if(preg_match($j,$str))return $str;
		else return false;
	}

	static function subString($str,$lenth,$start = 0)
	{
		if(strlen($str) < $lenth && !$start)return $str;
		if(config::webencode == 'utf-8')$l = 3;
		else $l = 2;
		$k = 1;
		if($start)
		{
			$m = $start;
			while($k)if(ord($str[--$m]) < 128)$k = 0;
			$k = $l - ($lenth-$m)%$l;
			$start = $start + $k;
		}
		$t = substr($str,$start,$lenth);
		$m = $lenth;
		$k = 1;
		while($k)if(ord($t[--$m]) < 128)$k = 0;
		$k = ($lenth-1-$m)%$l;
		if($k)$t = substr($t,0,$lenth-$k);
		if($start)
		return $t;
		else
		return $t.'...';
	}

	static function hexString($str,$hex = 16)
	{
		$tmp = "";
		$e = strlen($str);
		if(!$e)return false;
		for($i=0;$i<$e;$i++)
		{
			$t = base_convert(ord($str[$i]),10,16);
			$tmp .= "\x{$t}";
		}
		return $tmp;
	}

	static function encode($info)
	{
		$info = serialize($info);
		$key = CS;
		$kl = strlen($key);
		$il = strlen($info);
		for($i = 0; $i < $il; $i++)
		{
			$p = $i%$kl;
			$info[$i] = chr(ord($info[$i])+ord($key[$p]));
		}
		return urlencode($info);
	}

	static function decode($info)
	{
		$key = CS;
		$info = urldecode($info);
		$kl = strlen($key);
		$il = strlen($info);
		for($i = 0; $i < $il; $i++)
		{
			$p = $i%$kl;
			$info[$i] = chr(ord($info[$i])-ord($key[$p]));
		}
		$info = unserialize($info);
		return $info;
	}

	static function enstr($str)
	{
		$str = base64_encode($str);
		$str = str_replace(array('+','/','='),array('-','_',''),$str);
		return $str;
	}

	static function destr($str)
	{
		$str = str_replace(array('-','_'),array('+','/'),$str);
		$str = base64_decode($str);
		return $str;
	}

	static function parseDataImg($str)
	{
		$str = str_replace('<IMG','<img',$str);
		$imgs = explode('<img',$str);
		$pimgs = array();
		$nimgs = array();
		foreach($imgs as $img)
		{
			$img = str_replace('SRC','src',$img);
			$img = explode('src="data',$img);
			if($img[1])
			{
				$img = $img[1];
				$img = explode('"',$img);
				$img = $img[0];
				$pimgs[] = 'data'.$img;
				$img = explode("/",$img,2);
				$img = explode(";",$img[1]);
				$ext = $img[0];
				$img = explode(',',$img[1]);
				$cnt = base64_decode($img[1]);
				$path = 'files/attach/files/content/'.date('Ymd').'/'.time().rand(1000,9999).'.'.$ext;
				\files::writeFile($path,$cnt);
				$nimgs[] = $path;
			}
		}
		$str = str_replace($pimgs,$nimgs,$str);
		return $str;
	}

	static function parseSelector($selector)
	{
        $i = 0;
		$index = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
		$selector = str_ireplace(array('<hr>','<hr />'),'<hr/>',$selector);
		foreach($index as $p)
		{
            $selector = str_replace("[[{$p}]]",'',$selector);
		}
		$selector = explode('<hr/>',$selector);
		$selectors = array();
		foreach($selector as $p)
		{
			$p = trim($p);
			if(strtolower(substr($p,0,3)) == '<p>')
			$p = substr($p,3);
            if(strtolower(substr($p,-4)) == '</p>')
			$p = substr($p,0,-4);
			$selectors[] = array($index[$i++],"<p>{$p}</p>");
		}
		return $selectors;
	}
}
?>
