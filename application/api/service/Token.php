<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 17:55
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    //生成Token
    public static function generateToken()
    {
        $length = 32;
        //由32个字符组成的随机字符串
        $randChars = getRandChar($length);
        //还可以加强安全性
        //用三组字符串进行md5加密
        //$_SERVER['REQUEST_TIME'];得到的是该行代码被请求时的时间戳
        $timestamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');

        return md5($randChars.$timestamp.$salt);
    }

    //获取当前登录用户的Token、并获取对应的缓存数据
    public static function getCurrentTokenVar($key)
    {
        //因为Token是在我们客户端打开时就会生成的，所以我们规定，Token数据都是放在header中传递给客户端的
        $token = Request::instance()
                        ->header('token');
        //然后根据获取到的Token值，去缓存中查看是否有以该Token值为名的缓存数据
        $vars = Cache::get($token);
        //如果没有，抛出异常，如果有，转成数据
        if(!$vars){
            throw new TokenException();
        }else{
            //判断：如果$vars不是数组的话，再转换
            if(!is_array($vars)){
                $vars = json_decode($vars, true);
            }
        }
        //现在已经把缓存中的数据转换成数组了，那么就要判断这个数据中有没有我们想要获取的数据了，也就是是否存在键值为$key的属性了
        if(array_key_exists($key, $vars)){
            return $vars[$key];
        }else{
            throw new Exception('缓存中并不存在要获取的变量信息');
        }

    }

    //获取当前的uid
    public static function getCurrentUid()
    {
        //1、获取当前登录用户的Token值，用于获取缓存数据
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}