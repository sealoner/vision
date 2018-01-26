<?php
/**
 * User: sealone
 * Date: 2018/1/14
 * Time: 22:31
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }

}