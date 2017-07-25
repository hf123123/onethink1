<?php
/* @var $this yii\web\View */
?>
<h1>用户列表</h1>
<table class="table table-responsive table-bordered">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->username?></td>
        <td><?=$model->email?></td>
        <td><?=\backend\models\User::$status_options[$model->status]?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['user/edit','id'=>$model->id])?> 删除</td>
    </tr>

    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget(['pagination'=>$pager])?>