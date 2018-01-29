<?php
/**
 * Created by PhpStorm.
 * User: ptcc
 * Date: 2017/11/16
 * Time: 下午5:22
 * Author ： yuzi
 * --------------------------
 * Description: .
 */


/**
 * 记录每个异常的具体状态码，非业务代码
 */
return ;

/**** 异常码   ------  异常说明 *******
 *
 * 200	        正常处理了请求 ( 异常不允许使用该码 )
 * 400	        接口不存在
 * 401	        没有操作该接口的权限 ( 要求登录专用 )
 * 403	        APP版本不可用      ( 下载新版本 )
 * 500	        未知错误
 *
 *
 * 10000        通用错误
 * 10001        正常处理但未获取到信息;
 * 10002        处理失败(无信息)
 *
 *
 * 11000        参数错误
 * 11001        缺少参数
 * 11001        用户ID错误
 * 11002        参数已经被使用(唯一字段不可重复)
 * 11003        用户登录密码验证失败
 *
 *
 *
 *
 *
 * 20000        购物车错误
 * 20001        报价单错误
 *
 * 21000        支付
 *
 * 21100        提现错误
 *
 * 22000        个人中心
 * 22001        用户账户被禁用
 *
 * 22100        用户银行账户信息错误
 *
 * 23000        定制
 *
 * 24000        订单
 *
 * 24100        月结账单异常
 * 24200        月结订单资金流水信息异常 ／ 订单资金对账记录异常
 *
 * 24300        发票信息异常
 *
 * 25000        商品
 *
 * 25900        商品出入库异常
 *
 * 26000        文章
 *
 * 27000        文件处理异常
 * 27001        上传文件验证或者移动失败 ( 信息由具体情况决定 )
 * 27002        上传文件到 OSS 失败 ( 信息由具体情况决定 )
 * 27003        上传数据不可以为空
 * 27004        上传文件大小超出限制
 * 27005        临时文件目录错误 ( 信息由具体情况决定 )
 * 27006        上传文件临时保存失败
 * 27007        远程文件链接错误
 * 27008        上传文件时，post 的字段非文件
 * 27010        本地文件上传到Oss时，本地文件不存在
 * 27011
 *
 *
 * 28000        商品分类异常
 * 28001        分类不存在
 *
 * 29000        发送信息异常
 *
 * 30000        后台用户角色异常
 *
 * 31000        供应商商品错误
 *
 * 32000        供应商错误
 *
 * 33000        委外加工单异常
 * 33100        进货入库单异常
 * 33200        请配单异常
 *
 * 34000        企业用户信息异常（非权限相关）
 *
 * 34100        仓库管理异常
 * 34200        仓库商品库存信息异常
 *
 * 35000        退换货异常
 * 35001        已存在退换货
 *
 * 36000        退款异常
 * 36100        支付退款接口异常
 * 36101        支付宝退款接口异常
 * 36102        微信退款接口异常
 * 36103        余额退款异常
 * 36104        月结退款异常
 *
 * 40100        用户操作权限异常, 无此操作权限
 * 40101        缺少TOKEN参数         ( API 要求传递TOKEN专用 )
 * 40102        该TOKEN不存在或已过期, ( API 要求重新获取TOKEN专用 )
 * 40103        缺少ACCESS_TOKEN参数  ( API 登录验证专用 )
 * 40104        缺少支付密码
 * 40105        支付密码错误
 * 40106        登录过期 重新登录
 * 401          尚未登录,  会话中未保存ACCESS_TOKEN信息 ( API 登录验证专用 , 要求登录)
 * 401          登录失效,  ACCESS_TOKEN不符           ( API 登录验证专用 , 要求登录 )
 * 401          登录用户身份验证错误, 参数uid与登录不符  ( API 登录验证专用 , 要求登录 )
 *
 * 40111        用户账号被禁用
 * 40112        非企业用户, 不可访问企业用户操作
 * 40113        用户尚未被分配操作权限
 * 40114        权限被修改, 请重新登陆
 * 40115        企业用户的企业状态不是已通过审核
 *
 * 40121        被修改的用户非该企业所属 ( 企业管理后台 )
 * 40122        被修改的用户非该企业的附属用户
 * 40123        被修改与管理的部门非该企业所属
 * 40124        被修改的岗位角色并非该企业所属
 * 40125        要删除的岗位角色下有用户存在
 *
 *
 *
 * 50000        Runtime错误
 * 50001        配置文件错误
 * 50002        类属性未定义
 * 50003        类属性定义错误
 * 50004        内部类运行时提供的构造参数出错
 * 50005        内部方法运行时提供的参数出错
 * 50006        内部不能为空的数据 未获取到值
 *
 *
 * 60000       意见反馈异常
 *
 ******************************/