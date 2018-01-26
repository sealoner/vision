<?php
/**
 * User: sealone
 * Date: 2017/12/18
 * Time: 11:12
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['create_time', 'pivot', 'delete_time', 'update_time'];

    //商品详情关联
    public function productImage()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }
    //商品属性关联
    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    //定义一个读取器，调用基类中的prefixImgUrl()方法
    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }


    //最新商品排列
    public static function getMostRecent($count)
    {
        $result = self::limit($count)
                ->order('create_time desc')
                ->select();
        return $result;
    }

    //根据category_id获取商品信息
    public static function getProductById($id)
    {
        $products = self::where('category_id', '=', $id)
                ->select();
        return $products;
    }

    //获取单一的商品详情
    public static function getGoodsDetail($id)
    {
        $productInfo = self::with([
            'productImage'  =>  function($query){
                $query->with(['imgUrl'])
                      ->order('order', 'asc');
            }])
                ->with(['properties'])
                ->find($id);
        return $productInfo;
    }

}