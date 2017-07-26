<?php
namespace backend\models;

use yii\base\Model;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $permissions=[];

    public function rules()
    {
        return [
            [['name','description'],'required'],
            ['permissions','safe'],
            //角色名不能重复
            //['name']
        ];
    }
}