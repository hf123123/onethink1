<?php
/* @var $this yii\web\View */
?>
<h1>角色列表</h1>
<table class="table">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->description?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['edit-role','name'=>$model->name])?> 删除</td>
    </tr>
    <?php endforeach;?>
</table>
