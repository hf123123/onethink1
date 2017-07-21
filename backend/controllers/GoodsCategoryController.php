<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\web\HttpException;

class GoodsCategoryController extends \yii\web\Controller
{
    //添加商品分类
    public function actionAdd()
    {
        $model = new GoodsCategory();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //$model->save();
            //判断是否是添加一级分类
            if($model->parent_id){
                //非一级分类

                $category = GoodsCategory::findOne(['id'=>$model->parent_id]);
                if($category){
                    $model->prependTo($category);
                }else{
                    throw new HttpException(404,'上级分类不存在');
                }

            }else{
                //一级分类
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','分类添加成功');
            return $this->redirect(['index']);

        }
        return $this->render('add',['model'=>$model]);
    }

    //添加商品分类（ztree选择上级分类id）
    public function actionAdd2()
    {
        $model = new GoodsCategory(['parent_id'=>0]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //$model->save();
            //判断是否是添加一级分类
            if($model->parent_id){
                //非一级分类

                $category = GoodsCategory::findOne(['id'=>$model->parent_id]);
                if($category){
                    $model->prependTo($category);
                }else{
                    throw new HttpException(404,'上级分类不存在');
                }

            }else{
                //一级分类
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','分类添加成功');
            return $this->redirect(['index']);

        }
        //获取所以分类数据
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        return $this->render('add2',['model'=>$model,'categories'=>$categories]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    //测试嵌套集合插件的用法
    public function actionTest()
    {
        //创建一个根节点
        /*$category = new GoodsCategory();
        $category->name = '家用电器';
        $category->makeRoot();*/

        //创建子节点
        /*$category2 = new GoodsCategory();
        $category2->name = '小家电';
        $category = GoodsCategory::findOne(['id'=>1]);
        $category2->parent_id = $category->id;
        $category2->prependTo($category);*/

        //删除节点
        //$cate = GoodsCategory::findOne(['id'=>6])->delete();
        echo '操作完成';
    }

    //测试ztree
    public function actionZtree()
    {
        //$this->layout = false;
        //不加载布局文件
        return $this->renderPartial('ztree');
    }
}
