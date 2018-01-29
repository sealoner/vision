<?php
/**
 * User: sealone
 * Date: 2017/12/23
 * Time: 00:42
 */

namespace app\lib\exception;


use think\Exception;

class CategoryException extends Exception
{
    public $code        =   500;
    public $msg         =   '参数错误或没有返回值';
    public $errorCode   =   50000;
}