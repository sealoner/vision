<?php
/**
 * User: sealone
 * Date: 2017/12/21
 * Time: 09:33
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\IDMustPositiveInt;
use app\lib\exception\ProductException;
use think\Controller;
use app\api\model\Product as ProductModel;

class Product extends Controller
{
    //获得最新的产品列表
    public function getRecent($count=14)
    {
        //验证$count是否符合标准
        (new Count())->goCheck();
        $data = ProductModel::getMostRecent($count);
        if($data->isEmpty()) {
            throw new ProductException();
        }
        $data = $data->hidden(['summary']);
        return $data;
    }

    //获取当前分类下的全部商品信息
    public function getAllProductInCategory($id)
    {
        //验证参数
        (new IDMustPositiveInt())->goCheck();
        $products = ProductModel::getProductById($id);
        if($products->isEmpty()) {
            throw new ProductException();
        }
        return $products;
    }

    /**
     * 获取商品详情
     * @author xiefeng
     * @time 2018/1/14 22:11
     */
    public function getOne($id)
    {
        (new IDMustPositiveInt())->goCheck();
        $res = ProductModel::getGoodsDetail($id);
        if(!$res) {
            throw new ProductException();
        }
        return $res;
    }

    //删除单个商品
    public function deleteOne($id)
    {

    }
}