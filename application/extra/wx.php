<?php
/**
 * User: sealone
 * Date: 2017/12/24
 * Time: 11:31
 */
return [
    'app_id'        =>  'wx5834096f8ffc068f',
    'app_secret'    =>  '05d97394d1124a8f07f3db41dfcc5839',

    //将要传入的参数，暂时先用%s代替
    'login_url'     =>  "https://api.weixin.qq.com/sns/jscode2session?".
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];