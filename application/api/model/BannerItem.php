<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{

    public function image()
    {
        return $this->belongsTo('Image', 'img_id','id');
    }
}
