<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 18:35
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code      = 401;
    public $msg       = 'Token已过期或Token无效';
    public $errorCode = 100001;
}