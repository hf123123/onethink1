<?php

namespace frontend\controllers;

use backend\models\User;
use frontend\models\Member;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
    public $layout = false;
    //关闭csrf验证
    public $enableCsrfValidation = false;
    //用户注册
    public function actionRegister()
    {
        $model = new Member();
        $model->scenario = Member::SCENARIO_REGISTER;
        //if($model->load(\Yii::$app->request->post(),'Member') && $model->validate() ){
            //$model->save();
            //$model->getErrors()//    ['username'=>]
        //}
        //$model->validate();
        //var_dump($model->getErrors());exit;//    ['username'=>['用户名不能为空','用户名不能重复']，
        //‘password’=>['密码不能为空']]
        return $this->render('register',['model'=>$model]);
    }
    //AJAX表单验证
    public function actionAjaxRegister()
    {
        $model = new Member();
        $model->scenario = Member::SCENARIO_REGISTER;
        if($model->load(\Yii::$app->request->post()) && $model->validate() ){
            $model->save(false);
            //var_dump($model->getErrors());//    ['username'=>]
            //保存数据，提示保存成功
            return Json::encode(['status'=>true,'msg'=>'注册成功']);
        }else{
            //验证失败，提示错误信息

            return Json::encode(['status'=>false,'msg'=>$model->getErrors()]);
        }
    }


    //登录
    public function actionLogin()
    {
        return $this->render('login');
    }
    //用户地址
    public function actionAddress()
    {
        return $this->render('address');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
