<?php
/**
 * User: sealone
 * Date: 2017/12/21
 * Time: 23:44
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code        =   404;
    public $msg         =   '参数错误或没有返回值';
    public $errorCode   =   20001;
}