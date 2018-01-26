<?php
/**
 * Created by vision.
 * User: sealone
 * Date: 2017/11/26
 * Time: 下午7:35
 */

namespace app\api\controller\v2;

use app\api\validate\IDMustPositiveInt;
use app\lib\exception\BannerMissException;
use think\Controller;
use think\Exception;
use think\Validate;
use app\api\model\Banner as BannerModel;

class Banner extends Controller
{
    /**
     * 获取指定id的banner信息
     * @URL /banner/:id
     * @http GET
     * @id banner对应的id号
     */
    public function getBanner($id)
    {
        return "This is V2 Vision!";
    }
}