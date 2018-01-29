<?php
/**
 * User: sealone
 * Date: 2018/1/26
 * Time: 23:15
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg  = '无访问权限';
    public $errorCode = 10001;
}