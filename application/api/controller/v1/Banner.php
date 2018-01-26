<?php
/**
 * Created by vision.
 * User: sealone
 * Date: 2017/11/26
 * Time: 下午7:35
 */

namespace app\api\controller\v1;

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
        //就像一个拦截器，先校验参数是否正确，正确则继续执行，不正确就中断
        //在这里，我们new的是IDMustPositiveInt类，它的主要作用就是判断id是否为正整数
        //如果需要其他的校验规则，则写其他的类，再调用gocheck()方法
        //验证id号是否符合规则
        //也可以简写成：
        //(new IDMustPositiveInt())->goCheck();)
        //AOP：面向切面编程
        $validate = new IDMustPositiveInt();
        $validate->goCheck();
        $bannerModel = new BannerModel();
        $banner = $bannerModel::getBannerById($id);
        if(!$banner){
            throw new BannerMissException();
        }
        //加载配置文件
        return $banner;
    }
}