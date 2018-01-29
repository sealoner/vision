<?php
/**
 * User: sealone
 * Date: 2018/1/28
 * Time: 18:37
 */

namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    //$oProducts的大概数据结构
//    protected $oProducts = [
//        [
//            'product_id'    =>  1,
//            'counts'        =>  10,
//        ],
//        [
//            'product_id'    =>  2,
//            'counts'        =>  20,
//        ],
//        [
//            'product_id'    =>  3,
//            'counts'        =>  30,
//        ],
//    ];

    //客户端传递来的订单数据
    protected $oProducts;
    //根据传递的商品ID，获取的数据库中对应的商品信息
    protected $products;
    //用户uid
    protected $uid;

    /**
     * 下单方法
     * 做库存量检测，检测通过才可以将订单插入到数据表中
     * @author shier
     * @time 2018/1/28 18:43
     */
    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->uid = $uid;
        $this->products = self::getProductsByOrder($oProducts);
    }

    /**
     * 检测整体订单状态
     */
    private function getOrderStatus()
    {
        $status = [
            'pass'          => true,//是否通过
            'orderPrice'    =>  0,//整个订单的总价格
            'pStatusArray'  =>  [],//用来存放通过的商品的详情
        ];
        //遍历客户端传来的数据：$oProducts
        //遍历出来的是订单中单个商品的信息
        foreach ($this->oProducts as $oProducts) {
            $pStatus = $this->getProductStatus(
                $oProducts['product_id'],$oProducts['count'],$this->products
            );
            //根据单个商品的状态判断整个订单是否通过
            if(!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            //整个订单的总价格
            $status['orderPrice'] += $pStatus['totalPrice'];
            //将每一个商品的详细信息放入一个数组中
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    /**
     * 检测订单中商品的状态
     */
    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;
        //这里面保存着单个商品的详细信息，是需要放在getOrderStatus()中的$status['pStatusArray']中的
        $pStatus = [
            'id'        =>  null,
            'haveStock' =>  false,//当前商品是否有库存
            'count'     =>  0,//单个商品的订单数量
            'name'      =>  '',
            'totalPrice'=>  0,//单个商品的价格（商品数量✖商家单价）
        ];
        //首先要根据客户端传递的商品ID，判断该商品在数据表中是否存在
        //主要是根据id进行比较
        for($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
            if ($pIndex == -1) {
                throw new OrderException([
                    'msg' => '商品为' . $products['name'] . '不存在，订单创建失败',
                ]);
            }else{
                $product = $products[$pIndex];
                $pStatus['id']      = $product['id'];
                $pStatus['count']   = $oCount;
                $pStatus['name']    = $product['name'];
                if($product['stock']-$oCount >= 0) {
                    $pStatus['haveStock'] = true;
                }
                $pStatus['totalPrice'] = $oCount * $product['price'];
            }
            return $pStatus;
        }
    }

    /**
     * 通过订单中的商品ID获取数据库中的商品信息
     */
    private function getProductsByOrder($oProducts)
    {
        //将$oProducts['product_id']循环到一个数组中
        $oPIDs = [];
        foreach($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        //查询，并将结果转换为数组
        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $products;
    }
}