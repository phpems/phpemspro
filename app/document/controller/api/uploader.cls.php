<?php
/*
 * Created on 2016-5-19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

namespace document\controller\api;

class uploader
{
    public function __construct()
    {
        $this->allowexts = array('csv','swf','jpg','png','mp4');
    }

    public function ckeditor()
	{
        $fn = \route::get('CKEditorFuncNum');
        $upfile = \route::getFile('upload');
        $path = 'files/attach/files/content/'.date('Ymd').'/';
        $args['attext'] = \files::getFileExtName($upfile['name']);
        if(!in_array(strtolower($args['attext']),$this->allowexts))
        {
            $message = '上传失败，附件类型不符!';
            $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.',false, \''.$message.'\');</script>';
            exit($str);
        }
        if($upfile)
		{
			$fileurl = \files::uploadFile($upfile,$path,NULL,NULL,$this->allowexts);
		}
        if($fileurl)
        {
            $message = '上传成功!';
            $args = array();
            $args['attpath'] = $fileurl;
            $args['atttitle'] = $upfile['name'];
            $args['attext'] = \files::getFileExtName($upfile['name']);
            $args['attsize'] = $upfile['size'];
            $args['attuserid'] = $this->_user['sessionuserid'];
            $args['attcntype'] = $upfile['type'];
            //$this->attach->addAttach($args);
            $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>';
        }
        else
        {
            $message = '上传失败，附件类型不符!';
            $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.',false, \''.$message.'\');</script>';
        }
        echo $str;
	}

    public function fineuploader()
	{
		$args = array();
		$path = 'files/attach/images/content/'.date('Ymd').'/';
		$upfile = \route::getFile('qqfile');
		$args['attext'] = \files::getFileExtName($upfile['name']);
		if(!in_array(strtolower($args['attext']),$this->allowexts))
		{
			exit(json_encode(array('status' => 'fail')));
        }
		if($upfile)
		{
			$fileurl = \files::uploadFile($upfile,$path);
        }
		if($fileurl)
		{
			$args['attpath'] = $fileurl;
			$args['atttitle'] = $upfile['name'];

			$args['attsize'] = $upfile['size'];
			$args['attuserid'] = $this->_user['sessionuserid'];
			$args['attcntype'] = $upfile['type'];
			//$this->attach->addAttach($args);
			if(\route::get('imgwidth') || \route::get('imgheight'))
			{
				if(\files::thumb($fileurl,$fileurl.'.png',\route::get('imgwidth'),\route::get('imgheight')))
				$thumb = $fileurl.'.png';
				else
				$thumb = $fileurl;
			}
			else
			$thumb = $fileurl;
			exit(json_encode(array('success' => true,'thumb' => $thumb,'title' => $upfile['name'])));
		}
		else
		{
			exit(json_encode(array('status' => 'fail')));
		}
	}
}


?>
