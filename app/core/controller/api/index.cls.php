<?php
/**
 * Created by PhpStorm.
 * User: 火眼
 * Date: 2018/2/10
 * Time: 14:44
 */

namespace core\controller\api;

class index
{
    public function __construct()
    {
        //
    }

    public function sendsms()
    {
        $phonenumber = \route::get('phonenumber');
        $action = \route::get('action');
        if(!\strings::isCellphone($phonenumber))
        {
            $message = array(
                'statusCode' => 300,
                'message' => '错误的手机号码'
            );
            exit(json_encode($message));
        }
        $user = \user\model\users::getUserByPhone($phonenumber);
        if(!$user && $action != 'reg')
        {
            $message = array(
                'statusCode' => 300,
                'message' => '该手机号未注册'
            );
            exit(json_encode($message));
        }
        if($user && $action == 'reg')
        {
            $message = array(
                'statusCode' => 300,
                'message' => '该手机号已注册'
            );
            exit(json_encode($message));
        }
        if(!$action)$action = 'findpassword';
        $randcode = rand(1000,9999);
        $_SESSION['phonerandcode'] = array(
            $action => $randcode,
            $action.'phonenumber' => $phonenumber
        );
        include_once "public/vendor/aliyun/SignatureHelper.php";
        $params = array ();

        // *** 需用户填写部分 ***
        // fixme 必填：是否启用https
        $security = false;

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = \config::aliyunsms['accessid'];
        $accessKeySecret = \config::aliyunsms['accesskey'];

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = \config::aliyunsms['signature'];

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $phonenumber;

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        //$params["TemplateCode"] = "SMS_0000001";
        if($user)
        {
            if($action == 'findpassword')
            {
                $params["TemplateCode"] = \config::aliyunsms['findpasstpl'];
            }
        }
        else
        {
            if($action == 'reg')
            {
                $params["TemplateCode"] = \config::aliyunsms['regtpl'];
            }
        }

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => $randcode,
            "name" => $phonenumber
        );

        // fixme 可选: 设置发送短信流水号
        //$params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        //$params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new \Aliyun\DySDKLite\SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            )),
            $security
        );
        $message = array(
            'statusCode' => 200
        );
        exit(json_encode($message));
    }

    public function index()
    {
		//
    }
}