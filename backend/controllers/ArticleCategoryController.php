<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class ArticleCategoryController extends \yii\web\Controller
{
    //添加文章分类
    public function actionAdd()
    {
        $model = new ArticleCategory();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            //$model->id;
            \Yii::$app->session->setFlash('success','文章分类添加成功');
            return $this->redirect(['article-category/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    //修改文章分类
    public function actionEdit($id)
    {
        $model = ArticleCategory::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('分类不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();

            \Yii::$app->session->setFlash('success','文章分类添加成功');
            return $this->redirect(['article-category/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    //文章分类列表
    public function actionIndex()
    {
        $query = ArticleCategory::find()->where(['!=','status','-1']);
        $pager = new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>10,
        ]);
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['models'=>$models,'pager'=>$pager]);

    }

    //删除文章分类
    public function actionDel($id){
        $model = ArticleCategory::findOne(['id'=>$id]);
        //逻辑删除，只修改状态，不真实删除数据
        if($model){
            $model->status = -1;
            $model->save();
        }
    }
}
