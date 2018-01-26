<?php
/**
 * User: sealone
 * Date: 2017/12/4
 * Time: 17:28
 */

namespace app\lib\exception;


class ParameteException extends BaseException
{
    public $code        =   400;
    public $msg         =   '参数错误，请重写提交';
    public $errorCode    =   10000;  //10000是通用参数错误
}