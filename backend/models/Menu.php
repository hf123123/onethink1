<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $label
 * @property string $url
 * @property integer $parent_id
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label','parent_id','sort'], 'required'],
            [['parent_id', 'sort'], 'integer'],
            [['label'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => '名称',
            'url' => '地址/路由',
            'parent_id' => '上级菜单',
            'sort' => '排序',
        ];
    }
    //获取一级菜单选项
    public static function getMenuOptions()
    {
        //  [0=>'顶级菜单'] ， [1=>'文章管理',2=>'添加文章']  ===》[0=>'顶级菜单',1=>'文章管理',2=>'添加文章']
        return ArrayHelper::merge([''=>'=请选择上级菜单=',0=>'顶级菜单'],ArrayHelper::map(self::find()->where(['parent_id'=>0])->asArray()->all(),'id','label'));
    }
    //获取地址选项
    public static function getUrlOptions()
    {
        return  ArrayHelper::map(Yii::$app->authManager->getPermissions(),'name','name');
    }

    //获取子菜单  Menu[]
    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}
