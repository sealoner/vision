<?php
/**
 * User: sealone
 * Date: 2018/1/17
 * Time: 19:10
 */

namespace app\api\controller\v1;


use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\api\validate\SuccessMessage;
use app\api\validate\UserException;
use think\Controller;
use app\api\service\Token as TokenServer;

class Address extends Controller
{

    protected $beforeActionList = [
        //在调用createOrUpdateAddress接口之前，先执行Token接口
        'checkPrimaryScope' =>  ['only' => 'createOrUpdateAddress'],
    ];

    protected function checkPrimaryScope()
    {

    }


    /**
     * 创建和更新在没有特殊要求的情况下可以公用一个方法
     * @author xiefeng
     * @time 2018/1/17 19:11
     */
    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        //校验前端数据
        $validate->goCheck();
        //1、实例化模型，根据Token获取当前用户的uid
        $uid = TokenServer::getCurrentUid();
        //2、根据uid来查找用户数据，判断用户是否存在，如果不存在则抛出异常
        $user = UserModel::get($uid); //如果有，返回的是查询到的一条记录数据
        if(!$user) {
            throw new UserException();
        }
        //3、获取用户从客户端提交来的地址信息
        $dataArray = $validate->getDataByRule(input('post.'));

        //4、根据判断的用户信息是否存在，判断是更新数据还是新建数据
        $userAddress = $user->address;
        if(!$userAddress) {
            //不存在，新增
            $user->address()->save($dataArray);
        }else{
            //存在，更新
            $user->address->save($dataArray);
        }
        return json((new SuccessMessage()), 201);
    }
}