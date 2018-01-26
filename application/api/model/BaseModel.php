<?php
/**
 * User: sealone
 * Date: 2017/12/17
 * Time: 20:04
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{

    //定义属性读取器
    //这个方法名字的含义就是：获取image表中的url属性值，格式是固定的，如果要定义获取其他属性的读取器的名字，也需要这么写。
    protected function prefixImgUrl($value, $data)
    {
        $imgPath = $value;
        //$data是当前模型的所有的数组数据
        //判断返回值中的from属性值是否为1，为1，则图片是本地资源，不为1，则是网络图片资源
        if($data['from'] == 1) {
            $imgPath = config('setting.img_prefix').$value;
        }
        return $imgPath;
    }

}