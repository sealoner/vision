<?php
/**
 * User: sealone
 * Date: 2018/1/28
 * Time: 20:33
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg  = '订单不存在，请检查ID';
    public $errorCode = 80000;
}