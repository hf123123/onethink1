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
        <td><?=\yii\bootstrap\Html::a('修改',['edit-permission','name'=>$model->name])?> 删除</td>
    </tr>
    <?php endforeach;?>
</table>