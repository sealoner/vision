<?php
/**
 * User: sealone
 * Date: 2018/1/27
 * Time: 18:33
 */

namespace app\api\controller\v1;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    /**
     * 检查权限是否大于16
     */
    protected function checkPrimaryScope()
    {
        return TokenService::needPrimaryScope();
    }

    /**
     * 检查权限是否等于16（用户身份）
     */
    protected function checkExclusiveScope()
    {
        return TokenService::needExclusiveScope();
    }
}