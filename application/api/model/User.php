<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 11:00
 */

namespace app\api\model;


class User extends BaseModel
{
    //与userAddress模型的关联
    public function address(){
        return $this->hasOne('userAddress', 'user_id', 'id');
    }

    //通过openid查找用户
    public static function getUser($openid)
    {
        $result = self::where('openid', '=', $openid)
                ->find();
        return $result;
    }

    //新增一条用户信息，并存入openid
    public static function createNewUser($openid)
    {
        $result = self::create([
            'openid'    =>  $openid,
        ]);
        return $result;
    }
}