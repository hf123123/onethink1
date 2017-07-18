<?php

namespace backend\controllers;

use backend\models\Brand;

class BrandController extends \yii\web\Controller
{
    //添加品牌
    public function actionAdd()
    {
        $model = new Brand();

        return $this->render('add',['model'=>$model]);
    }

    //修改品牌
    public function actionEdit($id){
        //
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
