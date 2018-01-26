<?php
/**
 * User: sealone
 * Date: 2017/12/19
 * Time: 13:39
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code      = 404;
    public $msg       = '指定的主题不存在，请检查主题ID';
    public $errorCode = 30000;
}