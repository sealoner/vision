<?php
/**
 * User: sealone
 * Date: 2017/12/3
 * Time: 23:35
 * 处于api的同级的lib模块下，独立于其他模块之外，更好地被同级全局调用
 * 可以变成一个异常类库，甚至可以直接放到其他的项目中使用
 * 继承TP5自带的异常处理类，也就是Handle类
 */

namespace app\lib\exception;

use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandle extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //render()方法是TP5自带的渲染异常的方法，我们现在要覆盖它
    public function render(\Exception $e)
    {
        //异常大致有两种状态：用户造成的和服务器造成的，我们要对这两种状态分别进行判断
        //如果是用户造成的异常，那么就会涉及到业务，就需要向用户返回相关信息，那么就一定会实例化我们的BaseException类
        if($e instanceof BaseException){

            //如果是自定义的异常
            $this->code      = $e->code;
            $this->msg       = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            //判断是否开启TP5原生的异常处理方法
            if(config('app_debug')) {
                return parent::render($e);
            }

            $this->code      = 500;
            $this->msg       = '服务器内部错误';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }
        //获取当前请求的URL地址
        $request = Request::instance();

        $result = [
            'msg'         =>   $this->msg,
            'errorCode'   =>   $this->errorCode,
            'request_url' =>   $request->url(),
        ];
        return json($result, $this->code);
    }

    //日志记录方法
    public function recordErrorLog(Exception $e)
    {
        //因为我们在配置文件中已经将log给关闭了，所以我们需要先初始化log的配置信息
        Log::init([
            'type'  =>  'File',
            'level' =>  ['error'],
        ]);
        //log类下的静态方法record()是TP5默认的日志记录方法
        Log::record($e->getMessage(), 'error');
    }
}








