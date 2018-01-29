<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 16:08
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg  = 'wechat unknow error';
    public $errorCode = 999;
}