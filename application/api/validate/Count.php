<?php
/**
 * User: sealone
 * Date: 2017/12/21
 * Time: 23:37
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    public $rule = [
        'count' => 'isPositiveInteger|between:1,15',
    ];
}