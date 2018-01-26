<?php
/**
 * User: sealone
 * Date: 2018/1/25
 * Time: 18:53
 */

namespace app\api\validate;


use app\lib\exception\BaseException;

class UserException extends BaseException
{
    public $code        =   500;
    public $msg         =   '参数错误或没有返回值';
    public $errorCode   =   50000;
}