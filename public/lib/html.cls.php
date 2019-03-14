<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/11/23
 * Time: 9:46
 */

class html
{
    static public $dbvars;

    /**
     * @param $properties
     * @param null $value
     * @return array|bool
     */
    static public function buildHtml($properties,$value = null)
    {
        if(!is_array($properties))return false;
        $forms = array();
        foreach($properties as $property)
        {
            $tmp = array();
            $property['ppyhtmltype'] = strtolower($property['ppyhtmltype']);
            $tmp['title'] = $property['ppyname'];
            $tmp['id'] = $property['ppyfield'];
            $tmp['type'] = $property['ppyhtmltype'];
            $tmp['describe'] = $property['ppyintro'];
            if($property['ppyhtmltype'] != 'hidden')
            {
                if($property['ppyvalue'])
                {
                    $property['ppyvalue'] = self::_buildValues($property['ppyvalue']);
                }
                if(!$property['ppyvalue'])$property['ppyvalue'] = array();
                if($property['ppysource'])
                {
                    if(self::$dbvars)
                    {
                        foreach(self::$dbvars as $key => $p)
                        {
                            $property['ppysource'] = str_replace("{{$key}}","\"{$p}\"",$property['ppysource']);
                        }
                    }
                    $source = json_decode("[{$property['ppysource']}]",true);
                    if(count($source[0]) == 2)
                    {
                        $data = array(
                            'select' => implode(',',$source[0]),
                            'table' => $source[2],
                            'query' => $source[3],
                            'orderby' => $source[4],
                            'limit' => $source[5]?$source[5]:false
                        );
                        if(config::db[$source[1]])
                        {
                            $rs = pepdo::getInstance($source[1])->getElements($data);
                            if(count($rs))
                            {
                                foreach($rs as $p)
                                {
                                    $property['ppyvalue'][] = array('key' => $p[$source[0][0]],'value' => $p[$source[0][1]]);
                                }
                            }
                        }
                    }
                }
                if($property['ppyproperty'])
                {
                    $property['ppyproperty'] = self::_buildValues($property['ppyproperty']);
                }
                if(!$property['ppyproperty'])$property['ppyproperty'] = array();
                $property['ppyproperty'][] = array('key' => 'id','value' => $property['ppyfield']);
                $tmp['html'] = call_user_func('self::'.$property['ppyhtmltype'],array('properties' => $property['ppyproperty'],'values' => $property['ppyvalue']),$property['ppydefault'],$value[$property['ppyfield']]);
            }
            $forms[] = $tmp;
        }
        return $forms;
    }

    static public function setDbSourceVars($var,$value)
    {
        if(is_array($value))
        {
            self::$dbvars[$var] = json_encode($value);
        }
        else
        {
            self::$dbvars[$var] = $value;
        }
    }

    static private function _buildValues($values = false)
    {
        if(!$values)return false;
        $v = array();
        $tmp = explode("\n",$values);
        foreach($tmp as $value)
        {
            $t = explode('=',$value,2);
            $v[] = array('key'=>$t[0],'value'=>trim($t[1]));
        }
        return $v;
    }

    static private function _autoDefault($default)
    {
        switch($default)
        {
            case '{date}':
                $default = date('Y-m-d');
            break;

            case '{datetime}':
                $default = date('Y-m-d H:i:s');
            break;

            default:
            break;
        }
        return $default;
    }

    /**
     * @param $args => 'properties属性列表','values值列表'
     * @return string
     */
    static public function text($args,$default,$value)
    {
        $str = "<input ";
        if(is_array($args))
        {
            foreach($args['properties'] as $p)
            {
                if($p['key'] == 'id')
                {
                    $name = "args[{$p['value']}]";
                }
                if($p['key'] == 'type')
                {
                    $type = $p['value'];
                }
                $str .= "{$p['key']}=\"{$p['value']}\" ";
            }
        }
        if(!$type)$type = 'text';
        $str .= " type=\"{$type}\" name=\"{$name}\" ";
        if($value)
        {
            $str .= "value=\"{$value}\" ";
        }
        elseif($default)
        {
            $default = self::_autoDefault($default);
            $str .= "value=\"{$default}\" ";
        }
        else
        {
            $str .= "value=\"\" ";
        }
        $str .= " autocomplete=\"off\"/>";
        return $str;
    }

    static public function textarea($args,$default,$value)
    {
        $str = "<textarea ";
        if(is_array($args['properties']))
        {
            foreach($args['properties'] as $p)
            {
                if($p['key'] == 'id')
                {
                    $name = "args[{$p['value']}]";
                }
                $str .= "{$p['key']}=\"{$p['value']}\" ";
            }
        }
        $str .= "name=\"{$name}\" ";
        $str .= ">";
        if($value)
        {
            $str .= $value;
        }
        elseif($default)
        {
            $default = self::_autoDefault($default);
            $str .= $default;
        }
        $str .= "</textarea>";
        return $str;
    }

    public function thumb($args,$default,$value)
    {
        if(is_array($args['properties']))
        {
            $property = array();
            foreach($args['properties'] as $p)
            {
                if($p['key'] == 'id')
                {
                    $id = $p['value'];
                }
                else
                {
                    $property[] = "{$p['key']}=\"{$p['value']}\"";
                }
            }
            $name = "args[{$id}]";
            if(!$value)
            {
                $value = self::_autoDefault($default);
            }
            $property = implode(' ',$property);
            if(!$property)
            {
                $property = "class=\"qq-uploader-selector\"";
            }
        }
        else
        {
            return false;
        }
        $str = <<<EOF
    	<script type="text/template" id="pe-template-{$id}">
    		<div {$property}>
            	<div class="qq-upload-button-selector" style="clear:both;">
                	<ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
		                <li class="text-center">
		                    <div class="thumbnail">
								<img alt="点击上传新图片" class="qq-thumbnail-selector">
								<input type="hidden" class="qq-edit-filename-selector" name="{$name}" tabindex="0">
							</div>
		                </li>
		            </ul>
		            <ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
			            <li class="text-center">
			                <div class="thumbnail">
								<img src="{$value}" alt="点击上传新图片" class="qq-thumbnail-selector">
								<input type="hidden" class="qq-edit-filename-selector" name="{$name}" value="{$value}">
                			</div>
			            </li>
			        </ul>
                </div>
            </div>
        </script>
        <div class="fineuploader" attr-type="thumb" attr-template="pe-template-{$id}"></div>
EOF;
        return $str;
    }

    static public function picture($args,$default,$value)
    {
        if(is_array($args['properties']))
        {
            foreach($args['properties'] as $p)
            {
                if($p['key'] == 'id')
                {
                    $id = $p['value'];
                }
                else
                {
                    $property[] = "{$p['key']}=\"{$p['value']}\"";
                }
            }
            $name = "args[{$id}][]";
            if(!$value)
            {
                $value = self::_autoDefault($default);
            }
            $property = implode(' ',$property);
            if(!$property)
            {
                $property = "class=\"qq-uploader-selector\"";
            }
        }
        $str = "<div class=\"sortable\" id=\"{$id}-range\" style=\"margin-left:-15px;\">";
        if(is_array($value))
        {
            foreach($value as $v)
            {
                if($value)
                {
                    $str .= <<<EOF
                    <div class="col-xs-3 listimgselector">
                        <a class="thumbnail">
                            <img class="qq-thumbnail-selector" src="$v">
                            <input type="hidden" class="qq-edit-filename-selector" name="$name" tabindex="0" value="$v">
                        </a>
                    </div>
EOF;
                }
            }
        }
        $str .= "</div>";
        $str .= <<<EOF
		<script type="text/template" id="pe-template-$id">
    		<div class="qq-uploader-selector" qq-drop-area-text="可将图片拖拽至此处上传" style="clear:both;">
            	<div class="qq-upload-list-selector hide" aria-live="polite" aria-relevant="additions removals">
					<span></span>
				</div>
				<div class="listimg hide">
					<div class="col-xs-3 listimgselector">
						<a class="thumbnail">
						    <img class="qq-thumbnail-selector" alt="点击上传新图片" src="*value*">
						    <input type="hidden" class="qq-edit-filename-selector" name="*name*" tabindex="0" value="*value*">
						</a>
					</div>
				</div>
				<div class="qq-upload-button-selector qq-upload-button" style="clear:both;">
                    <a class="btn btn-primary">添加文件</a>
                </div>
            </div>
        </script>
        <div class="fineuploader" attr-box="{$id}-range" attr-name="{$name}" attr-type="list" attr-list="true" attr-template="pe-template-{$id}"></div>
EOF;
        return $str;
    }

    static public function videotext($args,$default,$value)
    {
        if(is_array($args['properties']))
        {
            foreach($args['properties'] as $p)
            {
                if($p['key'] == 'id')
                {
                    $id = $p['value'];
                }
                else
                {
                    $property[] = "{$p['key']}=\"{$p['value']}\"";
                }
                if($p['key'] == 'attr-ftype')
                {
                    $ftype = $p['value'];
                }
            }
        }
        if(!$ftype)$ftype = 'mp4';
        $name = "args[{$id}]";
        if(!$value)
        {
            $value = self::_autoDefault($default);
        }
        $property = implode(' ',$property);
        if(!$property)
        {
            $property = "class=\"qq-uploader-selector\"";
        }
        $str = <<<EOF
    	<script type="text/template" id="pe-template-$id">
    		<div {$property}>
            	<ul class="qq-upload-list-selector list-unstyled pull-left" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
	                <li class="text-center">
						<input size="45" class="form-control qq-edit-filename-selector" type="text" name="{$name}" tabindex="0" value="">
	                </li>
	            </ul>
	            <ul class="qq-upload-list-selector list-unstyled pull-left" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
	                <li class="text-center">
	                    <input size="45" class="form-control qq-edit-filename-selector" type="text" name="{$name}" tabindex="0" value="{$value}">
	                </li>
	            </ul>
            	<div class="qq-upload-button-selector col-xs-3">
					<button class="btn btn-primary">上传文件<span class="process"></span></button>
                </div>
            </div>
        </script>
        <div class="fineuploader" attr-type="files" attr-template="pe-template-{$id}" attr-ftype="{$ftype}"></div>
EOF;
        return $str;
    }

    static public function editor($args,$default,$value)
    {
        if(is_array($args['properties']))
        {
            foreach($args['properties'] as $p)
            {
                if($p['key'] == 'id')
                {
                    $id = $p['value'];
                }
                $property[] = "{$p['key']}=\"{$p['value']}\"";
            }
        }
        $name = "args[{$id}]";
        if(!$value)
        {
            $value = self::_autoDefault($default);
        }
        $property = implode(' ',$property);
        $str = "<textarea name=\"{$name}\" ";
        $str .= " {$property}";
        $str .= ">".$value."</textarea>";
        return $str;
    }

    static public function select($args,$default,$value)
    {
        if(!$value)
        {
            $value = self::_autoDefault($default);
        }
        if(is_array($args['properties']))
        {
            foreach($args['properties'] as $key => $p)
            {
                if($p['key'] == 'id')
                {
                    $id = $p['value'];
                }
                $property[] = "{$p['key']}=\"{$p['value']}\"";
            }
        }
        $property = implode(' ',$property);
        $name = "args[{$id}]";
        $str = "<select name=\"{$name}\" {$property}>";
        if(is_array($args['values']))
        {
            foreach($args['values'] as $p)
            {
                if($p['value'] == $value)
                {
                    $str .= "<option value='{$p['value']}' selected>{$p['key']}</option>\n";
                }
                else
                {
                    $str .= "<option value='{$p['value']}'>{$p['key']}</option>\n";
                }
            }
        }
        $str .= "</select>";
        return $str;
    }

    public function radio($args,$default,$value)
    {
        if(!$value)
        {
            $value = self::_autoDefault($default);
        }
        if(is_array($args['properties']))
        {
            foreach($args['properties'] as $key => $p)
            {
                if($p['key'] == 'id')
                {
                    $id = $p['value'];
                }
                else
                {
                    $property[] = "{$p['key']}=\"{$p['value']}\"";
                }
            }
        }
        $property = implode(' ',$property);
        $name = "args[{$id}]";

        $str = "";
        foreach($args['values'] as $key => $p)
        {
            $str .= "<label class=\"radio-inline\"><input type=\"radio\" name=\"{$name}\" value=\"{$p['value']}\" {$property}";
            if($p['value'] == $value)
            {
                $str .= " checked";
            }
            $str .= "/><span>{$p['key']}</span></label>";
        }
        return $str;
    }

    public function checkbox($args,$default,$value)
    {
        if(!$value)
        {
            $value = explode(',',self::_autoDefault($default));
        }
        if(is_array($args['properties']))
        {
            foreach($args['properties'] as $key => $p)
            {
                if($p['key'] == 'id')
                {
                    $id = $p['value'];
                }
                else
                {
                    $property[] = "{$p['key']}=\"{$p['value']}\"";
                }
            }
        }
        $property = implode(' ',$property);
        $name = "args[{$id}][]";

        $str = "";
        foreach($args['values'] as $key => $p)
        {
            $str .= "<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"{$name}\" value=\"{$p['value']}\" {$property}";
            if(in_array($p['value'],$value))
            {
                $str .= " checked";
            }
            $str .= "/><span>{$p['key']}</span></label>";
        }
        return $str;
    }
}