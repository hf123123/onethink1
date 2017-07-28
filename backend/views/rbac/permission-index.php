<table class="table table-responsive table-bordered">
    <thead>
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $model):?>
    <tr>
        <td><?=$model->name?></td>
        <td><?=$model->description?></td>
        <td><?=\yii\bootstrap\Html::a('修改',['edit-permission','name'=>$model->name],['class'=>'btn btn-xs btn-warning'])?> 删除</td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php
/**
 * @var $this \yii\web\View
 */
#$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/dataTables.bootstrap.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({
language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Chinese.json"
    }
});');