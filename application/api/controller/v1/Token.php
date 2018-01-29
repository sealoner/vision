<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 10:52
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenCode;
use think\Controller;
use think\Request;

class Token extends Controller
{
    public function __construct($code)
    {
//        var_dump($code);die();
    }

    //小程序会自动为每一个用户生成一个Code数字码，我们要做的就是将这个Code数字码传递给getToken接口
    public function getToken($code = '')
    {

        //校验$code
        (new TokenCode())->goCheck();
        $token = new UserToken($code);
        $wxToken = $token->getUserToken();
        //我们所有的返回结果都要求是json格式的
        //所以这里的返回值应该以关联数组的形式返回
        //框架会默认序列化成JSON的形式
        return [
            'token' =>  $wxToken,
        ];
    }

    public function test()
    {
        return \app\api\service\Token::getCurrentTokenVar(1);
    }
}