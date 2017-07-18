<?php
/* @var $this yii\web\View */
?>
<h1>文章分类列表</h1>
<table class="table table-bordered table-responsive">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->id?></td>
        <td><?=$model->name?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$model->id])?>
            <?=\yii\bootstrap\Html::a('删除',['article-category/del','id'=>$model->id])?></td>
    </tr>

    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget(['pagination'=>$pager])?>
