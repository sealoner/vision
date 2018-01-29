<?php
/**
 * User: sealone
 * Date: 2018/1/17
 * Time: 19:15
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        'name'              =>  'require|isNotEmpty',
        'mobile'            =>  'require|isMobile',
        'province'          =>  'require|isNotEmpty',
        'city'              =>  'require|isNotEmpty',
        'country'           =>  'require|isNotEmpty',
        'detail'            =>  'require|isNotEmpty',
    ];
}