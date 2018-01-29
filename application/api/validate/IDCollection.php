<?php
/**
 * User: sealone
 * Date: 2017/12/18
 * Time: 15:41
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids'   =>  'require|checkIDs',
    ];
    protected $message = [
        'ids'   =>  '参数必须是以逗号分隔的多个正整数',
    ];

    protected function checkIDs($value)
    {
        //$value为URL中传递过来的参数，先分割成数组
        $values = explode(',', $value);
        //判断数组是否为空
        if(empty($values)) {
            return false;
        }
        //判断数组中的成员是否符合规则
        foreach($values as $v) {
            if(!$this->isPositiveInteger($v)){
                return false;
            }
        }
        return true;
    }
}