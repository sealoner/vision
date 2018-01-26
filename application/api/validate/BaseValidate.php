<?php
/**
 * User: sealone
 * Date: 2017/11/29
 * Time: 23:34
 */

namespace app\api\validate;


use app\lib\exception\ParameteException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 作用是获取所有的参数，并对所有的参数做校验
     */
    public function goCheck()
    {
        //获取http传入的参数
        $request = Request::instance();
        $params = $request->param();
        //对参数做校验
        $result = $this->batch()->check($params);
        if(!$result){
            $e = new ParameteException([
               'msg'        =>  $this->getError(),
//               'code'       =>  400,
//               'errorCode'  =>  10002,
            ]);
            //通过Validate类中的getError()方法获取异常信息，并替换全局异常处理中的$msg
//            $error = $this->getError();
//            $e->msg =   $error;
            throw $e;
        }else{
            return true;
        }

    }

    //判断参数是否为正整数
    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value+0)>0) {
            return true;
        }else{
            return false;
        }
    }

    //校验Code是否为空
    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if(empty($value)) {
            return false;
        }else{
            return true;
        }
    }

    //校验手机号码是否正确
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if($result) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * 根据定义好的字段验证规则获取数据
     */
    public function getDataByRule($arrays)
    {
        //判断前端传入的字段中是否包含uid或user_id
        //因为我们都是通过Token令牌来获取用户的id的，如果包含这两个字段，则是恶意数据
        if(array_key_exists('uid', $arrays) || array_key_exists('user_id', $arrays)) {
            throw new ParameteException([
                'msg'   =>  '传递的参数中包含违法字段',
            ]);
        }
        //因为BaseValidate是验证器的基类，所有的验证器都会继承它，而在验证器中定义验证的字段是$rule数组，所以可以直接遍历该数组
        $ruleArrays = [];
        foreach($this->rule as $key => $value) {
            $ruleArrays[$key] = $arrays[$key];
        }
        return $ruleArrays;
    }
}