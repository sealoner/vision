<?php
/**
 * User: sealone
 * Date: 2017/12/18
 * Time: 11:13
 */

namespace app\api\model;

use app\api\validate\IDCollection;
use app\api\validate\IDMustPositiveInt;

class Theme extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'topic_img_id', 'head_img_id'];
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    //多对多
    public function products()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    public static function getThemesByIDs($ids)
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = self::with('topicImg,headImg')
            ->select($ids);
        return $result;
    }

    public static function getThemeWithProducts($id)
    {
        (new IDMustPositiveInt())->goCheck();
        $result = self::with('products,topicImg,headImg')
                ->select($id);
        return $result;
    }
}