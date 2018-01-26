<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 11:03
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;
use app\api\service\Token;

class UserToken extends Token
{
    //成员变量
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {

        //拼接接口地址
        $this->code         =   $code;
        $this->wxAppID      =   config('wx.app_id');
        $this->wxAppSecret  =   config('wx.app_secret');
        $this->wxLoginUrl   =   sprintf(config('wx.login_url'),
                                $this->wxAppID, $this->wxAppSecret,$this->code);
    }

    public function getUserToken()
    {
        //使用拼接好的URL，发送HTTP请求
        $result = curl_get($this->wxLoginUrl);
        //$result的返回时是一个字符串，我们将它转为数组，好操作
        $wxResult = json_decode($result, true);
        //判断是否为空
        if(empty($result)) {
            //使用TP5自带的异常类抛出异常，目的是不要异常信息返回到客户端
            throw new Exception('微信内部错误，获取session_key及openid时错误');
        }else{
            //如果$result不为空，也要判断该数组下是否存在键值为`errcode`的成员
            $loginFail = array_key_exists('errcode', $wxResult);
            if($loginFail) {
                //也说明失败了，将结果返回给客户端
                return $this->processLoginError($wxResult);
            }else{
               return $this->grantToken($wxResult);
            }
        }
    }


    //根据小程序生成的`code`，获取openid
    private function grantToken($wxResult)
    {
        $openid = $wxResult['openid'];
        //﻿1、如果成功，就要拿到返回的`openid`，并去数据库查询此`openid`是否已经存在；
        $userInfo = UserModel::getUser($openid);
        //2、如果存在，则不处理；如果不存在，那么新增一条user记录（注册一个新用户）；
        if($userInfo) {
            //获取用户主键id，用于查找标识
            $uid = $userInfo->id;
        }else{
            //新增一条记录
            $userInfo = UserModel::createNewUser($openid);
            $uid = $userInfo->id;
        }
        //3、生成令牌。准备缓存数据并将数据写入缓存中；
        //key:Token令牌
        //value：wxResult、uid、scope(用户身份权限)
        //$cachedValue就是我们要保存在缓存中的数据
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        //4、将令牌返回到客户端中。
        return $token;
    }

    //生成Token。并将数据存入缓存中
    private function saveToCache($cachedValue)
    {
        //此方法在别的地方也可以用，可以写在Token基类中
        //因为可能还会有别的方法要生成调用Token
        $key = self::generateToken();
        //将数组转换为字符串（键值对）
        $value = json_encode($cachedValue);
        //每一个Token都需要定义一个有效期，我们可以将此有效期与缓存的时间关联起来
        $expire_in = config('setting.token_expire_in');
        //使用TP5自带的缓存
        //当然也可以使用Redis等缓存方法，但是都是使用cache方法
        $request = cache($key, $value, $expire_in);

        if(!$request) {
            throw new TokenException([
                'msg'       =>  '服务器缓存异常',
                'errorCode' =>  10005,
            ]);
        }
        return $key;
    }



    //需要存入缓存的用户信息
    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid']     =   $uid;
        //利用scope的值来对用户的省份进行区分
        //如16表示App的权限数值；32表示CMS(管理员)用户的权限数值
        $cachedValue['scope']   =   ScopeEnum::App_User;

        return $cachedValue;
    }

    //存在errorCode，自定义错误信息
    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg'   =>  $wxResult['errmsg'],
            'errorCode'  =>  $wxResult['errcode'],
        ]);
    }
}