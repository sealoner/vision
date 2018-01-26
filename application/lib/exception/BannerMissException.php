<?php
/**
 * User: sealone
 * Date: 2017/12/3
 * Time: 23:47
 * 请求数据不存在
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Banner数据不存在';
    public $errorCode = '40000';
}