<?php
/**
 * User: sealone
 * Date: 2017/12/23
 * Time: 00:35
 */

namespace app\api\controller\v1;


use app\lib\exception\CategoryException;
use think\Controller;
use app\api\model\Category as CategoryModel;

class Category extends Controller
{
    //获取全部分类信息
    public function getAllCategories()
    {
        $categories = CategoryModel::getCategoriseForAll();
        if(!$categories) {
            throw new CategoryException();
        }
        return $categories;
    }
}