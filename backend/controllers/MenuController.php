<?php

namespace backend\controllers;

use backend\models\Menu;
use yii\data\Pagination;

class MenuController extends \yii\web\Controller
{
    //添加菜单
    public function actionAdd()
    {
        $model = new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','菜单添加成功');
            return $this->refresh();
        }
        return $this->render('add',['model'=>$model]);
    }
    //修改菜单

    //删除菜单

    //菜单列表
    public function actionIndex()
    {
        $models = Menu::find()->where(['parent_id'=>0])->all();

        return $this->render('index',['models'=>$models]);
    }

}
