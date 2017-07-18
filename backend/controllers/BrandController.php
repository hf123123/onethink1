<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class BrandController extends \yii\web\Controller
{
    //添加品牌
    public function actionAdd()
    {
        $model = new Brand();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','品牌添加成功');
            return $this->redirect(['brand/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    //修改品牌
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        if($model==null){//如果品牌不存在，则显示404页面
            throw new NotFoundHttpException('品牌不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','品牌添加成功');
            return $this->redirect(['brand/index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    //品牌列表
    public function actionIndex()
    {
        //只显示未删除的品牌，status != -1
        $query = Brand::find()->where(['!=','status','-1']);
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>10,
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);
    }
    //删除品牌
    public function actionDel($id){
        $model = Brand::findOne(['id'=>$id]);
        //逻辑删除，只修改状态，不真实删除数据
        if($model){
            $model->status = -1;
            $model->save();
        }
    }
}
