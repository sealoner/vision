<?php
/**
 * User: sealone
 * Date: 2018/1/28
 * Time: 00:06
 */

namespace app\api\validate;


use app\lib\exception\ParameteException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products'  =>  'checkProducts',
    ];

    protected $singleRule = [
        'product_id'    =>  'require|isPositiveInteger',
        'count'         =>  'require|isPositiveInteger'
    ];

    protected function checkProducts($values)
    {
        if(empty($values)) {
            throw new ParameteException(
                [
                    'msg'   =>  '商品参数不正确',
                ]);
        }
        if(!is_array($values)) {
            throw new ParameteException(
                [
                    'msg'   =>  '商品格式不正确',
                ]
            );
        }
        //假设传来的数据是二维数组，那么现在我们要验证二维数组中的数据了
        foreach ($values as $value) {
            $this->checkProduct($value);
        }
        return true;
    }

    //将验证规则和参数，手动的提交给Tp5自带的验证器中进行验证
    protected function checkProduct($value)
    {
        //其实就是在把参数传递给Validate基类中的构造函数
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if(!$result) {
            throw new ParameteException(
                [
                    'msg'   =>  '商品参数错误！',
                ]
            );
        }
    }
}