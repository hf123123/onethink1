<?php

namespace backend\controllers;

use backend\models\PasswordForm;
use backend\models\User;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class UserController extends \yii\web\Controller
{
    //添加管理员
    public function actionAdd()
    {
        $model = new User(['scenario'=>User::SCENARIO_ADD]);
        //$model->scenario = User::SCENARIO_ADD;//指定当前期场景

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $model->save();
            \Yii::$app->session->setFlash('success','用户添加成功');
            return $this->redirect(['index']);
        }

        return $this->render('add',['model'=>$model]);
    }
    //修改管理员
    public function actionEdit($id){

        $model = User::findOne(['id'=>$id]);
        $model->scenario = User::SCENARIO_EDIT;//指定当期场景为修改场景
        //var_dump($model->scenarios());exit;
        if($model==null){
            throw new NotFoundHttpException('用户不存在');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //var_dump($model);exit;

            $model->save();

            \Yii::$app->session->setFlash('success','用户修改成功');
            return $this->redirect(['index']);
        }

        return $this->render('add',['model'=>$model]);
    }
    //删除管理员
    //管理员列表
    public function actionIndex()
    {
        $query = User::find();
        $pager = new Pagination([
            'totalCount'=>$query->count(),
        ]);


        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['pager'=>$pager,'models'=>$models]);
    }

    //用户登录
    public function actionLogin()
    {
        $model = new User(['scenario'=>User::SCENARIO_LOGIN]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //var_dump($model);exit;
            if($model->login()){
                \Yii::$app->session->setFlash('sueecss','登录成功');
                return $this->redirect('index');
            }
        }else{
            //var_dump($model->getErrors());exit;
        }
        return $this->render('login',['model'=>$model]);
    }
    //获取用户登录状态
    public function actionUser()
    {
        //var_dump(\Yii::$app->user->isGuest);
        $admin = \Yii::$app->user->identity;
        var_dump(long2ip($admin->last_login_ip));
    }
    //注销
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->redirect(['user/login']);
    }

    //修改自己密码（登录状态才能使用）
    public function actionChPw(){
        //表单字段  旧密码 新密码 确认新密码
        //验证规则  都不能为空  验证旧密码是否正确  新密码不能和旧密码一样  确认新密码和新密码一样
        //表单验证通过 更新新密码
        $model = new PasswordForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //验证通过，更新新密码
            \Yii::$app->session->setFlash('success','密码修改成功');
            return $this->redirect(['index']);
        }

        return $this->render('password',['model'=>$model]);
    }


}
