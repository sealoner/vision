<?php

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\lib\exception\ThemeException;
use think\Controller;
use think\Request;
use app\api\model\Theme as ThemeModel;

class Theme extends Controller
{
    //根据前端传递的ids，获取相应的主题信息
    public function getSimpleList($ids='')
    {
        $results = ThemeModel::getThemesByIDs($ids);
        if($results->isEmpty()){
            throw new ThemeException();
        }
        return $results;
    }

    //获取指定的某一个主题的详细信息（Theme的id号）
    public function getComplexOne($id='')
    {
        $result = ThemeModel::getThemeWithProducts($id);
        if($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;
    }
}
