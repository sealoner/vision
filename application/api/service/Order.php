<?php
/**
 * User: sealone
 * Date: 2018/1/28
 * Time: 18:37
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use think\Exception;

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
     * 该方法做两个事情：
     * 1、库存量检测
     * 2、库存量检测通过才可以将订单插入到数据表中，创建订单
     * @author shier
     * @time 2018/1/28 18:43
     */
    public function place($uid, $oProducts)
    {
        $this->oProducts = $oProducts;
        $this->uid = $uid;
        $this->products = self::getProductsByOrder($oProducts);
        //获取订单状态
        $status = $this->getOrderStatus();
        if(!$status['pass']) {
            //如果订单创建成功，则生成订单号
            //如果订单创建失败，为了在数据表中使订单的编号信息保持一致，也需要给失败的订单一个订单号
            $status['order_id'] = -1;
            return $status;
        }
        //创建订单
        $orderSnap = $this->snapOrder($status);
        //写入订单数据
        $createOrder = $this->createOrder($orderSnap);
    }

    /**
     * 将订单信息存入数据表
     */
    private function createOrder($snap)
    {
        try{
            //获取订单号
            $orderNo = self::makeOrderNo();
            $order = new \app\api\model\Order();

            $order->order_no = $orderNo;
            $order->user_id   = $this->uid;
            $order->total_price = $snap['orderPrice'];
            $order->status = '';
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->total_count = $snap['totalCount'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->snap_address = $snap['snapAddress'];
            //使用saveAll()方法将数组数据存入数据表中
            $order->save();
            //将相关信息存入order_product中间表中
            //其实就是将order表中的主键ID存入$oProducts数组中
            $orderID = $order->id;
            $create_time = $order->create_time;
            foreach($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            return [
                'order_no'      =>  $orderNo,
                'order_id'      =>  $orderID,
                'create_time'   =>  $create_time,
            ];
        }catch(Exception $ex){
            throw $ex;
        }

    }


    /**
     * 订单号生成
     * 该方法可以很巧妙的缩短订单号的长度
     */
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2018] .//
            strtoupper(dechex(date('m'))) .
            date('d') .
            substr(time(), -5) .
            substr(microtime(), 2, 5) .
            sprintf('%02d', rand(0, 99));//如生成的随机数是一位数，则在前面加0
        return $orderSn;
    }

    /**
     * 订单快照
     * 保存商品下单那一刻的信息
     */
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,//订单总价
            'totalCount' => 0,
            'pStatus'    => [],//商品详情
            'snapAddress'=> null,
            'snapName'   => '',
            'snapImg'    => '',
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus']    = $status['pStatusArray'];
        $snap['snapAddress']= json_encode($this->getUserAddress());

        //规定以第一个订单的信息作为缩略信息
        $snap['snapName']   = $this->products[0]['name'];
        //对商品的种类进行判断，如果有多个类别，就要加个'等'
        if(count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }

        $snap['snapImg']   = $this->products[0]['main_img_url'];

        return $snap;
    }

    /**
     * 判断是否存在收货地址
     */
    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if(!$userAddress) {
            throw new OrderException([
                'msg'   =>  '用户收货地址不存在，下单失败',
                'errorCode' => 60001,
            ]);
        }
        //查询出来的是一个对象，需要转换为数组
        return $userAddress->toArray();
    }


    /**
     * 检测整体订单状态
     */
    private function getOrderStatus()
    {
        $status = [
            'pass'          => true,//是否通过
            'orderPrice'    => 0,//整个订单的总价格
            'pStatusArray'  => [],//用来存放通过的商品的详情
            'totalCount'    => '',//所有商品总和
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
            //整个订单所有商品总和
            $status['totalCount'] += $pStatus['count'];
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