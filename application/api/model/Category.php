<?php
/**
 * User: sealone
 * Date: 2017/12/23
 * Time: 00:37
 */

namespace app\api\model;


use app\lib\exception\CategoryException;

class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];


    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function product()
    {
        return $this->hasMany('Product', 'category_id', 'id');
    }

    //获取category全部信息
    public static function getCategoriseForAll()
    {
        $categories = self::all([],'img,product');
        return $categories;
    }

}