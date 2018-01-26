<?php
/**
 * Created by vision.
 * User: sealone
 * Date: 2017/11/26
 * Time: 下午8:55
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate
{
    //固定写法
    protected $rule = [
        'name'  =>  'require|max:10',
        'email' =>  'email',
    ];
}