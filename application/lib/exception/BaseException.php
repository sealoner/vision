<?php
/**
 * User: sealone
 * Date: 2017/12/3
 * Time: 23:40
 * 这个类的主要作用是将一些零散的功能封装起来
 */

namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    //HTTP状态码
    public $code = 400;
    //错误的具体信息
    public $msg = '参数错误';
    //自定义的错误码
    public $errorCode = 10000;

    //功能类的构造函数
    public function __construct($params=[])
    {
        if(!is_array($params)) {
            return;
        }

        if (array_key_exists('code', $params)) {
            $this->code     =   $params['code'];
        }

        if (array_key_exists('msg', $params)){
            $this->msg      =   $params['msg'];
        }

        if (array_key_exists('errorCode', $params)) {
            $this->errorCode=   $params['errorCode'];
        }
    }
}