<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 10:55
 */

namespace app\api\validate;


class TokenCode extends BaseValidate
{
    public $rule = [
        'code|数字码'  =>  'require|isNotEmpty',
    ];

    public $message = [
        'code.isNotEmpty'   =>  '数字码必须有值',
    ];
}