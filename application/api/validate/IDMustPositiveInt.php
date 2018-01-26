<?php
/**
 * User: sealone
 * Date: 2017/11/29
 * Time: 00:02
 */

namespace app\api\validate;


use think\Validate;

class IDMustPositiveInt extends BaseValidate
{
    protected $rule = [
        'id'    =>  'require|isPositiveInteger',
    ];
}