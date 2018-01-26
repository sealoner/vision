<?php
/**
 * User: sealone
 * Date: 2018/1/25
 * Time: 19:04
 */

namespace app\api\validate;


use app\lib\exception\BaseException;

class SuccessMessage extends BaseException
{
    public $code      = 201;
    public $msg       = 'ok';
    public $errorCode = 0;
}