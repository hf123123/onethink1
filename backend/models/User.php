<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_time
 * @property integer $last_login_ip
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;//明文密码
    public $rememberMe;

    public static $status_options=[
        10=>'启用',0=>'禁用'
    ];

    //定义场景常量
    const SCENARIO_ADD = 'add';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_EDIT = 'edit';
    //定义场景
    /*public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_ADD => [],//定义该场景下使用的字段（只有这些字段在该场景下会验证）
            self::SCENARIO_EDIT => ['username','password','email','status'],
        ];
        $scenarios2 = parent::scenarios();
        return ArrayHelper::merge($scenarios,$scenarios2);
    }*/

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['email'], 'required','on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            ['password', 'required','on'=>[self::SCENARIO_ADD,self::SCENARIO_LOGIN]],//该规则只在添加场景生效
            [['status', 'created_at', 'updated_at', 'last_login_time', 'last_login_ip'], 'integer','on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            [['username', 'password', 'password_reset_token', 'email'], 'string', 'max' => 255,'on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            [['auth_key'], 'string', 'max' => 32,'on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            [['username'], 'unique','on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            [['email'], 'unique','on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            [['password_reset_token'], 'unique','on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            //验证邮箱格式
            ['email','email','on'=>[self::SCENARIO_ADD,self::SCENARIO_EDIT]],
            ['rememberMe','boolean','on'=>self::SCENARIO_LOGIN],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
        ];
    }

    //save之前要执行的操作  必须返回true，否则save（）方法不会执行
    public function beforeSave($insert)
    {
        if($insert){
            $this->status = 10;
            $this->created_at = time();
            $this->auth_key = \Yii::$app->security->generateRandomString();
        }else{
            $this->updated_at = time();
        }
        if($this->password){
            $this->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        }

        return parent::beforeSave($insert);
    }

    public function login()
    {
        //1.1 通过用户名查找用户
        $admin = self::findOne(['username'=>$this->username]);
        if($admin){
            //用户存在
            //1.2 对比用户密码
            //没有加密 $admin->password == $model->password ,可能会被开除
            //md5 加密 $admin->password == md5($model->password)
            //yii2框架密码加密
            //密码加密
            //$password_hash = \Yii::$app->security->generatePasswordHash('明文密码');
            //验证密码
            //$result = \Yii::$app->security->validatePassword('明文密码','密文');

            if(\Yii::$app->security->validatePassword($this->password,$admin->password_hash)){
                //密码正确.可以登录
                //2 登录(保存用户信息到session)
                \Yii::$app->user->login($admin,$this->rememberMe?7*24*3600:0);
                //将登录时间和ip写入数据表
                $admin->last_login_time = time();
                $admin->last_login_ip = ip2long(Yii::$app->request->userIP);
                $admin->save();
                return true;
            }else{
                //密码错误.提示错误信息
                $this->addError('password','密码错误');
            }

        }else{
            //用户不存在,提示 用户不存在 错误信息
            $this->addError('username','用户名不存在');
        }
        return false;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key==$authKey;
    }
}
