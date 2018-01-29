<?php
/**
 * User: sealone
 * Date: 2018/1/27
 * Time: 18:33
 */

namespace app\api\controller\v1;


use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;

class Order extends BaseController
{
    /*
     *  前置方法
     */
    protected $beforeActionList = [
        "checkExclusiveScope"   =>  ["only" => "placeOrder"],
    ];

    /**
     * 下单接口
     * 只有用户可以调用
     */
    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        //获取客户端传来的数组类型的订单数据
        $product = input('post.products/a');
        $uid = TokenService::getCurrentUid();

    }
}