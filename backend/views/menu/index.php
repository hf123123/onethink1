<?php
/* @var $this yii\web\View */
?>
<h1>菜单列表</h1>
<table class="table">
    <tr>
        <th>名称</th>
        <th>路由</th>
        <th>排序</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->label?></td>
        <td><?=$model->url?></td>
        <td><?=$model->sort?></td>
    </tr>
        <?php foreach($model->children as $child):?>
            <tr>
                <td>——<?=$child->label?></td>
                <td><?=$child->url?></td>
                <td><?=$child->sort?></td>
            </tr>
        <?php endforeach;?>
    <?php endforeach;?>
</table>
