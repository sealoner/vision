<?php
/**
 * User: sealone
 * Date: 2017/12/3
 * Time: 22:09
 */

namespace app\api\model;

use think\Db;
use think\Model;

class Banner extends BaseModel
{

    //获取当前banner主题下的banner信息
    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerById($id)
    {
        //返回的结果是一个对象
        $banner = self::with('items','items.image')
            ->select($id);
        return $banner;
    }
}